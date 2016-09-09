<?php
namespace common\models\forms;

use common\models\ConfigureRbac;
use common\models\User;
use yii\base\Model;

class PasswordRecoveryForm extends Model
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $captcha;
    /**
     * @var User
     */
    protected $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['captcha', 'captcha', 'captchaAction' => '/auth/captcha'],
            [['email', 'captcha'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'validateEmailConfirmedAndUserActive'],
        ];
    }

    /**
     * @return bool
     */
    public function validateEmailConfirmedAndUserActive()
    {
        if (!ConfigureRbac::checkAttempts()) {
            $this->addError('email', \Yii::t('app', 'Too many attempts'));

            return false;
        }

        $user = User::findOne([
            'email' => $this->email,
            'email_confirmed' => 1,
            'status' => User::STATUS_ACTIVE,
        ]);

        if ($user) {
            $this->user = $user;
        } else {
            $this->addError('email', \Yii::t('app', 'E-mail is invalid'));
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'captcha' => \Yii::t('app', 'Captcha'),
        ];
    }

    /**
     * @param bool $performValidation
     *
     * @return bool
     */
    public function sendEmail($performValidation = true)
    {
        if ($performValidation and !$this->validate()) {
            return false;
        }

        $this->user->generateConfirmationToken();
        $this->user->save(false);

        return \Yii::$app->mailer->compose('mail\passwordRecoveryMail', ['user' => $this->user])
            ->setFrom('info@integrarus.ru')
            ->setTo($this->email)
            ->setSubject(\Yii::t('app', 'Password reset for') . ' ' . \Yii::$app->name)
            ->send();
    }
}
