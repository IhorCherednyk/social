<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                'attribute' => 'userid',
                'headerOptions' => [
                    'width' => '250',
                ],
                'filter' => app\helpers\FilterHelper::textRange($searchModel, 'letterFrom', 'letterTo'),
                'value' => function($model) {
                    return $model->id;
                }
            ],
            'username',
            'email:email',
            'password_hash',
                [
                'attribute' => 'status',
                'filter' => [app\models\User::STATUS_ACTIVE => 'active', app\models\User::STATUS_NOT_ACTIVE => 'not-active'],
            ],
            'auth_key',
                [
                'attribute' => 'cMessages',
                'value' => function($model) {
                    return $model->countMessages;
                }
            ],
                [
                'attribute' => 'incomingMessage',
                'value' => function($model) {
                    return $model->countNotReadMessage;
                }
            ],
//                [
//                'attribute' => 'created_at',
//                'headerOptions' => [
//                    'width' => '150',
//                ],
//                'filter' => app\helpers\FilterHelper::dateRange($searchModel, 'dateFrom', 'dateTo'),
//                'value' => function($model) {
//                    return Yii::$app->formatter->asDatetime($model->created_at);
//                }
//            ],
//            'created_at',
//             'updated_at',
//             'role',
//             'last_login_date',
//             'email_activation_key:email',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
