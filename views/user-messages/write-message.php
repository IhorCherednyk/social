<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form ActiveForm */
?>
<div class="user-messages-index">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'text')->textarea() ?>
        <?= $form->field($model, 'recipient_id')->hiddenInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-messages-index -->
