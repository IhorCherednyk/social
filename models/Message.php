<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;


class Message extends \yii\db\ActiveRecord {

    const STATUS_UNREADED = 0;
    const STATUS_READED = 1;
    const MESSAGE_INCOMING = 2;
    const MESSAGE_OUTCOMING = 3;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['text'], 'string'],
                [['status', 'sender_id', 'recipient_id'], 'integer'],
                [['sender_id', 'recipient_id'], 'required'],
                [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
                [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient() {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender() {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

     public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }


}
