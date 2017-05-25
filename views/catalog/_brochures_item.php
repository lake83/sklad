<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\ProductsBrochures */

use yii\helpers\Html;
?>

<p><strong><?= Html::a($model->name, ['site/download', 'file' => $model->file], ['title' => 'Скачать']) ?></strong></p>