<?php

namespace app\controllers;

use Yii;
use app\models\Message;
use app\models\MassageWriteForm;

class UserMessagesController extends AppController {

    public function actionIndex() {
        $model = new Message();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->sendMessage();
                return;
            }
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    public function actionWriteMessage($recipient) {
        $model = new Message();

        if ($model->load(Yii::$app->request->post())) {
                $model->sender_id = Yii::$app->user->id;
                if($model->save()){
                    $model = new Message();
                }
        }
        
        
        return $this->render('write-message', [
                    'model' => $model,
        ]);
    }

}
