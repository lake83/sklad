<?php

/* @var $this yii\web\View */
/* @var $dataProvider app\models\Materials */

use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = 'Клиенты';
$this->registerMetaTag(['name' => 'keywords', 'content' => '']);
$this->registerMetaTag(['name' => 'description', 'content' => '']);
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Наши клиенты</h1>

<?php Pjax::begin(['id' => 'clients_items', 'timeout' => false]);

echo ListView::widget([
     'id' => 'clients_list',
     'dataProvider' => $dataProvider,
     'layout' => "{items}\n{pager}",
     'itemView' => '_clients_item'
]);

Pjax::end();
?>