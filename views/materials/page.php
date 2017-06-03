<?php

/* @var $this yii\web\View */
/* @var $model app\models\Materials */

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords], 'keywords');
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description], 'description');
} else {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->name . ': информация о компании на сайте ' . Yii::$app->request->hostName], 'description');
}
if (!isset($title) || $title === true): ?>

<h1><?= $model->name ?></h1>

<?php endif;

echo $model->full_text ?>