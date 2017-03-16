<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>
<style>
    .user-box {
        max-width: 300px;
        border: 1px solid #000;
        margin-bottom: 5px;
        padding: 10px;
        display: block;
    }
    .user-box:after {
        content: '';
        display: table;
        clear: both;
    }
    .user-name {
        float: left;
        min-width: 100px;
    }
    .user-img {
        float: left;
        width: 100px;
    }
    .user-img img{
        width: 100%;
        height: auto;
    }
    .user-profile {
        max-width: 600px;
    }
    .user-main-img {
        float: left;
        width: 200px;
        height: 200px;
        border: 1px solid #000;
        margin-right: 20px;
    }
    .user-data {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 20px;

    }
</style>

<div class="row">
    <div class="col-md-6">
        <div class="user-profile">
            <div class="user-main-img">
                <?php
                if ($user->profile->avatar_path) {
                    echo Html::img($user->profile->avatar_path);
                }
                ?>
            </div>
            <div class="user-main-username">
                <?php
                if ($user->profile->avatar_path) {
                    echo Html::tag('p', Html::encode($user->profile->first_name), ['class' => 'user-data']);
                }
                if ($user->profile->avatar_path) {
                    echo Html::tag('p', Html::encode($user->profile->last_name), ['class' => 'user-data']);
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="user-index">
            <?php
                echo $this->render('_form', [
                'searchModel' => $searchModel,
                ]);


                echo ListView::widget([
                'id' => 'list',
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_view'
                ]);
            ?>

        </div>
    </div>


</div>