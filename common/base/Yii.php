<?php

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = include(__DIR__ . '/vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container;

/**
 * Class BaseApplication
 *
 * @property core\Common\Container\Container $container Container
 * @property \common\components\Website $website Website component.
 * @property \common\components\Catalogue $catalogue Catalogue component.
 * @property \common\components\Tecdoc $tecdoc Tecdoc component.
 * @property yii\db\Connection $tecdocDb.
 * @property yii\db\Connection $catalogueDb.
 * @property yii\db\Connection $grabberDb.
 * @property \common\components\DataImporter $dataImporter DataImporter component
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 */
class ConsoleApplication extends yii\console\Application
{
}