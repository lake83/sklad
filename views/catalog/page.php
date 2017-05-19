<?php

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $leaves app\models\Catalog */

use yii\helpers\Html;
use app\components\SiteHelper;

$this->title = $model->title ? $model->title : $model->name;
if ($model->keywords) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords], 'keywords');
}
if ($model->description) {
    $this->registerMetaTag(['name' => 'description', 'content' => $model->description], 'description');
} ?>

<h1><?= $model->name ?></h1>

<?php
echo $model->intro_text;

if (count($children)): ?>
<strong>Каталог техники:</strong>

<a href="#" class="requestbutton pull-right">Запросить прайс-лист</a>

<ul class="catalog-list row">
    <?php foreach ($children as $one):
    if ($one['not_show_region'] == 0): ?>
    <li>
        <?= Html::a(Html::img(SiteHelper::resized_image($one['image'], 120, 100), ['title' => $one['name']]) .
            '<div class="caption">' . $one['name'] . '</div>', [Yii::$app->request->pathInfo . $one['slug']])
        ?>
    </li>
    <?php endif;
    endforeach; ?>
</ul>
<?php endif;

echo $model->full_text; ?>