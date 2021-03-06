<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $userData \common\models\User */
\dmstr\web\AdminLteAsset::register($this);

?>

<header class="main-header">

    <?= Html::a(
        '<span class="logo-mini">RGK</span><span class="logo-lg">' . Yii::$app->name . '</span>',
        Yii::$app->homeUrl,
        ['class' => 'logo']
    ) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                <!-- User Account: style can be found in dropdown.less -->
                <?php if (!Yii::$app->user->isGuest) { ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= $userData->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= $userData->username ?> - <?= empty($userData->email) ? 'email not set' : $userData->email ?>
                                <small>Member since <?= date('M. Y', strtotime($userData->created_at)) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <?= Html::a(
                                    'Profile',
                                    ['/user/set-notification-type'],
                                    ['data-method' => 'get', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/auth/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>
