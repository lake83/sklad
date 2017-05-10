<?php

namespace app\modules\admin\controllers;

use Yii;

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
                'redirect' => ['/admin/materials/index', 'type' => $type]
            ],
            'update' => [
                'class' => $this->actionsPath.'Update',
                'model' => $this->modelPath.'Materials',
                'redirect' => ['/admin/materials/index', 'type' => $type]
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
}