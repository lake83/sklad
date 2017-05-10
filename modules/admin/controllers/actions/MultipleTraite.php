<?php
namespace app\modules\admin\controllers\actions;

use Yii;
use app\models\MultipleModel;
use yii\helpers\ArrayHelper;

trait MultipleTraite
{
    /**
     * Создание записей
     * @param object $model модель
     * @param array $models модели для сохранения
     * @param string $owner атрибут для связи с родительской записью
     * @return boolean
     */
    protected function multipleCreate($model, $models, $owner)
    {
        $models = MultipleModel::createMultiple($models);
        MultipleModel::loadMultiple($models, Yii::$app->request->post());

        if (MultipleModel::validateMultiple($models)) {
            $flag = true;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($models as $one) {
                    $one->{$owner} = $model->id;
                    if (!($flag = $one->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        return false;
    }
    
    /**
     * Создание записей
     * @param object $model модель
     * @param string $modelsClass класс моделей
     * @param array $models модели для сохранения
     * @param string $owner атрибут для связи с родительской записью
     * @return boolean
     */
    protected function multipleUpdate($model, $modelsClass, $models, $owner)
    {
        $oldIDs = ArrayHelper::map($models, 'id', 'id');
        $models = MultipleModel::createMultiple($modelsClass::classname(), $models);
        MultipleModel::loadMultiple($models, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($models, 'id', 'id')));

        if (MultipleModel::validateMultiple($models)) {
            $flag = true;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!empty($deletedIDs)) {
                    $modelsClass::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($models as $one) {
                    $one->{$owner} = $model->id;
                    if (!($flag = $one->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        return false;
    }
}
?>