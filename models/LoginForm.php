<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = null;
    public $status;

    public function rules() {

        return [
                [['username', 'password'], 'required', 'on' => 'default'],
                ['rememberMe', 'boolean'],
                ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute) {
        if (!$this->hasErrors()):
            $this->getUser();
           
            if (is_null($this->_user) || !$this->_user->validatePassword($this->password)):
                $this->addError($attribute, 'Неправильный логин или пароль.');
            endif;
        endif;
    }

    public function login() {
        
        if ($this->validate()){
            if ($this->_user->status === User::STATUS_ACTIVE){
                return Yii::$app->user->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        return false;
    }

    public function getUser() {
          
        if (is_null($this->_user)):
            $this->_user = User::findByUsername($this->username);
        endif;
        
        return $this->_user;
    }

}
