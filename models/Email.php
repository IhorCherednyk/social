<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "{{%email}}".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property string $recipient_email
 * @property string $data
 * @property integer $date_created
 */
class Email extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const EMAIL_ACTIVATE = 0;
    const EMAIL_RESETPASSWORD = 1;
    const STATUS_SUCCSSES = 2;
    const STATUS_NOTSUCCSSES = 3;
    const STATUS_ERROR = 4;

    public static function tableName() {
        return '{{%email}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['status', 'type'], 'integer'],
                [['type', 'recipient_email', 'data'], 'required'],
                [['recipient_email', 'data'], 'string', 'max' => 255],
        ];
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'type' => 'Type',
            'recipient_email' => 'Recipient Email',
            'data' => 'Data',
            'date_created' => 'Date Created',
        ];
    }
    
    public function createEmail($user,$status, $token = null){
        $this->type = $status;
        $this->status = $this::STATUS_NOTSUCCSSES;
        $this->recipient_email = $user->email;
        (is_null($token))?$this->data = $user->email_activation_key: $this->data = $token;
        if ($this->save()) {
          
        }
    }
    
    public static function findByUserEmail($email) {
        return static::findOne([
                    'recipient_email' => $email,
                    'type' => self::EMAIL_ACTIVATE
        ]);
    }
    public static function findByUserToken($key) {
        return static::findOne([
                    'data' => $key,
                    'type' => self::EMAIL_RESETPASSWORD
        ]);
    }

}
