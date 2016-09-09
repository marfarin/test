<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $short_name
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $date_create
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_name', 'local', 'name', 'date_update', 'date_create'], 'required'],
            [['default', 'date_update', 'date_create'], 'integer'],
            [['short_name', 'local', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'short_name' => Yii::t('app', 'Short Name'),
            'local' => Yii::t('app', 'Local'),
            'name' => Yii::t('app', 'Name'),
            'default' => Yii::t('app', 'Default'),
            'date_update' => Yii::t('app', 'Date Update'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }

    //Переменная, для хранения текущего объекта языка
    static $current = null;

    //Получение текущего объекта языка
    public static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefaultLang();
        }
        return self::$current;
    }

    //Установка текущего объекта языка и локаль пользователя
    public static function setCurrentByShortName($shortName = null)
    {
        $language = self::getLangByShortName($shortName);
        self::$current = ($language === null) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current->local;
    }

    //Получения объекта языка по умолчанию
    public static function getDefaultLang()
    {
        return Lang::find()->where('"default" = :default', [':default' => 1])->one();
    }

    //Получения объекта языка по буквенному идентификатору
    public static function getLangByShortName($shortName = null)
    {
        if ($shortName === null) {
            return null;
        } else {
            $language = Lang::find()->where('short_name = :short_name', [':short_name' => $shortName])->one();
            if ($language === null) {
                return null;
            } else {
                return $language;
            }
        }
    }

    public static function getLanguageList()
    {
        $languages = Lang::find()->all();
        $result = [];
        foreach ($languages as $language) {
            $result[$language->local] = $language->name;
        }
        return $result;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['date_create', 'date_update'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['date_update'],
                ],
            ],
        ];
    }
}
