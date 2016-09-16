<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "{{%alert_user_query}}".
 *
 * @property integer $id
 * @property string $header
 * @property string $text
 * @property integer $sender_id
 * @property integer $recipient_id
 * @property string $created_at
 * @property string $readed_at
 *
 * @property User $sender
 * @property User $recipient
 */
class AlertUserQuery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%alert_user_query}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header', 'text', 'sender_id', 'recipient_id'], 'required'],
            [['text'], 'string'],
            [['sender_id', 'recipient_id'], 'integer'],
            [['created_at', 'readed_at'], 'safe'],
            [['header'], 'string', 'max' => 256],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'header' => Yii::t('app', 'Header'),
            'text' => Yii::t('app', 'Text'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'readed_at' => Yii::t('app', 'Readed At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    /**
     * @inheritdoc
     * @return \frontend\models\query\AlertUserQueryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\AlertUserQueryQuery(get_called_class());
    }
}
