<?php 
use yii\helpers\Html;
?>
<style>
    .message-box {
        max-width: 600px;
        padding: 40px;
        margin: 0 auto;
        border: 1px solid #000;
        border-radius: 5px;
    }
</style>

<?php 
    if($model->sender_id == Yii::$app->user->id){
            echo Html::tag('h1','Cообщения для ' . $model->recipient->username);
            echo Html::tag('div',$model->text, ['class' => 'message-box']);
            echo Html::a('Написать еще сообщение', ['/user-messages/write-message', 'recipientid' => $model->recipient_id],['class' => 'btn btn-success']);
}else {
        echo Html::tag('h1','Cообщения от ' . $model->sender->username);
        echo Html::tag('div',$model->text, ['class' => 'message-box']);
        echo Html::a('Ответить', ['/user-messages/write-message', 'recipientid' => $model->sender_id],['class' => 'btn btn-success']);
    }
?>