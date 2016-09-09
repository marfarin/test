<?php
use yii\helpers\Url;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="<?= Yii::t('app', 'Search...'); ?>"/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('app', 'Menu'), 'options' => ['class' => 'header']],
                    [
                        'label' => Yii::t('app', 'Access control'),
                        'icon' => 'fa fa-book',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']],
                            ['label' => Yii::t('app', 'Roles'), 'url' => ['/role/index']],
                            ['label' => Yii::t('app', 'Permissions'), 'url' => ['/permission/index']],
                            ['label' => Yii::t('app', 'Permission groups'), 'url' => ['/auth-item-group/index']],
                            ['label' => Yii::t('app', 'Visit log'), 'url' => ['/user-visit-log/index']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app', 'Notifications'),
                        'icon' => 'fa fa-book',
                        'url' => '#',
                        'items' => [
                            ['label' => Yii::t('app', 'Notification configure'), 'url' => ['/configure-model-event/index']],
                            ['label' => Yii::t('app', 'Events and classes'), 'url' => ['/event-class/index']],
                            ['label' => Yii::t('app', 'Notification types'), 'url' => ['/notification-type/index']],
                        ]
                    ],
                    [
                        'label' => 'Developer tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                        ]
                    ],
                    [
                        'label' => 'Frontend routes',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            //['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                            ['label' => Yii::t('app', 'Login'), 'url' => ['/auth/login']],
                            ['label' => Yii::t('app', 'Logout'), 'url' => ['/auth/logout']],
                            ['label' => Yii::t('app', 'Registration'), 'url' => ['/auth/registration']],
                            ['label' => Yii::t('app', 'Change own password'), 'url' => ['/auth/change-own-password']],
                            ['label' => Yii::t('app', 'Password recovery'), 'url' => ['/auth/password-recovery']],
                            ['label' => Yii::t('app', 'E-mail confirmation'), 'url' => ['/auth/confirm-email']],
                        ]
                    ],
                    ['label' => 'Login', 'url' => ['auth/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

        <?php
        /*echo GhostMenu::widget([
            'encodeLabels'=>false,
            'activateParents'=>true,
            'items' => [
               /* [
                    'label' => 'append routes',
                    'items'=>Yii::menuItems()
                ],
                [
                    'label' => 'Frontend routes',
                    'items'=>[
                        ['label'=>'Login', 'url'=>['/user-management/auth/login']],
                        ['label'=>'Logout', 'url'=>['/user-management/auth/logout']],
                        ['label'=>'Registration', 'url'=>['/user-management/auth/registration']],
                        ['label'=>'Change own password', 'url'=>['/user-management/auth/change-own-password']],
                        ['label'=>'Password recovery', 'url'=>['/user-management/auth/password-recovery']],
                        ['label'=>'E-mail confirmation', 'url'=>['/user-management/auth/confirm-email']],
                    ],
                ],
            ],
        ]);*/
        ?>

    </section>

</aside>
