<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\Message;
?>


<div class="row">
    <div class="col-md-6">
        <div class="user-img">
            <?php if (isset($user->profile->avatar_path)): ?>
                <?= Html::img($user->profile->avatar_path) ?>
            <?php endif; ?>
        </div>
        <div class="user-info">
            <?php if (isset($user->profile->first_name)): ?>
                <?= Html::tag('h1', $user->profile->first_name); ?>
            <?php endif; ?>

            <?php if (isset($user->profile->last_name)): ?>
                <?= Html::tag('h1', $user->profile->last_name); ?>

            <?php endif; ?>
        </div>
        
        <div class="message">
            <?php
            if ($user->id == Yii::$app->user->id) {
                $query = Message::find();
                $count = $query->where(['status' => Message::STATUS_UNREADED])
                        ->andWhere(['recipient_id' => Yii::$app->user->id])
                        ->count();
                echo Html::a('Мои сообщения', ['/user-messages/incoming-message'], ['class' => 'btn btn-success']);
                echo Html::a($count,['/user-messages/incoming-message'],['class' => 'btn btn-primary']);
            } else {
                echo Html::a('Написать сообщение', ['/user-messages/write-message', 'recipientid' => $user->id], ['class' => 'btn btn-success']);
            }
            ?>
        </div>    
    </div>

    <div class="col-md-6">
        <div class="user-index">

            <?php Pjax::begin(); ?>    
            <?php
            $form = ActiveForm::begin(['options' => ['data-pjax' => ''], 'method' => 'post']);
            ?>
            <?= $form->field($searchModel, 'username'); ?>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>

            <?=
            ListView::widget([
                'id' => 'list',
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_view',
                'options' => [
                    'tag' => 'div',
                    'class' => 'news-list',
                    'id' => 'news-list',
                ],
                'layout' => "{summary}\n{items}\n{pager}",
            ]);
            ?>
            <?php Pjax::end(); ?>     
        </div>
    </div>


</div>