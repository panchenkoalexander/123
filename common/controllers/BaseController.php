<?php
namespace common\controllers;

use yii\base\Controller;
use yii\helpers\Json;

/**
 * Base controller
 */
class BaseController extends Controller
{
    /**
     * @param $data
     * @throws \yii\base\ExitException
     */
    public function responseSuccess(array $data) {
        $response = [
            'result' => 'ok',
            'data' => $data
        ];
        echo Json::encode($response);
        \Yii::$app->end();
    }

    /**
     * @param $error
     * @throws \yii\base\ExitException
     */
    public function responseError(string $error) {
        $response = [
            'result' => 'fail',
            'data' => $error
        ];
        echo Json::encode($response);
        \Yii::$app->end();
    }

    /**
     * @param string $paramName
     * @return array|mixed
     */
    public function getParam(string $paramName)
    {
        return \Yii::$app->request->get($paramName);
    }
}
