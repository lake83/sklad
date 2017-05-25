<?php
namespace app\components;

use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class LocalizedActiveRecord extends ActiveRecord
{
    public static function find()
    {
        return new RegionDataQuery(get_called_class());
    }
    
    /**
     * Relation для модели
     * Использование:
     * - с текущим регионом
     * Materials::find()->where(['id' => 3])->localized()->asArray()->one();
     * - с заданым регионом
     * Materials::find()->where(['id' => 3])->localized('spb')->asArray()->one();
     * @return ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(self::className(), ['parent_id' => 'id']);
    }
    
    /**
     * Handle 'afterFind' event of the owner.
     */
    public function afterFind()
    {
        if ($this->isRelationPopulated('location') && $related = $this->getRelatedRecords()['location']) {
            foreach ($related as $key => $value) {
                if ($this->hasAttribute($key) && !empty($value)) {
                    $this->setAttribute($key, $value);
                }
            }
        }
        parent::afterFind();
    }     
}