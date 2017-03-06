<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
//    попадаем сюда из GetUser() loginForm.php в качестве параметра мы принимае то что ввел пользователь в поле name(login)
    public static function findByUsername($username) {
        // здесь мы смотрм в базе есть ли у нас пользователь с таким логином если есть возвращем  обьект данных о юзере
        return User::find()->where(['login'=> $username])->one();
    }
    
    
    public function getAuthKey() {
        //asdad
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        //asd
    }

    public static function findIdentity($id) {
        return User::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        //asd
    }
    
    public static function tableName() {
        return 'user';  // указывает таблицу которую мы будем использовать
    }

    public function validatePassword($password) {
       
        return ($this->password == $password) ? true : false;
    }

}
