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
$this->params['breadcrumbs'][] = ['label' => $model->type !== 4 ? 'Пресс-центр' : 'Клиенты', 'url' => [$model->type !== 4 ? '/press-centr' : '/clients']];
if ($model->type !== 4) {
    $this->params['breadcrumbs'][] = ['label' => $model->type == 1 ? 'Новости' : 'Статьи', 'url' => [$model->type == 1 ? '/press-centr/news' : '/press-centr/stati']];
}
?>

<h1><?= $model->name ?></h1>

<?= $model->full_text ?>