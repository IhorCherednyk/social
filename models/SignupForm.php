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
    public $role = 0;
    public $status = 0;
    public $last_login_date = 0;

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
    // Переходим из контроллера в эту функцию
    public function signup(){
        // Проверяем валидацию полей
        
        if($this->validate()){
           // если валидация успешно то создаем модель юзераипередаем в нее атрибуты которые мы получили из формы
           $user = new User();
           $user->attributes = $this->attributes;
           echo '<pre>';
           var_dump($user->attributes);
           var_dump($this->attributes);
           die;
           return $user->create();
        }
    }
}
