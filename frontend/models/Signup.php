<?php

namespace frontend\models;
use yii\base\Model;
use common\models\User;

class Signup extends  Model
{
    public $name;
    public $lastname;
    public $email;
    public $phone;
    public $password;
    public $createdat;



    public function rules()
    {
        return [
            [['name','email','password'],'required'],
            ['name','string'],
            ['lastname','string'],
            ['lastname','string'],
            ['email','email'],
            ['phone','string'],
            ['name','unique','targetClass'=>'common\models\User'],
            ['email','unique','targetClass'=>'common\models\User'],
            ['password','string','min'=>2,'max'=>64],


        ];
    }

    public function signup()
    {
        $user = new User();
        $user->name = $this->name;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        return $user->save();

    }
}
