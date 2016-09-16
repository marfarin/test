<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 14.09.16
 * Time: 17:09
 */
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 */
use yii\helpers\Html;
?>
<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/password-recovery-receive', 'token' => $user->confirmation_token]);
?>

    Hello <?= Html::encode($user->username) ?>, follow this link to reset yout password:

<?= Html::a('Reset password', $resetLink) ?>