<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\Menu;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class="wrap">

            <nav class=" navbar-inverse navbar-right navbar-fixed-top navbar">
                <div class="container">
                    
                    <?=
                    Menu::widget([
                        'options' => [
                            'class' => 'navbar-nav navbar-right nav',
                        ],
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'label' => Yii::t('app', 'User'),
                                'url' => ['/admin/user/index'],
                                
                            ],
                            [
                                'label' => Yii::t('app', 'Message'),
                                'url' => ['/admin/user/index'],
                                
                            ],
                                [
                                'label' => Yii::t('app', 'Home'),
                                'url' => ['/user/index','username' => (isset(\Yii::$app->user->identity->username))? \Yii::$app->user->identity->username :null],
                                'visible' => !\Yii::$app->user->isGuest
                            ],
                            [
                                'label' => Yii::t('app', 'Message'),
                                'url' => ['/user-messages/incoming-message'],
                                'visible' => !\Yii::$app->user->isGuest
                            ],
                                [
                                'label' => Yii::t('app', 'Register'),
                                'url' => ['/auth/reg'],
                                'visible' => \Yii::$app->user->isGuest
                            ],
                                [
                                'label' => \Yii::t('app', 'Login'),
                                'url' => ['/auth/login'],
                                'visible' => \Yii::$app->user->isGuest
                            ],
                                [
                                'label' => \Yii::t('app', 'Profile'),
                                'url' => ['/auth/profile'],
                                'visible' => !\Yii::$app->user->isGuest
                            ],
                                [
                                'label' => \Yii::t('app', 'Logout'),
                                'url' => ['/auth/logout'],
                                'visible' => !\Yii::$app->user->isGuest
                            ],
                            
                        ],
                    ]);
                    ?>
                </div>
            </nav>

            <div class="container">
                <?= $content ?>
            </div>

        </div>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
