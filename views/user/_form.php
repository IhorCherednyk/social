<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>
 

<div class="user-search">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'myform']]); ?>
        <?= $form->field($searchModel, 'username')->textInput(['id' => 'search_id']); ?>
        <?php ActiveForm::end(); ?>
</div>

