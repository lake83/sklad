<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Materials */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Новости';
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->params['breadcrumbs'][] = ['label' => 'Пресс-центр', 'url' => ['/press-centr']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $this->title ?></h1>

<?php Pjax::begin(['id' => 'news_items', 'timeout' => false]);

echo ListView::widget([
     'id' => 'news_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n{pager}",
     'itemView' => '_materials_item'
]);

Pjax::end();
?>