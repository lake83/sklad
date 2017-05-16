<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Materials;

/**
 * MaterialsController implements the CRUD actions for Materials model.
 */
class MaterialsController extends AdminController
{
    public function actions()
    {
        $type = Yii::$app->request->get('type');
        return [
            'index' => [
                'class' => $this->actionsPath.'Index',
                'search' => $this->modelPath.'MaterialsSearch'
            ],
            'create' => [
                'class' => $this->actionsPath.'Create',
                'model' => $this->modelPath.'Materials',
                'redirect' => ['/admin/materials/index', 'type' => $type],
                'scenario' => 'main'
            ],
            'update' => [
                'class' => $this->actionsPath.'Update',
                'model' => $this->modelPath.'Materials',
                'redirect' => Yii::$app->request->referrer,
                'scenario' => 'main'
            ],
            'delete' => [
                'class' => $this->actionsPath.'Delete',
                'model' => $this->modelPath.'Materials',
                'redirect' => ['/admin/materials/index', 'type' => $type]
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => $this->modelPath.'Materials',
                'attribute' => 'is_active'
            ]
        ];
    }
    
    /**
     * Создание и редактирование локальных версий для регионов
     * 
     * @param integer $parent_id ID родительской модели
     * @param string $region субдомен региона
     * @return string
     */
    public function actionLocalization($parent_id, $region)
    {
        if (!$model = Materials::findOne(['parent_id' => $parent_id, 'region' => $region])) {
            $model = new Materials;
            $model->slug = Materials::find()->select('slug')->where(['id' => $parent_id])->scalar();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->refresh();
        }
        return $this->render('_form', ['model' => $model]);
    }
}