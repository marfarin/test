<?php

namespace frontend\models\query;

use frontend\models\NotificationType;

/**
 * This is the ActiveQuery class for [[NotificationType]].
 *
 * @see NotificationType
 */
class NotificationTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NotificationType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NotificationType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
