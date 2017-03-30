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
    
    public function sendEmail($id){
        $email = $this->findById($id);
        if($email){
            return Yii::$app->mailer->compose('activationEmail', ['user' => $user])
                            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' (отправлено роботом)'])
                            ->setTo($this->email)
                            ->setSubject('Сброс пароля для ' . Yii::$app->name)
                            ->send();
        }
    }
    
    public static function findById($id) {
        return static::findOne([
                    'id' => $id
        ]);
    }

}
