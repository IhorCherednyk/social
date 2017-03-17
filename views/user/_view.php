<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

?>

    <div class="user-name">
        <?= Html::a($model->username, ['/user/index', 'username' => $model->username], ['data-pjax' => true]) ?>
    </div>


