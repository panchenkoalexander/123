<?php
namespace common\components;

use yii\helpers\ArrayHelper;

class View extends \yii\web\View
{
    /**
     * @const path delimiter. Need to split path to application path and view path.
     */
    const VIEWS_DELIMITER = 'views';

    public function renderFile($viewFile, $params = [], $context = null) {
        /**
         * TODO: move to some storage
         */
        $sites = [
            1 => 'first',
            2 => 'second'
        ];
        $websiteFolderName = ArrayHelper::getValue($sites, $this->_getCurrentWebsiteId(), null);
        list($appPath, $viewFilePath) = explode(self::VIEWS_DELIMITER, $viewFile);
        $webSiteViewFile = $appPath
            . self::VIEWS_DELIMITER
            . DIRECTORY_SEPARATOR
            . $websiteFolderName
            . $viewFilePath;
        if (is_file($webSiteViewFile)) {
            $viewFile = $webSiteViewFile;
        }
        return parent::renderFile($viewFile, $params, $context);
    }

    /**
     * @param $viewFolder
     * @return bool
     */
    protected function _isWebsiteViewFolderExist($viewFolder) {
        return file_exists($viewFolder);
    }

    protected function _getCurrentWebsiteId() {
        return \Yii::$app->website->getId();
    }
}