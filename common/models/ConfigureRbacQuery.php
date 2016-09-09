<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ConfigureRbac]].
 *
 * @see ConfigureRbac
 */
class ConfigureRbacQuery extends ActiveQuery
{
    const EVENT_ERP = 'ERP';
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    
    /**
     * @inheritdoc
     * @return ConfigureRbac[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ConfigureRbac|array|null
     */
    public function one($db = null)
    {
        $this->trigger(self::EVENT_ERP);
        return parent::one($db);
    }
}
