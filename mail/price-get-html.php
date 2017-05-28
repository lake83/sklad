<?php

/* @var $this yii\web\View */
/* @var $model app\models\RecallForm */
/* @var $url string */

use app\models\Catalog;
use app\models\Products;
?>

<b>Фио:</b> <?=$model->fio?><br />
<b>Телефон:</b> <?=$model->phone?><br />
<b>Каталог:</b> <?=Catalog::find()->select('name')->where(['id' => $model->catalog_id])->localized()->scalar()?><br />
<?php if ($model->type === 'clarifyprice'): ?>
<b>Продукт:</b> <?=Products::find()->select('name')->where(['id' => $model->product_id])->localized()->scalar()?><br />
<?php endif; ?>
<b>Email:</b> <?=$model->email?><br />
<b>Город:</b> <?=$model->city?><br />
<b>Организация:</b> <?=$model->organization?><br />
<b>Откуда вы узнали о нас:</b> <?=$model->how_did_you_know?><br />
<b>Комментарий:</b> <?=$model->comment?><br />
<b>Отправлено с:</b> <?=$url?>