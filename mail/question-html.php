<?php

/* @var $this yii\web\View */
/* @var $model app\models\HaveQuestionForm */
/* @var $url string */

use app\models\Catalog;
?>

<b>Фио:</b> <?=$model->fio?><br />
<b>Телефон:</b> <?=$model->phone?><br />
<b>Каталог:</b> <?=Catalog::find()->select('name')->where(['id' => $model->catalog_id])->localized()->scalar()?><br />
<b>Email:</b> <?=$model->email?><br />
<b>Вопрос:</b> <?=$model->question?><br />
<b>Отправлено с:</b> <?=$url?>