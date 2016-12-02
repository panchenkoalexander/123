<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

class Login extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email','password'],'required'],
            ['email','email'],
            ['password','validatePassword']
        ];
    }

    public function validatePassword($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $user = $this->getUser();
            if(!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute,'Пароль или пользователь введены не верно');
            }
        }
    }

    public function getUser()
    {
        return User::findOne(['email'=>$this->email]);
    }
}
