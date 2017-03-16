<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */


?>

<a href="<?= yii\helpers\Url::to(['/user/index','key' => $model->username])?>" class="user-box" >
    <div class="user-name">
        <?= $model->username ?>
    </div>
    <div class="user-img">
        <?php 
            if($model->profile->avatar_path){
                echo Html::img($model->profile->avatar_path);
            }
        ?>
    </div>
</a>

