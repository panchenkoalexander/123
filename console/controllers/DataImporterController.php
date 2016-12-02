<?php
namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

class DataImporterController extends Controller
{
    public $message;

    protected $countBeforeImport = 0;

    protected $countAfterImport = 0;

//    public function options()
//    {
//        return ['message'];
//    }

    public function optionAliases()
    {
        return ['m' => 'message'];
    }

    public function actionBrands()
    {
        $this->importStart('brand');
        try {
            \Yii::$app->dataImporter->import('brands');
        } catch (\Exception $e) {
            echo $this->ansiFormat($e->getMessage(), Console::FG_RED);
            echo "\r\n";
        }
        $this->importEnd('brand');
    }

    public function actionModels()
    {
        $this->importStart('model');
        try {
            \Yii::$app->dataImporter->import('models');
        } catch (\Exception $e) {
            echo $this->ansiFormat($e->getMessage(), Console::FG_RED);
            echo "\r\n";
        }
        $this->importEnd('model');
    }

    public function actionEngines()
    {
        $this->importStart('engine');
        try {
            \Yii::$app->dataImporter->import('engines');
        } catch (\Exception $e) {
            echo $this->ansiFormat($e->getMessage(), Console::FG_RED);
        }
        $this->importEnd('engine');
    }

    public function actionCategories()
    {
        $this->importStart('category');
        try {
            \Yii::$app->dataImporter->import('categories');
        } catch (\Exception $e) {
            echo $this->ansiFormat($e->getMessage(), Console::FG_RED);
        }
        $this->importEnd('category');
    }

    protected function importStart($name)
    {
        $this->countBeforeImport = \Yii::$app->catalogueDb->createCommand("SELECT COUNT(*) FROM $name")->queryScalar();
        echo '[' . date('Y-m-d H:i:s') . ']: ';
        echo $this->ansiFormat('Rows in `$name` before: ' . $this->countBeforeImport, Console::FG_BLUE);
        echo "\r\n";
    }

    protected function importEnd($name)
    {
        $this->countAfterImport = \Yii::$app->catalogueDb->createCommand("SELECT COUNT(*) FROM $name")->queryScalar();
        $diff = ($this->countBeforeImport - $this->countAfterImport) * -1;
        echo '[' . date('Y-m-d H:i:s') . ']: ';
        echo $this->ansiFormat(
            'New rows in `$name`: ' . $diff,
            $this->countAfterImport > $this->countBeforeImport ? Console::FG_GREEN : Console::FG_BLUE
        );
        echo "\r\n";
        echo '[' . date('Y-m-d H:i:s') . ']: ';
        echo $this->ansiFormat(
            'Rows in `$name` after: ' . $this->countAfterImport,
            $this->countAfterImport > $this->countBeforeImport ? Console::FG_GREEN : Console::FG_BLUE
        );
        echo "\r\n";
    }
}