<?php

namespace app\components;

use Yii;

/**
 * Формирование данных в зависимости от региона
 */
class RegionDataQuery extends \yii\db\ActiveQuery
{
    /**
     * Локализация по региону
     * @param string $region субдомен региона
     * @return ActiveQuery
     */
    public function localized($region = null)
    {
        $region = is_null($region) ? Yii::$app->params['region'] : $region;
        $this->with(['location' => function ($query) use ($region) {
            $query->andWhere(['region' => $region]);
        }]);
        return $this;
    }
    
    public function populate($rows)
    {
        $models = parent::populate($rows);
        
        if (!$this->asArray) {
            return $models;
        } else {
            foreach ($models as &$model) {
                if (!empty($model['location'])) {
                    foreach ($model['location'] as $key => $value) {
                        if (array_key_exists($key, $model) && !empty($value)) {
                            $model[$key] = $value;
                        }
                    }                   
                }
            }
            unset($model['location']);
            
            return $models;
        }
    }
}
?>