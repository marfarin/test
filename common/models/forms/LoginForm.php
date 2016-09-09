<?php

namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\ConfigureRbac as AttemptHelper;
use webvimark\helpers\LittleBigHelper;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['username', 'validateIP'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Login'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!AttemptHelper::checkAttempts()) {
            $this->addError('password', Yii::t('app', 'Too many attempts'));

            return false;
        }

        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('app', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $u = new \Yii::$app->user->identityClass;
            $this->_user = ($u instanceof User ? $u->findByUsername($this->username) : User::findByUsername($this->username));
        }

        return $this->_user;
    }

    /**
     * Check if user is binded to IP and compare it with his actual IP
     */
    public function validateIP()
    {
        $user = $this->getUser();

        if ($user AND $user->bind_to_ip) {
            $ips = explode(',', $user->bind_to_ip);

            $ips = array_map('trim', $ips);

            if (!in_array(LittleBigHelper::getRealIp(), $ips)) {
                $this->addError('password', Yii::t('app', "You could not login from this IP"));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? Yii::$app->user->cookieLifetime : 0);
        } else {
            return false;
        }
    }
}
