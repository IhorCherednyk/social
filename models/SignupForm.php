<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $password;
    public $login;
    public $email;
    public $name;
    public $sername;
    public $password_repeat;


    public function rules()
    {
        return [
            [['login', 'password','email','name','sername'], 'required'],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't equal" ],
            [['name','sername'], 'string'],
            [['email'], 'email'],
            [['email'],'unique', 'targetClass'=> 'app\models\User', 'targetAttribute'=>'email'],
            [['login'],'unique', 'targetClass'=> 'app\models\User', 'targetAttribute'=>'login']
        ];

    }
    // Переходим из контроллера в эту функцию
    public function signup(){
        // Проверяем валидацию полей
        
        if($this->validate()){
           // если валидация успешно то создаем модель юзераипередаем в нее атрибуты которые мы получили из формы
           $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
           
           
           $user = new User();
         
           $user->load($this->attributes, '');
           return $user->save();
        }
    }
}

