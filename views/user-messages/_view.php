<?php

use app\models\User;
use app\models\Message;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $model User */
?>




<?php if ($model->sender_id == Yii::$app->user->id){
    echo Html::a(
            Html::tag('span', $model->text, ['class' => 'message-text']) .
            Html::tag('span', $model->recipient->username, ['class' => 'message-sender']) .
            Html::tag('span', Html::img($model->recipient->profile->avatar_path), ['class' => 'message-sender']), 
            ['/user-messages/read-message', 'id' => $model->id], ['class' => 'message-action', 'data-pjax' => true]);
}else {
    echo Html::a(
    Html::tag('span', $model->text, ['class' => 'message-text']) .
    Html::tag('span', $model->sender->username, ['class' => 'message-sender']) .
    Html::tag('span', Html::img($model->sender->profile->avatar_path),['class' => 'message-sender']),
    ['/user-messages/read-message', 'id' => $model->id], ['class' => ($model->status == Message::STATUS_UNREADED)? 'message-action not-readed': 'message-action','data-pjax' => true]);
}

?>


