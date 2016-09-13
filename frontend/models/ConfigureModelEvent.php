<?php

namespace frontend\models;

use Yii;
use common\models\User;
use frontend\models\query\ConfigureModelEventQuery;
use common\models\rbacDB\Role;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "configure_model_event".
 *
 * @property integer $id
 * @property integer $event_class_id
 * @property string $name
 * @property string $description
 * @property integer $from
 * @property boolean $for_all
 * @property string $message_text
 * @property string $message_header
 * @property string $classNameEventName
 *
 * @property NotificationType[] $notificationTypes
 * @property User[] $users
 * @property EventClass $eventClass
 * @property Role[] $roles
 */
class ConfigureModelEvent extends \yii\db\ActiveRecord
{
    /**
     * @var array
     */
    public $notificationTypeId;

    /**
     * @var array
     */
    public $userId;

    /**
     * @var array
     */
    public $roleId;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configure_model_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'from', 'event_class_id'], 'required'],
            [['description', 'message_text', 'message_header'], 'string'],
            [['from', 'event_class_id'], 'integer'],
            [['for_all'], 'boolean'],
            [['name'], 'string', 'max' => 255],
            [['roleId', 'userId', 'notificationTypeId'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'from' => Yii::t('app', 'From'),
            'for_all' => Yii::t('app', 'For All'),
            'message_text' => Yii::t('app', 'Message Text'),
            'message_header' => Yii::t('app', 'Message Header'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotificationTypes()
    {
        return $this->hasMany(NotificationType::className(), ['id' => 'notification_type_id'])
            ->viaTable('notification_type_configure_model_event', ['configure_model_event_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('user_configure_model_event', ['configure_model_event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventClass()
    {
        return $this->hasOne(EventClass::className(), ['id' => 'event_class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'from']);
    }
    
    public function getClassNameEventName()
    {
        if ($this->eventClass === null) {
            return null;
        }
        return $this->eventClass->classNameEventName;
    }

    public function getClassName()
    {
        if ($this->eventClass === null) {
            return null;
        }
        return $this->eventClass->class_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['name' => 'auth_item_id'])->viaTable('auth_item_configure_model_event', ['configure_model_event_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return ConfigureModelEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigureModelEventQuery(get_called_class());
    }

    public function afterFind()
    {
        $this->userId = ArrayHelper::map($this->users, 'id', 'id');
        $this->roleId = ArrayHelper::map($this->roles, 'name', 'name');
        $this->notificationTypeId = ArrayHelper::map($this->notificationTypes, 'id', 'id');
        parent::afterFind(); // TODO: Change the autogenerated stub
    }
}