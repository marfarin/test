<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 14.09.16
 * Time: 17:08
 */
/**
 * @var $this yii\web\View
 * @var $user \common\models\User
 */
use yii\helpers\Html;
?>
<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/confirm-email-receive', 'token' => $user->confirmation_token]);
?>

    Hello <?= Html::encode($user->username) ?>, follow this link to confirm your email:

<?= Html::a('Confirm E-mail', $resetLink) ?>