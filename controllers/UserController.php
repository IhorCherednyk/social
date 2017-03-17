<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends Controller {

    public function actionIndex($username) {
        $user = ($username == Yii::$app->user->identity->username) ? Yii::$app->user->identity : User::findByUsername($username);
        if (!is_null($user)) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'user' => $user
            ]);
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }

}
