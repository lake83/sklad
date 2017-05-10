<?php

use app\models\Materials;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = 'Создание ' . Materials::getTypes(Yii::$app->request->get('type'), false);

echo $this->render('_form', ['model' => $model ]) ?>