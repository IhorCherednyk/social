<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\helpers\ImageUpload;
use app\models\LoginForm;
use app\models\Profile;
use app\models\RegForm;
use app\models\User;
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
        Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации.');
        if ($model->load(Yii::$app->request->post()) && $model->validate()):
            if ($user = $model->reg()):
                if ($user->status === User::STATUS_ACTIVE):
                    if (Yii::$app->getUser()->login($user)):
                        return $this->reditrect(['auth/profile']);
                    endif;
                endif; 
            else:
                Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации.');
                Yii::error('Ошибка при регистрации');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'reg', ['model' => $model]
        );
    }
  
    
    
    
    
    
    
    public function actionLogin() {
        if (!Yii::$app->user->isGuest){
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

    
    public function actionProfile()
    {

         
        
        $model = ($model = Profile::findOne(Yii::$app->user->id)) ? $model : new Profile();
        
        if($model->load(Yii::$app->request->post()) && $model->validate()):
            
            $file = UploadedFile::getInstance($model, 'avatar_path');
        
            $fileName = ImageUpload::saveImage($file);
            
            if($model->updateProfile($model,$fileName)):
                Yii::$app->session->setFlash('success', 'Профиль изменен');
            else:
                Yii::$app->session->setFlash('error', 'Профиль не изменен');
                Yii::error('Ошибка записи. Профиль не изменен');
                return $this->refresh();
            endif;
        endif;

        return $this->render(
            'profile',
            [
                'model' => $model
            ]
        );
    }
}
