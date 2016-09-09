<?php

namespace frontend\models\query;

use frontend\models\EventClass;

/**
 * This is the ActiveQuery class for [[EventClass]].
 *
 * @see EventClass
 */
class EventClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EventClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EventClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
