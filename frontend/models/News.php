<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $preview
 * @property string $news
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $author
 */
class News extends \yii\db\ActiveRecord
{
    
    const CREATE_NEWS = 'create_news';
    
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
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'preview', 'news'], 'required'],
            [['author_id'], 'integer'],
            [['news'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['preview'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'preview' => Yii::t('app', 'Preview'),
            'news' => Yii::t('app', 'News'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @inheritdoc
     * @return \frontend\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\NewsQuery(get_called_class());
    }

    public function beforeValidate()
    {
        var_dump('qqqqqq');
        if ($this->isNewRecord) {
            $this->author_id = Yii::$app->user->id;
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }
}