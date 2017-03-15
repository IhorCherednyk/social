<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;



$this->title = 'Login';
?>
<div class="site-login">
    
    
   
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if (Yii::$app->session->getFlash('error')) {
        echo Yii::$app->session->getFlash('error');
    }
    ?>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-6">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <div class="col-lg-6">
                <a href="<?= \yii\helpers\Url::to(['auth/login']) ?>" class="btn btn-primary">Register</a>
            </div>
            <div class="col-lg-6">
                <?= Html::a('Забыли пароль?', ['/auth/send-email']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
