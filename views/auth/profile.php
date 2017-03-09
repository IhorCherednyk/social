<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
/* @var $form ActiveForm */
?>
<div class="auth-profile">
    <?= Yii::$app->session->getFlash('success') ?>
    <?= Yii::$app->session->getFlash('error') ?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'last_name') ?>
        <?= $form->field($model, 'hobbies') ?>
        <?= $form->field($model, 'lovely_films') ?>
        <?= $form->field($model, 'lovely_book') ?>
        <?= $form->field($model, 'avatar_path')->fileInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Edit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- auth-profile -->
