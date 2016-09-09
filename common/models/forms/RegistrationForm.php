<?php
namespace common\models\forms;

use common\models\User;
use yii\base\Model;
use yii\helpers\Html;
use common\models\ConfigureRbac;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $repeat_email;
    public $password;
    public $repeat_password;
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['captcha', 'captcha', 'captchaAction' => '/auth/captcha'],
            [['username', 'password', 'repeat_password', 'captcha', 'email', 'repeat_email'], 'required'],
            [['username', 'password', 'repeat_password', 'email', 'repeat_email'], 'trim'],
            [
                'username',
                'unique',
                'targetClass' => 'common\models\User',
                'targetAttribute' => 'username',
            ],
            ['username', 'purgeXSS'],
            ['password', 'string', 'max' => 255],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['repeat_email', 'compare', 'compareAttribute' => 'email'],
            ['username', 'string', 'max' => 50],
            [['email', 'repeat_email'], 'email']
        ];
        return $rules;
    }

    /**
     * Remove possible XSS stuff
     *
     * @param $attribute
     */
    public function purgeXSS($attribute)
    {
        $this->$attribute = Html::encode($this->$attribute);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('app', 'Username'),
            'email' => \Yii::t('app', 'Email'),
            'repeat_email' => \Yii::t('app', 'Repeat email'),
            'password' => \Yii::t('app', 'Password'),
            'repeat_password' => \Yii::t('app', 'Repeat password'),
            'captcha' => \Yii::t('app', 'Captcha'),
        ];
    }

    /**
     * @param bool $performValidation
     *
     * @return bool|User
     */
    public function registerUser($performValidation = true)
    {
        if ($performValidation && !$this->validate()) {
            return false;
        }

        $user = new User();
        $user->password = $this->password;

        $user->email = $this->email;
        $user->username = $this->username;

        if (ConfigureRbac::getActualConfigureRbacInstance()->email_confirmation_required) {
            $user->status = User::STATUS_INACTIVE;
            $user->generateConfirmationToken();
            $user->save(false);

            $this->saveProfile($user);

            if ($this->sendConfirmationEmail($user)) {
                return $user;
            } else {
                $this->addError('username', \Yii::t('app', 'Could not send confirmation email'));
            }
        } else {
            $user->username = $this->username;
        }


        if ($user->save()) {
            $this->saveProfile($user);
            return $user;
        } else {
            $this->addError('username', \Yii::t('app', 'Login has been taken'));
        }
        return false;
    }

    /**
     * Implement your own logic if you have user profile and save some there after registration
     *
     * @param User $user
     */
    protected function saveProfile($user)
    {
        return $user;
    }


    /**
     * @param User $user
     *
     * @return bool
     */
    protected function sendConfirmationEmail($user)
    {
        return \Yii::$app->mailer->compose('registrationEmailConfirmation', ['user' => $user])
            ->setFrom('info@integrarus.ru')
            ->setTo($user->email)
            ->setSubject(\Yii::t('app', 'E-mail confirmation for') . ' ' . \Yii::$app->name)
            ->send();
    }

    /**
     * Check received confirmation token and if user found - activate it, set username, roles and log him in
     *
     * @param string $token
     *
     * @return bool|User
     */
    public function checkConfirmationToken($token)
    {
        $user = User::findInactiveByConfirmationToken($token);

        if ($user) {
            //$user->username = $user->email;
            $user->status = User::STATUS_ACTIVE;
            $user->email_confirmed = 1;
            $user->removeConfirmationToken();
            $user->save(false);

            $roles = [];

            foreach ($roles as $role) {
                User::assignRole($user->id, $role);
            }

            \Yii::$app->user->login($user);

            return $user;
        }

        return false;
    }
}
