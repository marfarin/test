<?php

namespace frontend\models\query;

use frontend\models\ConfigureModelEvent;

/**
 * This is the ActiveQuery class for [[ConfigureModelEvent]].
 *
 * @see ConfigureModelEvent
 */
class ConfigureModelEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ConfigureModelEvent[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ConfigureModelEvent|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
