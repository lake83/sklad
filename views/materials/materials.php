<?php

/* @var $this yii\web\View */
/* @var $type integer */
/* @var $dataProvider app\models\Materials */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = $type == 1 ? 'Новости' : 'Статьи';
$this->registerMetaTag(['name' => 'keywords', 'content' => $type == 1 ? '' : '']);
$this->registerMetaTag(['name' => 'description', 'content' => $type == 1 ? '' : '']);
$this->params['breadcrumbs'][] = ['label' => 'Пресс-центр', 'url' => ['/press-centr']];

Pjax::begin(['id' => 'materials_items', 'timeout' => false]);

echo ListView::widget([
     'id' => 'materials_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n{pager}",
     'itemView' => '_materials_item'
]);

Pjax::end();
?>