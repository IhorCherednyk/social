<?php

namespace app\controllers;

use app\models\Message;
use app\models\MessageSearch;
use Yii;


class UserMessagesController extends AppController {

//    1. Если я хочу отображать пользователя в listview который отправляет или которому отправленно по ситации куда мне его передавать
//    могу ли я сделать запрос к базе в самом listview или как мне его туда передать (могу ли я в index.php из модели  передаваемой в _view
//    зделать запрос к базе)
//    2. Правильно ли я юзаю констануту для отображения сообщений
//    3. Смена статуса письма: могу ли я создать новый action который будет открывать письмо
//           в _view делать проверку по $model его статус и в заисимости от статуса гинерить разные ссылки
//           если сообщение прочитано ссылка  просто вести на action если нет то ссылка будет содержать
//           в себе id письма я его буду в action находить по id и менять ему статус
    
    public function actionIncomingMessage() {
//        здесь надо получать sender_id
        $incomingMessage = Message::MESSAGE_INCOMING;
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$incomingMessage);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'incomingMessage' => $incomingMessage
        ]);
    }
    public function actionOutgoingMessage() {
//        здесь надо получать recipient_id
        $incomingMessage = Message::MESSAGE_OUTCOMING;
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post(),$incomingMessage);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'incomingMessage' => $incomingMessage
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

}
