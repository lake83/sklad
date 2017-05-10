<?php

use app\models\Materials;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Редактирование ' . Materials::getTypes($model->type, false) . ': ' . $model->name;

echo $this->render('_form', ['model' => $model]) ?>