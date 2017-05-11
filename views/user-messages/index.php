<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\Message;
?>

<style>
    .news-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .news-list li {
        padding: 5px;
        border: 1px solid #000;
        margin-bottom: 1px;
    }
    .message-sender {
        float:right;
    }
    .item {
        overflow: hidden;
    }
    .message-action {
        display: block;
        overflow: hidden;
    }
    .message-action.not-readed{
        background-color: #eee;
    }
</style>
<div class="row">
    <h1><?= $header?> сообщения</h1>
    <?= Html::a('Входящие', ['/user-messages/incoming-message'], ['class' => 'btn btn-success']); ?>
    <?= Html::a('Исходящие', ['/user-messages/outgoing-message'], ['class' => 'btn btn-success']); ?>
    <div class="col-md-6">
        <div class="user-index">

            <?php Pjax::begin(); ?>    
            <?php
            
            $form = ActiveForm::begin(['options' => ['data-pjax' => ''], 'method' => 'post']);
            ?>
            <?= $form->field($searchModel, 'username') ?>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>

            <?=
            ListView::widget([
            'id' => 'list',
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item', 'tag' => 'li'],
            'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_view', [
                        'model' => $model,
                    ]);
            },
            'options' => [
            'tag' => 'ul',
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