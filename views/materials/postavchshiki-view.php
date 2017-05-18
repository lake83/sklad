<?php

/* @var $this yii\web\View */
/* @var $model app\models\Manufacturers */

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords]);
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
}
$this->params['breadcrumbs'][] = ['label' => 'О компании', 'url' => ['/about']];
$this->params['breadcrumbs'][] = ['label' => 'Наши поставщики', 'url' => ['/about/nashi_postavchshiki']];
?>

<h1><?= $model->name ?></h1>

<?= $model->full_text ?>