<?php
namespace common\components;

use yii\base\Component;

class Tecdoc extends Component
{
    const RUSSIAN_LNG_ID = 16;

    const ROOT_CATEGORY_ID = 10001;

    public function getBrands() {
        $sql = "SELECT
                    MFA_ID as id,
                    MFA_BRAND as name
                FROM manufacturers
                ORDER BY name";
        return \Yii::$app->tecdocDb
            ->createCommand($sql)
            ->queryAll();
    }

    public function getModelsByBrandId($brandId) {
        $sql = "SELECT
                    MOD_ID AS id,
                    TEX_TEXT AS name
                FROM models
                INNER JOIN country_designations ON CDS_ID = MOD_CDS_ID
                INNER JOIN des_texts ON TEX_ID = CDS_TEX_ID
                WHERE MOD_MFA_ID = :brandId AND CDS_LNG_ID = :lng
                ORDER BY name";
        return \Yii::$app->tecdocDb
            ->createCommand($sql)
            ->bindValue(':lng', self::RUSSIAN_LNG_ID, \PDO::PARAM_INT)
            ->bindValue(':brandId', $brandId, \PDO::PARAM_INT)
            ->queryAll();
    }

    public function getEnginesByModelId($modelId) {
        $sql = "SELECT
                    TYP_ID as id,
                    MFA_BRAND as brand,
                    des_texts7.TEX_TEXT AS model,
                    des_texts.TEX_TEXT AS engine,
                    TYP_PCON_START as year_start,
                    TYP_PCON_END as year_end,
                    TYP_CCM,
                    TYP_KW_FROM as kw_from,
                    TYP_KW_UPTO as kw_to,
                    TYP_HP_FROM as hp_from,
                    TYP_HP_UPTO as hp_to,
                    TYP_CYLINDERS,
                    engines.ENG_CODE,
                    des_texts2.TEX_TEXT AS TYP_ENGINE_DES_TEXT,
                    des_texts3.TEX_TEXT AS TYP_FUEL_DES_TEXT,
                    IFNULL(des_texts4.TEX_TEXT, des_texts5.TEX_TEXT) AS TYP_BODY_DES_TEXT,
                    des_texts6.TEX_TEXT AS TYP_AXLE_DES_TEXT,
                    TYP_MAX_WEIGHT
                FROM types
                INNER JOIN models ON MOD_ID = TYP_MOD_ID
                INNER JOIN manufacturers ON MFA_ID = MOD_MFA_ID
                INNER JOIN country_designations AS COUNTRY_designations2 ON COUNTRY_designations2.CDS_ID = MOD_CDS_ID AND COUNTRY_designations2.CDS_LNG_ID = :lng
                INNER JOIN des_texts AS des_texts7 ON des_texts7.TEX_ID = COUNTRY_designations2.CDS_TEX_ID
                INNER JOIN country_designations ON country_designations.CDS_ID = TYP_CDS_ID AND country_designations.CDS_LNG_ID = :lng
                INNER JOIN des_texts ON des_texts.TEX_ID = country_designations.CDS_TEX_ID
                LEFT JOIN designations ON designations.DES_ID = TYP_KV_ENGINE_DES_ID AND designations.DES_LNG_ID = :lng
                LEFT JOIN des_texts AS des_texts2 ON des_texts2.TEX_ID = designations.DES_TEX_ID
                LEFT JOIN designations AS designations2 ON designations2.DES_ID = TYP_KV_FUEL_DES_ID AND designations2.DES_LNG_ID = :lng
                LEFT JOIN des_texts AS des_texts3 ON des_texts3.TEX_ID = designations2.DES_TEX_ID
                LEFT JOIN link_typ_eng ON LTE_TYP_ID = TYP_ID
                LEFT JOIN engines ON ENG_ID = LTE_ENG_ID
                LEFT JOIN designations AS designations3 ON designations3.DES_ID = TYP_KV_BODY_DES_ID AND designations3.DES_LNG_ID = :lng
                LEFT JOIN des_texts AS des_texts4 ON des_texts4.TEX_ID = designations3.DES_TEX_ID
                LEFT JOIN designations AS designations4 ON designations4.DES_ID = TYP_KV_MODEL_DES_ID AND designations4.DES_LNG_ID = :lng
                LEFT JOIN des_texts AS des_texts5 ON des_texts5.TEX_ID = designations4.DES_TEX_ID
                LEFT JOIN designations AS designations5 ON designations5.DES_ID = TYP_KV_AXLE_DES_ID AND designations5.DES_LNG_ID = :lng
                LEFT JOIN des_texts AS des_texts6 ON des_texts6.TEX_ID = designations5.DES_TEX_ID
                WHERE TYP_MOD_ID = :modelId
                ORDER BY MFA_BRAND, model, engine, TYP_PCON_START, TYP_CCM";
        $rows = \Yii::$app->tecdocDb
            ->createCommand($sql)
            ->bindValue(':lng', self::RUSSIAN_LNG_ID, \PDO::PARAM_INT)
            ->bindValue(':modelId', $modelId, \PDO::PARAM_INT)
            ->queryAll();

        $engines = [];
        foreach ($rows as $row) {
            $engine = new Engine();
            $engine->setId($row['id']);
            $engine->setBrand($row['brand']);
            $engine->setModel($row['model']);
            $engine->setEngine($row['engine']);
            $engine->setYearStart($row['year_start']);
            $engine->setYearEnd($row['year_end']);
            $engine->setKwFrom($row['kw_from']);
            $engine->setKwTo($row['kw_to']);
            $engine->setHpFrom($row['hp_from']);
            $engine->setHpTo($row['hp_to']);
            $engines[] = $engine;
        }

        return $engines;
    }

    /**
     * @param int $engineId
     * @param int $categoryId
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getCategoriesByEngineId(int $engineId, int $categoryId = self::ROOT_CATEGORY_ID) : array
    {
        if (!$engineId) {
            throw new \InvalidArgumentException('engineId is required param');
        }
        if ($categoryId === 0) {
            $categoryId = self::ROOT_CATEGORY_ID;
        }
        $sql = "SELECT
                    STR_ID as id,
                    TEX_TEXT AS name,
                    IF(
                      EXISTS(
                          SELECT
                              *
                          FROM tecdoc.search_tree AS SEARCH_TREE2
                          WHERE SEARCH_TREE2.STR_ID_PARENT <=> search_tree.STR_ID LIMIT 1
                      ),
                      1,
                      0
                    ) AS hasChild
                FROM tecdoc.search_tree
                INNER JOIN tecdoc.designations ON DES_ID = STR_DES_ID
                INNER JOIN tecdoc.des_texts ON TEX_ID = DES_TEX_ID
                WHERE STR_ID_PARENT <=> :categoryId
                  AND DES_LNG_ID = :lng
                  AND EXISTS (
                          SELECT
                              *
                          FROM tecdoc.link_ga_str
                          INNER JOIN tecdoc.link_la_typ
                            ON LAT_TYP_ID = :engineId
                            AND LAT_GA_ID = LGS_GA_ID
                          INNER JOIN tecdoc.link_art
                            ON LA_ID = LAT_LA_ID
                            WHERE LGS_STR_ID = STR_ID
                            LIMIT 1
                      )";

        return \Yii::$app->tecdocDb
            ->createCommand($sql)
            ->bindValue(':engineId', $engineId, \PDO::PARAM_INT)
            ->bindValue(':categoryId', $categoryId, \PDO::PARAM_INT)
            ->bindValue(':lng', self::RUSSIAN_LNG_ID, \PDO::PARAM_INT)
            ->queryAll();
    }

    public function getCategoryArticle(int $categoryId, int $engineId)
    {
        $sql = "SELECT	LA_ART_ID AS article
                FROM link_ga_str
                INNER JOIN link_la_typ ON LAT_TYP_ID = :engineId AND LAT_GA_ID = LGS_GA_ID
                INNER JOIN link_art ON LA_ID = LAT_LA_ID
                WHERE LGS_STR_ID <=> :categoryId
                ORDER BY LA_ART_ID";
        return \Yii::$app->tecdocDb
            ->createCommand($sql)
            ->bindValue(':categoryId', $categoryId, \PDO::PARAM_INT)
            ->bindValue(':engineId', $engineId, \PDO::PARAM_INT)
            ->queryAll();
    }

    public function getArticleByIds(array $articleIds)
    {
        $inQuery = implode(',', array_fill(0, count($articleIds), '?'));
        $sql = "SELECT
                    ART_ARTICLE_NR AS article,
                    SUP_BRAND AS brand,
                    des_texts.TEX_TEXT AS name,
                    des_texts2.TEX_TEXT AS description
                FROM articles
                INNER JOIN designations ON designations.DES_ID = ART_COMPLETE_DES_ID AND designations.DES_LNG_ID = 16
                INNER JOIN des_texts ON des_texts.TEX_ID = designations.DES_TEX_ID
                LEFT JOIN designations AS designations2 ON designations2.DES_ID = ART_DES_ID
                LEFT JOIN des_texts AS des_texts2 ON des_texts2.TEX_ID = designations2.DES_TEX_ID
                INNER JOIN suppliers ON SUP_ID = ART_SUP_ID
                INNER JOIN art_country_specifics ON ACS_ART_ID = ART_ID
                INNER JOIN designations AS designations3 ON designations3.DES_ID = ACS_KV_STATUS_DES_ID AND designations3.DES_LNG_ID = 16
                INNER JOIN des_texts AS des_texts3 ON des_texts3.TEX_ID = designations3.DES_TEX_ID
                WHERE ART_ID IN ($inQuery)";
//        $sql = "
//        SELECT ACR_ART_ID, des_texts.TEX_TEXT AS CRITERIA_DES_TEXT, IFNULL(des_texts2.TEX_TEXT, ACR_VALUE) AS CRITERIA_VALUE_TEXT
//        FROM article_criteria
//        LEFT JOIN designations AS designations2 ON designations2.DES_ID = ACR_KV_DES_ID
//        LEFT JOIN des_texts AS des_texts2 ON des_texts2.TEX_ID = designations2.DES_TEX_ID
//        LEFT JOIN criteria ON CRI_ID = ACR_CRI_ID
//        LEFT JOIN designations ON designations.DES_ID = CRI_DES_ID
//        LEFT JOIN des_texts ON des_texts.TEX_ID = designations.DES_TEX_ID
//        WHERE ACR_ART_ID IN ($inQuery) AND (designations.DES_LNG_ID IS NULL OR designations.DES_LNG_ID = 16) AND (designations2.DES_LNG_ID IS NULL OR designations2.DES_LNG_ID = 16);";
        $command = \Yii::$app->tecdocDb
            ->createCommand($sql);
        foreach ($articleIds as $key => $articleId) {
            $command->bindValue($key + 1, $articleId);
        }
        return $command->queryAll();
    }
}