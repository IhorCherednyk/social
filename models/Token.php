<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property integer $id
 * @property string $code
 * @property integer $user_id
 * @property integer $expire_date
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'expire_date'], 'required'],
            [['user_id', 'expire_date'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    
    public static function findBySecretKey($key)
    {
        
        return static::findOne([
            'secret_key' => $key,
        ]);
    }
    
    public static function isSecretKeyExpire($date)
    {
        return $date >= time();
    }
    
    
    
    
    public function generateSecretKey()
    {
        $this->secret_key = Yii::$app->security->generateRandomString($length = 5);
        $this->expire_date = time() + Yii::$app->params['secretKeyExpire']; 
    }


}
