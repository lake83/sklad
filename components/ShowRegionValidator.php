<?php
namespace app\components;

use Yii;
use yii\validators\Validator;

/**
 * Проверка выводится ли запись хоть в одном регионе
 */
class ShowRegionValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute == 1) {
            if ($model->parent_id == 0) {
                if (!$model::find()->where(['parent_id' => $model->id, $attribute => 0])->exists()) {
                    $this->addError($model, $attribute, 'Материал должен выводится хотя бы для одного региона.');
                }
            } else {
                if (!$model::find()->where(['id' => $model->parent_id, $attribute => 0])->exists()) {
                    if (!$model::find()->where(['parent_id' => $model->parent_id, $attribute => 0])->exists()) {
                        $this->addError($model, $attribute, 'Материал должен выводится хотя бы для одного региона.');
                    }
                }
            }
        }
    }
}
?>