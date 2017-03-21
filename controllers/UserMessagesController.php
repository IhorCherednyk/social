<?php

namespace app\controllers;

use app\models\Message;
use app\models\MessageSearch;
use Yii;


class UserMessagesController extends AppController {


//    3. Смена статуса письма: могу ли я создать новый action который будет открывать письмо
//           в _view делать проверку по $model его статус и в заисимости от статуса гинерить разные ссылки
//           если сообщение прочитано ссылка  просто вести на action если нет то ссылка будет содержать
//           в себе id письма я его буду в action находить по id и менять ему статус
    
    public function actionIncomingMessage() {
//        здесь надо получать sender_id
        $searchModel = new MessageSearch();
        $searchModel->type = Message::MESSAGE_INCOMING;
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }
    public function actionOutgoingMessage() {
//        здесь надо получать recipient_id
        $searchModel = new MessageSearch();
        $searchModel->type = Message::MESSAGE_OUTCOMING;
        $dataProvider = $searchModel->search(Yii::$app->request->post());
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    
        ]);
    }

    public function actionWriteMessage($recipientid = null) {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && !is_null($recipientid)) {
            $model->sender_id = Yii::$app->user->id;
            $model->recipient_id = $recipientid;
            $model->status = Message::STATUS_UNREADED;
            if ($model->save()) {
                $model = new Message();
                Yii::$app->session->setFlash('success', 'Сообщение отправленно');
            }
        }

        return $this->render('write-message', [
                    'model' => $model,
        ]);
    }
    
    public function actionReadMessage($id){
        $model = Message::findById($id);
        
        if($model->status == Message::STATUS_UNREADED){
           $model->status =  Message::STATUS_READED;
           if(!$model->save()){
               return false;
           }
           
        }
        return $this->render('read-message', [
                    'model' => $model,
        ]);
    }

}
