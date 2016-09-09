<?php
namespace common\models\forms;

use common\models\User;
use yii\base\Model;
use common\models\ConfigureRbac;

class ChangeOwnPasswordForm extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $current_password;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $repeat_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'repeat_password'], 'required'],
            [['password', 'repeat_password', 'current_password'], 'string', 'max' => 255],
            [['password', 'repeat_password', 'current_password'], 'trim'],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['current_password', 'required', 'except' => 'restoreViaEmail'],
            ['current_password', 'validateCurrentPassword', 'except' => 'restoreViaEmail'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => \Yii::t('app', 'Current password'),
            'password' => \Yii::t('app', 'Password'),
            'repeat_password' => \Yii::t('app', 'Repeat password'),
        ];
    }


    /**
     * Validates current password
     */
    public function validateCurrentPassword()
    {
        if (!ConfigureRbac::checkAttempts()) {
            $this->addError('current_password', \Yii::t('back', 'Too many attempts'));

            return false;
        }

        if (!\Yii::$app->security->validatePassword($this->current_password, $this->user->password_hash)) {
            $this->addError('current_password', \Yii::t('back', "Wrong password"));
        }
    }

    /**
     * @param bool $performValidation
     *
     * @return bool
     */
    public function changePassword($performValidation = true)
    {
        if ($performValidation && !$this->validate()) {
            return false;
        }

        $this->user->password = $this->password;
        $this->user->removeConfirmationToken();

        return $this->user->save();
    }
}
