<?php

namespace app\modules\admin\controllers;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends AdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => $this->actionsPath.'Index',
                'search' => $this->modelPath.'LogSearch'
            ],
            'delete' => [
                'class' => $this->actionsPath.'Delete',
                'model' => $this->modelPath.'Log'
            ]
        ];
    }
}