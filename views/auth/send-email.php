<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form ActiveForm */
?>
<div class="auth-profile">
    <?php 
        if(Yii::$app->session->getFlash('success')){
            echo Yii::$app->session->getFlash('success');
        }
        if(Yii::$app->session->getFlash('warn')){
            echo Yii::$app->session->getFlash('warn');
        }
    ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email') ?>
    <div class="form-group">
        <?= Html::submitButton('send-email', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- auth-profile -->
