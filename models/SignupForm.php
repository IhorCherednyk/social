<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $login;
    public $password;
    public $email;
    public $name;
    public $sername;

    public function rules()
    {
        return [
            [['login', 'password','email','name','sername'], 'required'],
            [['name','sername'], 'string'],
            [['email'], 'email'],
            [['email'],'unique', 'targetClass'=> 'app\models\User', 'targetAttribute'=>'email'],
            [['login'],'unique', 'targetClass'=> 'app\models\User', 'targetAttribute'=>'login']
        ];

    }
    public function validateLogin($attribute, $params)
    {

    }
    

    public function login()
    {

    }

    public function getUser()
    {

       
    }
}
