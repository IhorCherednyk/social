<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegForm extends Model {

    public $username;
    public $email;
    public $password;
    public $status;
    public $password_repeat;
    public $first_name;
    public $last_name;

    public function rules() {
        return [
                [['username', 'email', 'password'], 'filter', 'filter' => 'trim'], // удаляем пробелы вокруг
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't equal" ],
            [['username', 'email', 'password','first_name', 'last_name'], 'required'], // обязательны
            ['username', 'string', 'min' => 2, 'max' => 255], // содержать 2-255 символов
            ['password', 'string', 'min' => 2, 'max' => 255], // содержать 2-255
            [['email'], 'unique', 'targetClass' => User::className(), 'message' => 'this email already exist'], //уникальность
            ['email', 'email'], //
            [['username'], 'unique', 'targetClass' => User::className(), 'message' => 'this username already exist'], //уникальность
            ['status', 'default', 'value' => User::STATUS_NOT_ACTIVE], //говорит что если в поле null то по умолчанию применяется Value 'on' => указывает на состояние


        ];
    }

    public function reg() {
        $user = new User();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailActivationKey();
        $user->setAttributes($this->attributes);
        if($user->save()){
            $profile = new Profile();
            $profile->setAttributes($this->attributes);
            $profile->link('user',$user);
            return $user;
        }
        return null;
    }
    
    


}
