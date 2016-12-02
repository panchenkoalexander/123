<?php
namespace common\components;

use yii\base\Component;

class Website extends Component
{
    public function getId() {
        return array_rand([1,2,3,4]);
    }
}