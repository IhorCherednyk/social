<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
//    попадаем сюда из GetUser() loginForm.php в качестве параметра мы принимае то что ввел пользователь в поле name(login)
    public static function findByUsername($login) {
        // здесь мы смотрм в базе есть ли у нас пользователь с таким логином если есть возвращем  обьект данных о юзере
        return User::find()->where(['login'=> $login])->one();
    }
    
    public function rules()
    {
        return [
            [['login', 'password','email','name','sername',], 'required'],
            [['name','sername'], 'string'],
            [['email'], 'email'],
            [['role', 'status', 'last_login_date'], 'safe'],
//            [['role', 'status'] , 'integer']
        ];

    }
    
    
    public function getAuthKey() {
        return $this->auth_key;
    }
    
    public function validateAuthKey($authKey) {
        return $this->auth_key === $authKey;
    }

    public function getId() {
        return $this->id;
    }
    
    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        //используется если у нас не потдерживаются сесии
    }
    
    public static function tableName() {
        return 'user';  // указывает таблицу которую мы будем использовать
    }

    public function validatePassword($password) {
       
        if (Yii::$app->getSecurity()->validatePassword($password, $this->password)) {
            return true;
        }
        return false;
    }
    
    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

}
