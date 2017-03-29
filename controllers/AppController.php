<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\components\MyBehaviors;
use Yii;
use app\models\User;

class AppController extends Controller {

    public function behaviors() {
        return [
            'access' => [// название поведения
                'class' => AccessControl::className(), // фильтры
                'rules' => [// список правил 
//                  
                        [// первое правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['auth'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'actions' => ['reg', 'login'], //(ВИДЫ) ДЛЯ ДЕЙСТВИЙ REG, LOGIN
                        'matchCallback' => function($rule, $action) {
                            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role = User::IS_USER) {
                                return $this->redirect(['user/index', 'username' => Yii::$app->user->identity->username]);
                            } elseif (!Yii::$app->user->isGuest && Yii::$app->user->identity->role = User::IS_ADMIN) {
                                return $this->redirect(['/admin']);
                            }
                            return true;
                        }
                    ],
                        [// первое правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['admin/user'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'matchCallback' => function($rule, $action) {
                            return (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->role == \app\models\User::IS_ADMIN) ? true : false;
                        }
                    ],
                        [// второе правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['auth'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'actions' => ['logout'], //(ВИДЫ) ДЛЯ ДЕЙСТВИЙ LOGOUT
                        'verbs' => ['POST', 'GET'], //(ЗАПРОСЫ)С ТАКИМИ ЗАПРОСАМИ КАК POST
                        'roles' => ['@']//(КОМУ?) ПОЛЛЬЗОВАТЕЛЯМ КОТОРЫЕ ЯВЛЯЮТСЯ ЮЗЕРАМИ
                    ],
                        [// второе правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['user'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'actions' => ['index'], //(ВИДЫ) ДЛЯ ДЕЙСТВИЙ LOGOUT
                        'verbs' => ['POST', 'GET'], //(ЗАПРОСЫ)С ТАКИМИ ЗАПРОСАМИ КАК POST
                        'roles' => ['@']//(КОМУ?) ПОЛЛЬЗОВАТЕЛЯМ КОТОРЫЕ ЯВЛЯЮТСЯ ЮЗЕРАМИ
                    ],
                        [// второе правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['user-messages'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'actions' => ['incoming-message', 'outgoing-message', 'read-message', 'write-message'], //(ВИДЫ) ДЛЯ ДЕЙСТВИЙ LOGOUT
                        'verbs' => ['POST', 'GET'], //(ЗАПРОСЫ)С ТАКИМИ ЗАПРОСАМИ КАК POST
                        'roles' => ['@']//(КОМУ?) ПОЛЛЬЗОВАТЕЛЯМ КОТОРЫЕ ЯВЛЯЮТСЯ ЮЗЕРАМИ
                    ],
                        [// второе правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['auth'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'actions' => ['send-email', 'setnew-password', 'activate-email'], //(ВИДЫ) ДЛЯ ДЕЙСТВИЙ LOGOUT
                        'verbs' => ['POST', 'GET'], //(ЗАПРОСЫ)С ТАКИМИ ЗАПРОСАМИ КАК POST
                        'roles' => ['?']//(КОМУ?) ПОЛЛЬЗОВАТЕЛЯМ КОТОРЫЕ ЯВЛЯЮТСЯ ЮЗЕРАМИ
                    ],
                        [// первое правило гласит
                        'allow' => true, //(ДЕЙСТВИЕ) РАЗРЕШИТЬ ДОСТУП
                        'controllers' => ['auth'], //(КОНТРОЛЛЕР) ДЛЯ ЭТОГО КОНТРОЛЛЕРА
                        'actions' => ['profile'], //(ВИДЫ) ДЛЯ ДЕЙСТВИЙ REG, LOGIN
                        'verbs' => ['GET', 'POST'], //(ЗАПРОСЫ)С ТАКИМИ ЗАПРОСАМИ КАК GET POST
                        'roles' => ['@']//(КОМУ?) ПОЛЛЬЗОВАТЕЛЯМ КОТОРЫЕ ЯВЛЯЮТСЯ ГОСТЯМИ
                    ]
                ]
            ]
        ];
    }

}
