<?php

/* @var $this yii\web\View */
/* @var $model app\models\Materials */

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords]);
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
}

echo $model->full_text;
?>