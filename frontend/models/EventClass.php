<?php

namespace frontend\models;

use common\helpers\ClassListHelper;
use frontend\models\query\EventClassQuery;
use Yii;

/**
 * This is the model class for table "event_class".
 *
 * @property integer $id
 * @property string $class_name
 * @property string $event_name
 * @property string $classNameEventName
 * 
 * @property ConfigureModelEvent[] $configureModelEvents
 */
class EventClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_name', 'event_name'], 'required'],
            [['event_name', 'class_name'], 'string', 'max' => 255],
            [['event_name', 'class_name'], 'unique', 'targetAttribute' => ['event_name', 'class_name']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'class_name' => Yii::t('app', 'Class Name'),
            'event_name' => Yii::t('app', 'Event Name'),
        ];
    }

    /**
     * @return string
     */
    public function getClassNameEventName()
    {
        return $this->class_name.'::'.$this->event_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigureModelEvents()
    {
        return $this->hasMany(ConfigureModelEvent::className(), ['event_class_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return EventClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventClassQuery(get_called_class());
    }

    /**
     * 
     * @return ClassListHelper[]
     */
    public static function getClassList()
    {
        $models = [];
        
        foreach (Yii::$classMap as $className => $classPath) {
            if (is_subclass_of($className, 'yii\base\Model')) {
                $models[] = new \ReflectionClass($className);
                $classPath = $className;
            }
        }

        $models = array_merge($models, ClassListHelper::getClassList(Yii::getAlias('@frontend')));
        $models = array_merge($models, ClassListHelper::getClassList(Yii::getAlias('@common')));
        $models = array_merge($models, ClassListHelper::getClassList(Yii::getAlias('@console')));
        $models = array_merge($models, ClassListHelper::getClassList(Yii::getAlias('@backend')));

        $resultArray = [];
        /**
         * @var $models \ReflectionClass[]
         */
        foreach ($models as $model) {
            foreach (ClassListHelper::getConstantList($model) as $constant) {
                $tmp = new self();
                $tmp->class_name = $model->name;
                $tmp->event_name = $constant;
                $tmp->save();
                if ($tmp->getErrors() == []) {
                    $resultArray[] = $tmp;
                }

            }
        }
        //var_dump($resultArray);
        return $resultArray;
    }

}
