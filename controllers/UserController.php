<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {


    public function actionIndex($username = null) {
        
        if(is_null($username)){
            $user = Yii::$app->user->identity;
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->post());
            if (\Yii::$app->request->isAjax) {
                return $this->renderPartial('index', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                            'user' => $user
                ]);
            }
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'user' => $user
            ]);
        }else {
          $user = User::findByUsername($username);
          
          return $this->render('index', [
                        'user' => $user
            ]);
        }
        
    }

}
