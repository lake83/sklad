<?php

namespace app\components;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * Формирование данных в зависимости от региона
 */
class CatalogQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
} 
?>