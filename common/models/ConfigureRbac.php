<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\di\ServiceLocator;

/**
 * This is the model class for table "configure_rbac".
 *
 * @property integer $id
 * @property boolean $use_email_as_login
 * @property boolean $email_confirmation_required
 * @property string $common_permission_name
 * @property integer $confirmation_token_expire
 * @property boolean $user_can_have_multiple_roles
 * @property integer $max_attempts
 * @property integer $attempts_timeout
 */
class ConfigureRbac extends ActiveRecord
{
    const SESSION_LAST_ATTEMPT = '_um_last_attempt';
    const SESSION_ATTEMPT_COUNT = '_um_attempt_count';

    private static $_instance = null;




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configure_rbac';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['use_email_as_login', 'email_confirmation_required', 'user_can_have_multiple_roles'], 'boolean'],
            [['confirmation_token_expire', 'max_attempts', 'attempts_timeout'], 'integer'],
            [['common_permission_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'use_email_as_login' => Yii::t('app', 'Use Email As Login'),
            'email_confirmation_required' => Yii::t('app', 'Email Confirmation Required'),
            'common_permission_name' => Yii::t('app', 'Common Permission Name'),
            'confirmation_token_expire' => Yii::t('app', 'Confirmation Token Expire'),
            'user_can_have_multiple_roles' => Yii::t('app', 'User Can Have Multiple Roles'),
            'max_attempts' => Yii::t('app', 'Max Attempts'),
            'attempts_timeout' => Yii::t('app', 'Attempts Timeout'),
        ];
    }

    /**
     * @inheritdoc
     * @return ConfigureRbacQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigureRbacQuery(get_called_class());
    }

    public function checkUserAttempts()
    {
        $lastAttempt = Yii::$app->session->get(static::SESSION_LAST_ATTEMPT);
        if ($lastAttempt) {
            $attemptsCount = Yii::$app->session->get(static::SESSION_ATTEMPT_COUNT, 0);
            Yii::$app->session->set(static::SESSION_ATTEMPT_COUNT, ++$attemptsCount);
            // If last attempt was made more than X seconds ago then reset counters
            if (($lastAttempt + $this->attempts_timeout) < time()) {
                Yii::$app->session->set(static::SESSION_LAST_ATTEMPT, time());
                Yii::$app->session->set(static::SESSION_ATTEMPT_COUNT, 1);

                return true;
            } elseif ($attemptsCount > $this->max_attempts) {
                return false;
            }

            return true;
        }
        Yii::$app->session->set(static::SESSION_LAST_ATTEMPT, time());
        Yii::$app->session->set(static::SESSION_ATTEMPT_COUNT, 1);

        return true;
    }

    public static function checkAttempts()
    {
        return self::find()->one()->checkUserAttempts();
    }

    /**
     * @return ConfigureRbac
     */
    public static function getActualConfigureRbacInstance()
    {
        Yii::$app->cache->flush();
        if (static::$_instance == null) {
            static::$_instance = self::getDb()->cache(function ($db) {
                return self::find()->one();
            });
        }
        return static::$_instance;
    }

    public static function getActualConfigureRbacCallback()
    {
        return function () {
            $solr = \common\models\ConfigureRbac::getDb()->cache(function ($db) {
                return \common\models\ConfigureRbac::find()->one();
            });
            return $solr;
        };
    }
}
