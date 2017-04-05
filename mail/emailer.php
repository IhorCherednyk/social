<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.08.2015
 * Time: 15:38
 *
 * @var $user \app\models\User
 */
use yii\helpers\Html;
use app\models\Email;

if ($value->type == Email::EMAIL_ACTIVATE) {
    echo Html::a('Для подтверждения емейла', Yii::$app->urlManager->createAbsoluteUrl(
                    [
                        '/auth/activate-email',
                        'key' => $value->data,
                    ]
    ));
}else{
        echo Html::a('Для смены пароля перейдите по этой ссылке.', Yii::$app->urlManager->createAbsoluteUrl(
                    [
                        '/auth/activate-email',
                        'key' => $value->data,
                    ]
    ));
}
