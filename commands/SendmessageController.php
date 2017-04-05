<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\Email;
use Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SendmessageController extends Controller {

    public function actionIndex() {
        $email = Email::find(['status' => Email::STATUS_NOTSUCCSSES])->limit(50)->all();
        $messages = [];
        foreach ($email as $key => $value) {
            $messages[] = Yii::$app->mailer->compose('emailer', ['value' => $value])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' (отправлено роботом)'])
                    ->setTo($value->recipient_email)
                    ->setSubject('Сброс пароля для ' . Yii::$app->name);
            $value->status = Email::STATUS_SUCCSSES;
            $value->save();
        }
        Yii::$app->mailer->sendMultiple($messages);
    }


}
