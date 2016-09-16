<?php

namespace common\models;

use frontend\models\AlertUserQuery;
use webvimark\helpers\LittleBigHelper;
use webvimark\helpers\Singleton;
use common\components\AuthHelper;
use common\components\UserIdentity;
use common\models\rbacDB\Role;
use common\models\rbacDB\Route;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use frontend\models\NotificationType;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property integer $email_confirmed
 * @property string $auth_key
 * @property string $password_hash
 * @property string $confirmation_token
 * @property integer $status
 * @property integer $superadmin
 * @property string $registration_ip
 * @property string $bind_to_ip
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AlertUserQuery[] $alertUserQueries
 * @property AlertUserQuery[] $alertUserQueries0
 * @property NotificationType[] $notificationTypes
 * @property UserVisitLog[] $userVisitLogs
 */
class User extends UserIdentity
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_BANNED = -1;
    const EVENT_TEST_QQQ = 'EVENT_TEST_QQQ';

    /**
     * @var string
     */
    public $gridRoleSearch;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeat_password;

    /**
     * @var array
     */
    public $notificationTypeId;

    /**
     * Store result in singleton to prevent multiple db requests with multiple calls
     *
     * @param bool $fromSingleton
     *
     * @return static
     */
    public static function getCurrentUser($fromSingleton = true)
    {
        if (!$fromSingleton) {
            return static::findOne(Yii::$app->user->id);
        }

        $user = Singleton::getData('__currentUser');

        if (!$user) {
            $user = static::findOne(Yii::$app->user->id);

            Singleton::setData('__currentUser', $user);
        }

        return $user;
    }

    /**
     * Assign role to user
     *
     * @param int $userId
     * @param string $roleName
     *
     * @return bool
     */
    public static function assignRole($userId, $roleName)
    {
        try {
            Yii::$app->db->createCommand()
                ->insert('auth_assignment', [
                    'user_id' => $userId,
                    'item_name' => $roleName,
                    'created_at' => (new Expression('NOW()')),
                ])->execute();

            AuthHelper::invalidatePermissions();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Revoke role from user
     *
     * @param int $userId
     * @param string $roleName
     *
     * @return bool
     */
    public static function revokeRole($userId, $roleName)
    {
        $result = Yii::$app->db->createCommand()->delete(
            'auth_assignment',
            ['user_id' => $userId, 'item_name' => $roleName]
        )->execute() > 0;

        if ($result) {
            AuthHelper::invalidatePermissions();
        }

        return $result;
    }

    /**
     * @param string|array $roles
     * @param bool $superAdminAllowed
     *
     * @return bool
     */
    public static function hasRole($roles, $superAdminAllowed = true)
    {
        if ($superAdminAllowed && Yii::$app->user->isSuperadmin) {
            return true;
        }
        $roles = (array)$roles;

        AuthHelper::ensurePermissionsUpToDate();

        return array_intersect($roles, Yii::$app->session->get(AuthHelper::SESSION_PREFIX_ROLES, [])) !== [];
    }

    /**
     * @param string $permission
     * @param bool $superAdminAllowed
     *
     * @return bool
     */
    public static function hasPermission($permission, $superAdminAllowed = true)
    {
        if ($superAdminAllowed && Yii::$app->user->isSuperadmin) {
            return true;
        }

        AuthHelper::ensurePermissionsUpToDate();

        return in_array($permission, Yii::$app->session->get(AuthHelper::SESSION_PREFIX_PERMISSIONS, []));
    }

    /**
     * Useful for Menu widget
     *
     * <example>
     *    ...
     *        [ 'label'=>'Some label', 'url'=>['/site/index'], 'visible'=>User::canRoute(['/site/index']) ]
     *    ...
     * </example>
     *
     * @param string|array $route
     * @param bool $superAdminAllowed
     *
     * @return bool
     */
    public static function canRoute($route, $superAdminAllowed = true)
    {
        if ($superAdminAllowed && Yii::$app->user->isSuperadmin) {
            return true;
        }

        $baseRoute = AuthHelper::unifyRoute($route);

        if (Route::isFreeAccess($baseRoute)) {
            return true;
        }

        AuthHelper::ensurePermissionsUpToDate();

        return Route::isRouteAllowed($baseRoute, Yii::$app->session->get(AuthHelper::SESSION_PREFIX_ROUTES, []));
    }

    /**
     * getStatusValue
     *
     * @param string $val
     *
     * @return string
     */
    public static function getStatusValue($val)
    {
        $array = self::getStatusList();

        return isset($array[$val]) ? $array[$val] : $val;
    }

    /**
     * getStatusList
     * @return array
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_INACTIVE => Yii::t('app', 'Inactive'),
            self::STATUS_BANNED => Yii::t('app', 'Banned'),
        );
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique'],
            ['username', 'trim'],
            [['status', 'email_confirmed'], 'integer'],
            ['email', 'email'],
            ['email', 'validateEmailConfirmedUnique'],
            ['bind_to_ip', 'validateBindToIp'],
            ['bind_to_ip', 'trim'],
            ['bind_to_ip', 'string', 'max' => 255],
            ['password', 'required', 'on' => ['newUser', 'changePassword']],
            ['password', 'string', 'max' => 255, 'on' => ['newUser', 'changePassword']],
            ['password', 'trim', 'on' => ['newUser', 'changePassword']],
            ['repeat_password', 'required', 'on' => ['newUser', 'changePassword']],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['notificationTypeId', 'safe'],
        ];
    }

    /**
     * Check that there is no such confirmed E-mail in the system
     */
    public function validateEmailConfirmedUnique()
    {
        if ($this->email) {
            $exists = User::findOne([
                'email' => $this->email,
                'email_confirmed' => 1,
            ]);

            if ($exists && $exists->id != $this->id) {
                $this->addError('email', Yii::t('app', 'This E-mail already exists'));
            }
        }
    }

    /**
     * Validate bind_to_ip attr to be in correct format
     */
    public function validateBindToIp()
    {
        if ($this->bind_to_ip) {
            $ips = explode(',', $this->bind_to_ip);

            foreach ($ips as $ip) {
                if (!filter_var(trim($ip), FILTER_VALIDATE_IP)) {
                    $this->addError('bind_to_ip', Yii::t('app', "Wrong format. Enter valid IPs separated by comma"));
                }
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Login'),
            'superadmin' => Yii::t('app', 'Superadmin'),
            'confirmation_token' => 'Confirmation Token',
            'registration_ip' => Yii::t('app', 'Registration IP'),
            'bind_to_ip' => Yii::t('app', 'Bind to IP'),
            'status' => Yii::t('app', 'Status'),
            'gridRoleSearch' => Yii::t('app', 'Roles'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'password' => Yii::t('app', 'Password'),
            'repeat_password' => Yii::t('app', 'Repeat password'),
            'email_confirmed' => Yii::t('app', 'E-mail confirmed'),
            'email' => 'E-mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['name' => 'item_name'])
            ->viaTable('auth_assignment', ['user_id' => 'id']);
    }


    /**
     * Make sure user will not deactivate himself and superadmin could not demote himself
     * Also don't let non-superadmin edit superadmin
     *
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            if (php_sapi_name() != 'cli') {
                $this->registration_ip = LittleBigHelper::getRealIp();
            }
            $this->generateAuthKey();
        } else {
            // Console doesn't have Yii::$app->user, so we skip it for console
            if (php_sapi_name() != 'cli') {
                if (Yii::$app->user->id == $this->id) {
                    // Make sure user will not deactivate himself
                    $this->status = static::STATUS_ACTIVE;

                    // Superadmin could not demote himself
                    if (Yii::$app->user->isSuperadmin && $this->superadmin != 1) {
                        $this->superadmin = 1;
                    }
                }

                // Don't let non-superadmin edit superadmin
                if (isset($this->oldAttributes['superadmin']) && !Yii::$app->user->isSuperadmin && $this->oldAttributes['superadmin'] == 1) {
                    return false;
                }
            }
        }

        // If password has been set, than create password hash
        if ($this->password) {
            $this->setPassword($this->password);
        }

        return parent::beforeSave($insert);
    }

    /**
     * Don't let delete yourself and don't let non-superadmin delete superadmin
     *
     * @inheritdoc
     */
    public function beforeDelete()
    {
        // Console doesn't have Yii::$app->user, so we skip it for console
        if (php_sapi_name() != 'cli') {
            // Don't let delete yourself
            if (Yii::$app->user->id == $this->id) {
                return false;
            }

            // Don't let non-superadmin delete superadmin
            if (!Yii::$app->user->isSuperadmin && $this->superadmin == 1) {
                return false;
            }
        }

        return parent::beforeDelete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlertSender()
    {
        return $this->hasMany(AlertUserQuery::className(), ['sender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlertRecipient()
    {
        return $this->hasMany(AlertUserQuery::className(), ['recipient_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserVisitLogs()
    {
        return $this->hasMany(UserVisitLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationTypes()
    {
        return $this->hasMany(NotificationType::className(), ['id' => 'notification_type_id'])->viaTable('user_notification_type', ['user_id' => 'id']);
    }
    
    public function afterFind()
    {
        $this->notificationTypeId = ArrayHelper::map($this->notificationTypes, 'id', 'id');
        parent::afterFind(); // TODO: Change the autogenerated stub
    }
}
