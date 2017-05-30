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
?>

<h1><?= $this->title ?></h1>

<?php Pjax::begin(['id' => ($type == 1 ? 'news' : 'articles') . '_items']);

echo ListView::widget([
     'id' => ($type == 1 ? 'news' : 'articles') . '_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n{pager}",
     'itemView' => '_materials_item'
]);

Pjax::end();
?>