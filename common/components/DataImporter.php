<?php
namespace common\components;

use yii\base\Component;

use common\helpers\ExecutionTime;

class DataImporter extends Component
{

    const RUS_LNG_ID = 16;

    public $importedBrands = [
        "ACURA",
        "ALFA ROMEO",
        "AUDI",
        "BENTLEY",
        "BMW",
        "CADILLAC",
        "CHEVROLET",
        "CHRYSLER",
        "CITROEN",
        "DACIA",
        "DAEWOO",
        "DODGE",
        "FIAT",
        "FORD",
        "GEELY",
        "GMC",
        "HONDA",
        "HUMMER",
        "HYUNDAI",
        "INFINITI",
        "ISUZU",
        "IVECO",
        "JAGUAR",
        "JEEP",
        "KIA",
        "LADA",
        "LANCIA",
        "LAND ROVER",
        "LEXUS",
        "MAN",
        "MAZDA",
        "MERCEDES-BENZ",
        "MG",
        "MINI",
        "MITSUBISHI",
        "NISSAN",
        "OPEL",
        "PEUGEOT",
        "PORSCHE",
        "RENAULT",
        "ROLLS-ROYCE",
        "ROVER",
        "SAAB",
        "SCANIA",
        "SEAT",
        "SKODA",
        "SMART",
        "SSANGYONG",
        "SUBARU",
        "SUZUKI",
        "TATA",
        "TESLA",
        "TOYOTA",
        "VOLVO",
        "VW",
        "ZAZ",
    ];

    public function import($entity, $options = [])
    {
        switch ($entity) {
            case 'brands':
                $options['importedBrands'] = $this->importedBrands;
                $this->importBrands($options);
                break;
            case 'models':
                $this->importModels($options);
                break;
            case 'engines':
                $this->importEngines($options);
                break;
            case 'categories':
                $this->importCategories($options);
                break;
            default:
                throw new \InvalidArgumentException($entity . " - is not valid import type");
        }
    }

    /**
     * @param array $options
     * @throws \yii\db\Exception
     */
    protected function importBrands($options = [])
    {
        $importedBrands = $options['importedBrands'];
        array_walk(
            $importedBrands,
            function(&$item) {
                $item = "'" . $item . "'";
            }
        );
        $importedBrands = implode(", ", $importedBrands);
        $sql = "INSERT IGNORE INTO catalogue.brand
                SELECT
                    MFA_ID as `id`,
                    MFA_BRAND as `name`
                FROM tecdoc.manufacturers
                WHERE MFA_BRAND IN($importedBrands)
                  ON DUPLICATE KEY UPDATE catalogue.brand.id = catalogue.brand.id";

        \Yii::$app->tecdocDb
            ->createCommand($sql)
            ->execute();
    }

    /**
     * @param array $options
     * @throws \yii\db\Exception
     */
    protected function importModels($options = [])
    {
        $brandSql = "SELECT
                         distinct cb.id
                     FROM catalogue.brand AS cb
                     LEFT JOIN catalogue.model AS cm
                       ON cm.brandId = cb.id
                     WHERE cm.id IS NULL";
        $brands = \Yii::$app->tecdocDb
            ->createCommand($brandSql)
            ->bindValue(':lng', self::RUS_LNG_ID, \PDO::PARAM_INT)
            ->queryColumn();

        $total = count($brands);
        print PHP_EOL . "Total brands to be imported: " . $total . PHP_EOL;
        foreach ($brands as $brandId) {
            print PHP_EOL . "Brands left: " . $total . PHP_EOL;
            print PHP_EOL . "Start importing brandId models - $brandId" . PHP_EOL;
            ExecutionTime::start();
            $sql = "
                INSERT IGNORE INTO catalogue.model
                SELECT
                    MOD_ID AS `id`,
                    MOD_MFA_ID AS `brandId`,
                    TEX_TEXT AS `name`
                FROM tecdoc.models
                INNER JOIN tecdoc.country_designations ON CDS_ID = MOD_CDS_ID
                INNER JOIN tecdoc.des_texts ON TEX_ID = CDS_TEX_ID
                WHERE 1
                      AND CDS_LNG_ID = :lng
                      AND MOD_MFA_ID = :brandId
                ON DUPLICATE KEY UPDATE catalogue.model.id = catalogue.model.id";
            \Yii::$app->tecdocDb
                ->createCommand($sql)
                ->bindValue(':lng', self::RUS_LNG_ID, \PDO::PARAM_INT)
                ->bindValue(':brandId', $brandId, \PDO::PARAM_INT)
                ->execute();
            ExecutionTime::end();
            ExecutionTime::printResult();
            print PHP_EOL . "End importing brandId models - $brandId" . PHP_EOL;
            $total--;
        }
    }

    /**
     * @param array $options
     * @throws \yii\db\Exception
     */
    protected function importEngines($options = [])
    {
        $modelSql = "SELECT
                         distinct cm.id
                     FROM catalogue.model AS cm
                     LEFT JOIN catalogue.engine AS ce
                       ON ce.modelId = cm.id
                     WHERE ce.id IS NULL";
        $models = \Yii::$app->tecdocDb
            ->createCommand($modelSql)
            ->queryColumn();

        $total = count($models);
        print PHP_EOL . "Total models to be imported: " . $total . PHP_EOL;
        foreach ($models as $modelId) {
            print PHP_EOL . "Models left: " . $total . PHP_EOL;
            print PHP_EOL . "Start importing modelId engines - $modelId" . PHP_EOL;
            ExecutionTime::start();
            $sql = "
                INSERT IGNORE INTO catalogue.engine
                SELECT
                    TYP_ID as id,
                    TYP_MOD_ID as modelId,
                    des_texts.TEX_TEXT AS engine,
                    TYP_PCON_START as `year`,
                    TYP_HP_FROM as horsePower
                FROM tecdoc.types
                INNER JOIN tecdoc.models ON MOD_ID = TYP_MOD_ID
                INNER JOIN tecdoc.manufacturers ON MFA_ID = MOD_MFA_ID
                INNER JOIN tecdoc.country_designations AS COUNTRY_DESIGNATIONS2 ON COUNTRY_DESIGNATIONS2.CDS_ID = MOD_CDS_ID AND COUNTRY_DESIGNATIONS2.CDS_LNG_ID = 16
                INNER JOIN tecdoc.des_texts AS DES_TEXTS7 ON DES_TEXTS7.TEX_ID = COUNTRY_DESIGNATIONS2.CDS_TEX_ID
                INNER JOIN tecdoc.country_designations ON country_designations.CDS_ID = TYP_CDS_ID AND country_designations.CDS_LNG_ID = 16
                INNER JOIN tecdoc.des_texts ON des_texts.TEX_ID = country_designations.CDS_TEX_ID
                LEFT JOIN tecdoc.designations ON designations.DES_ID = TYP_KV_ENGINE_DES_ID AND designations.DES_LNG_ID = 16
                LEFT JOIN tecdoc.des_texts AS DES_TEXTS2 ON DES_TEXTS2.TEX_ID = designations.DES_TEX_ID
                LEFT JOIN tecdoc.designations AS DESIGNATIONS2 ON DESIGNATIONS2.DES_ID = TYP_KV_FUEL_DES_ID AND DESIGNATIONS2.DES_LNG_ID = 16
                LEFT JOIN tecdoc.des_texts AS DES_TEXTS3 ON DES_TEXTS3.TEX_ID = DESIGNATIONS2.DES_TEX_ID
                LEFT JOIN tecdoc.link_typ_eng ON LTE_TYP_ID = TYP_ID
                LEFT JOIN tecdoc.engines ON ENG_ID = LTE_ENG_ID
                LEFT JOIN tecdoc.designations AS DESIGNATIONS3 ON DESIGNATIONS3.DES_ID = TYP_KV_BODY_DES_ID AND DESIGNATIONS3.DES_LNG_ID = 16
                LEFT JOIN tecdoc.des_texts AS DES_TEXTS4 ON DES_TEXTS4.TEX_ID = DESIGNATIONS3.DES_TEX_ID
                LEFT JOIN tecdoc.designations AS DESIGNATIONS4 ON DESIGNATIONS4.DES_ID = TYP_KV_MODEL_DES_ID AND DESIGNATIONS4.DES_LNG_ID = 16
                LEFT JOIN tecdoc.des_texts AS DES_TEXTS5 ON DES_TEXTS5.TEX_ID = DESIGNATIONS4.DES_TEX_ID
                LEFT JOIN tecdoc.designations AS DESIGNATIONS5 ON DESIGNATIONS5.DES_ID = TYP_KV_AXLE_DES_ID AND DESIGNATIONS5.DES_LNG_ID = 16
                LEFT JOIN tecdoc.des_texts AS DES_TEXTS6 ON DES_TEXTS6.TEX_ID = DESIGNATIONS5.DES_TEX_ID
                WHERE TYP_MOD_ID = :modelId
                  ON DUPLICATE KEY UPDATE catalogue.engine.horsePower = catalogue.engine.horsePower";
            \Yii::$app->tecdocDb
                ->createCommand($sql)
                ->bindValue(':modelId', $modelId, \PDO::PARAM_INT)
                ->execute();
            ExecutionTime::end();
            ExecutionTime::printResult();
            print PHP_EOL . "End importing modelId engines - $modelId" . PHP_EOL;
            $total--;
        }
    }

    /**
     * @param array $options
     * @throws \yii\db\Exception
     */
    protected function importCategories($options = [])
    {
        //@TODO: add possibility to check if full reimport of engine is needed
        $engineSql = "SELECT
                         distinct ce.id
                     FROM catalogue.engine AS ce
                     LEFT JOIN catalogue.category AS cc
                       ON cc.engineId = ce.id
                     WHERE cc.id IS NULL";
        $engines = \Yii::$app->tecdocDb
            ->createCommand($engineSql)
            ->queryColumn();

        $total = count($engines);
        print PHP_EOL . "Total engines to be imported: " . $total . PHP_EOL;
        foreach ($engines as $engineId) {
            print PHP_EOL . "Engines left: " . $total . PHP_EOL;
            print PHP_EOL . "Start importing engineId categories - $engineId" . PHP_EOL;
            ExecutionTime::start();

//            $sql = "";
//            \Yii::$app->tecdocDb
//                ->createCommand($sql)
//                ->bindValue(':modelId', $modelId, \PDO::PARAM_INT)
//                ->execute();

            ExecutionTime::end();
            ExecutionTime::printResult();
            print PHP_EOL . "End importing engineId categories - $engineId" . PHP_EOL;
            $total--;
        }
    }
}