<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\helpers\ImageHelper;
use app\models\LoginForm;
use app\models\Profile;
use app\models\RegForm;
use app\models\Token;
use app\models\User;
use app\models\SendEmailForm;
use app\models\ResetPasswordForm;
use Yii;
use yii\web\UploadedFile;

/**
 * Description of AuthoriseController
 *
 * @author Anastasiya
 */
class AuthController extends AppController {
    

    public function actionReg() {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role = User::IS_USER) {
            return $this->redirect(['user/index', 'username' => Yii::$app->user->identity->username]);
        } elseif (!Yii::$app->user->isGuest && Yii::$app->user->identity->role = User::IS_ADMIN) {
            return $this->redirect(['/admin']);
        }

        $model = new RegForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            $user = $model->reg();
            if ($user && $model->sendEmail($user)) {
                Yii::$app->session->setFlash('confirm-email', 'На ваш email отправлено письмо для подтверждения email');
                return $this->goHome();
            } else {

                Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации.');
                Yii::error('Ошибка при регистрации');
                return $this->refresh();
            }
        }
        
        return $this->render(
            'reg', ['model' => $model]
        );
    }

    
    
    
    
    
    
    
    
    public function actionActivateEmail($key) {
        $user = User::findByEmailKey($key);
        
        if ($user) {
            
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            if (Yii::$app->getUser()->login($user)) {
                return $this->redirect(['auth/profile']);
            }
        }
        Yii::$app->session->setFlash('error', 'Возникла ошибка при подтверждении пароля попробуйте зарегистрироваться заново');
        
        return redirect(['auth/reg']);
    }

    
    
    
    
    
    
    
    public function actionLogin() {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role = User::IS_USER) {
            return $this->redirect(['user/index','username'=> Yii::$app->user->identity->username]);
        }elseif(!Yii::$app->user->isGuest && Yii::$app->user->identity->role = User::IS_ADMIN){
            return $this->redirect(['/admin']);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            
            if($model->login()){
                if($model->user->role == User::IS_ADMIN){
                    return $this->redirect(['/admin']);
                }else{
                    return $this->redirect(['user/index', 'username'=> Yii::$app->user->identity->username]);
                }
            }else{
               
              Yii::$app->session->setFlash('error', 'Возможно вы не активировали свой email'); 
              return $this->refresh();
            }
            
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    
    

    
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['auth/login']);
    }

    
    
    
    
    
    public function actionProfile() {
        $model = ($model = Profile::findOne(['user_id' => Yii::$app->user->id])) ? $model : new Profile();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {

                $model->file = ImageHelper::saveImage($model);


                if ($model->updateProfile($model)) {
                    Yii::$app->session->setFlash('success', 'Профиль изменен');
                } else {
                    Yii::$app->session->setFlash('error', 'Профиль не изменен');
                    Yii::error('Ошибка записи. Профиль не изменен');
                    return $this->refresh();
                }
            }
        }
        return $this->render('profile', ['model' => $model]);
    }

    public function actionSendEmail() {
        $model = new SendEmailForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'На вашу почту выслано подтверждение изменения пароля');
            }
        }
        return $this->render('send-email', [
                    'model' => $model,
        ]);
    }

    public function actionSetnewPassword($key) {
        $token = Token::findBySecretKey($key);

        if ($token && $token->isSecretKeyExpire($token->expire_date)) {

            $model = new ResetPasswordForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->resetPassword($token)) {
                    
                }
            }
            return $this->render('setnew-password', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('warn', 'Либо неверно указан ключи или срок ссылки на изменение пароля истек, отправьте новй запрос на востановление пароля');
            return $this->redirect(['auth/send-email']);
        }
    }

}
