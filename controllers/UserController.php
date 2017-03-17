<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UserController extends AppController {
    
    protected function checkUserConfirmEmail($username) {
        $user = User::findByUsername($username);
        if(!is_null($user) && $user->status == User::STATUS_ACTIVE){
            return true;
        }
        
    }

    public function actionIndex($username) {
        
        if(!$this->checkUserConfirmEmail($username)){
            throw new \yii\web\NotFoundHttpException();
        }
        
        $user = ($username == Yii::$app->user->identity->username) ? Yii::$app->user->identity : User::findByUsername($username);
        if (!is_null($user)) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post(),$user);
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
