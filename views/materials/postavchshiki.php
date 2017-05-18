<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Manufacturers */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Наши поставщики';
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->params['breadcrumbs'][] = ['label' => 'О компании', 'url' => ['/about']];

Pjax::begin(['id' => 'manufacturers_items', 'timeout' => false]);

echo ListView::widget([
     'id' => 'manufacturers_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n{pager}",
     'itemView' => '_manufacturer_item'
]);

Pjax::end();
?>