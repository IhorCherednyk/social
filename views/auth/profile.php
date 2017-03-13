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
        <?= $form->field($model, 'file')->fileInput() ?>
        <h2>картинка профиля</h2>
        <?php 
        
           if($model->avatar_path){
               echo Html::img($model->avatar_path);
           }else{
               echo Yii::t('app','Картинка е не загруженна');
           }
       ?>
    
        <div class="form-group">
            <?= Html::submitButton('Edit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- auth-profile -->
