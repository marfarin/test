<?php

namespace frontend\models;

use Yii;
use frontend\models\query\NotificationTypeQuery;

/**
 * This is the model class for table "notification_types".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $class_name
 *
 * @property ConfigureModelEvent[] $configureModelEvents
 */
class NotificationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'class_name'], 'required'],
            [['description'], 'string'],
            [['name', 'class_name'], 'string', 'max' => 255],
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
            'class_name' => Yii::t('app', 'Class Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigureModelEvents()
    {
        return $this->hasMany(ConfigureModelEvent::className(), ['id' => 'configure_model_event_id'])->viaTable('model_events_has_notification', ['notification_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return NotificationTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationTypeQuery(get_called_class());
    }
}
