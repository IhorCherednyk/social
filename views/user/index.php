<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>
<div class="user-index">


    <div class="user-search">
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true, 'method' => 'get' ]]); ?>
        <?= $form->field($searchModel, 'username') ?>
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
http://www.yiiframework.ru/forum/viewtopic.php?t=29673
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view'
    ])
    ?>

</div>
