<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Products */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Результаты поиска';
?>

<h1><?=$this->title?></h1>

<?php
Pjax::begin(['id' => 'products_items', 'timeout' => false]);

echo ListView::widget([
     'id' => 'products_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n<div class='clearfix'></div>{pager}",
     'itemView' => '/catalog/_product_item'
]);

Pjax::end(); ?>