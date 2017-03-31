<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SendEmailForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::className(),
                'filter' => [
                    'status' => User::STATUS_ACTIVE
                ],
                'message' => 'Данный емайл не зарегистрирован.'
            ],
        ];
    }

    public function sendEmail()
    {
        
        $user = User::findOne(
            [
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email
            ]
        );

        if($user){
            $token = ($token = Token::findOne(['user_id' => $user->id])) ? $token : new Token();
            $token->generateSecretKey();
            $token->user_id = $user->id;
            if($token->save()){
                $email = ($email = Email::findByUserToken($token->secret_key)) ? $email : new Email();
                $email->createEmail($user,Email::EMAIL_RESETPASSWORD,$token->secret_key);
                
                return true;
                
                
//                return Yii::$app->mailer->compose('resetPassword', ['token' => $token, 'user' => $user])
//                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' (отправлено роботом)'])
//                    ->setTo($this->email)
//                    ->setSubject('Сброс пароля для '.Yii::$app->name)
//                    ->send();
            }
        }

        return false;
    }

}