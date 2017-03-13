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
        $model = new RegForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user = $model->reg()) {
                if ($user->status === User::STATUS_ACTIVE) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->redirect(['auth/profile']);
                    }
                }
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

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goHome();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
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
        
        if ($key && $token->isSecretKeyExpire($token->expire_date)) {
            
            $model = new ResetPasswordForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if($model->resetPassword($token->user_id,$token)){
                    
                }
            }
            return $this->render('setnew-password', [
                        'model' => $model,
            ]);
            
        }else{
           Yii::$app->session->setFlash('warn', 'Либо неверно указан ключи или срок ссылки на изменение пароля истек, отправьте новй запрос на востановление пароля'); 
           return $this->redirect(['auth/send-email']);
        }
    }

}
