<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 10;

    public $password;

    public function rules() {
        return [
                [['username', 'email', 'password'], 'filter', 'filter' => 'trim'],
                [['username', 'email', 'status'], 'required'],
                ['email', 'email'],
                ['username', 'string', 'min' => 2, 'max' => 255],
                ['password', 'required', 'on' => 'create'],
                ['username', 'unique', 'message' => 'this name already exist'],
                ['email', 'unique', 'message' => 'this email already exist.'],
        ];
    }

//    ВОПРОСЫ
//    1. не показуется setFlash
//    2. как пофиксить баг с логаутом
//    СВЯЗИ
    public function getProfile() {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }
    public function getToken()
    {
        return $this->hasMany(Token::className(), ['user_id' => 'id']);
    }
    
    /* Поведения */

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

//    HELPERS
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey() {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function init() {
        parent::init();
        Yii::$app->user->on(\yii\web\User::EVENT_AFTER_LOGIN, [$this, 'addLastLogin']);
    }

    public function addLastLogin() {
        $this->touch('last_login_date'); // last login db field
    }

// Search 
    public static function findByUsername($username) {
        return static::findOne([
                    'username' => $username
        ]);
    }
    public static function findById($id) {
        return static::findOne([
                    'id' => $id
        ]);
    }
// IdentityInterface


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
        return static::findOne([
                    'id' => $id,
                    'status' => self::STATUS_ACTIVE
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        //используется если у нас не потдерживаются сесии
    }

    public static function tableName() {
        return 'user';
    }

}
