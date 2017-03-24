<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\MyBehaviors;
use Yii;

class AdminController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true,
                        'controllers' => ['admin/user'],
                        'matchCallback' => function($rule, $action) {
                            return (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->role == \app\models\User::IS_ADMIN) ? true : false;
                        }
                    ],
                ]
            ]
        ];
    }

}
