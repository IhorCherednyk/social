<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $text
 * @property integer $status
 * @property string $date_created
 * @property integer $sender_id
 * @property integer $recipient_id
 *
 * @property User $recipient
 * @property User $sender
 */
class Message extends \yii\db\ActiveRecord {

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
                [['date_created'], 'safe'],
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



    public function getRecipientId($id) {
        if (is_null($this->_user)):
            $this->_user = User::findByUsername($this->username);
        endif;

        return $this->_user;
    }

}
