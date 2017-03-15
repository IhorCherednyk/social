<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\User;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * Description of AuthoriseController
 *
 * @author Anastasiya
 */
class UserController extends AppController {

    
    
   public function actionUserHome($id = null){
       
       if(is_null($id)){
           $currentUser = Yii::$app->user->identity;
           $users = User::find()->where(['!=','id', Yii::$app->user->id ])-all();
           
           return $this->render('user-home', [
                        'users' => $users,
                        'currentUser' => $currentUser,
            ]);
       }
       
       
       
   }
   
   
   
}
