<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;

/**
 * Description of AuthoriseController
 *
 * @author Anastasiya
 */
class AuthController extends AppController {

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) { //Проверяем если пользователь авторизован
            return $this->redirect(['site/index']); // Отправляем его на домашнюю страницу
        }
        // Если пользователь не авторизован создаем модель формы LoginForm
        $model = new LoginForm();
        
        // 1.Поскольку в первый раз эта проверка вернет false мы перемещаемся дальше и рендерим нашу форму регистрации строка 36
        // 2. После того как мы в нашей форме жмем отправить мы опять поподаем сюда
        //    теперь уже $model->load(Yii::$app->request->post() == true
        //    и мы запускаем $model->login()
        //    и мы переходим в LoginForm.php 36 строка
        
        
        // получаем ответ если наша форма не прошла валидацию или не правильно было заполнено мы получаем false и опять показуем форму
        
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        // 1.здесь мы создаем форму в нашем виде и отображаем ее
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    
    
    public function actionSignup(){
         if (!Yii::$app->user->isGuest) { //Проверяем если пользователь авторизован
            return $this->redirect(['site/index']); // Отправляем его на домашнюю страницу
        }
        $model = new SignupForm();
        
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if($model->signup()){
                return $this->redirect(['auth/login']);
            }
           
        }
        
        return $this->render('signup', ['model'=>$model]);
    }
    
    
    
    
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    

}
