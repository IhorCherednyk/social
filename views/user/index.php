<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>


<div class="row">

    <div class="col-md-6">
        <div class="user-index">

            <?php Pjax::begin();?>    
            <?php
                $form = ActiveForm::begin(['options' => ['data-pjax' => true],'method' => 'post']);
            ?>
            <?= $form->field($searchModel, 'username'); ?>
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>

            <?=
            ListView::widget([
                'id' => 'list',
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_view'
            ]);
            ?>
            <?php Pjax::end();?>     
        </div>
    </div>


</div>