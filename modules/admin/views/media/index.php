<?php

/* @var $this yii\web\View */
/* @var $configPath array */

use xvs32x\tinymce\TinymceAsset;

$this->title = 'Медиабиблиотека';

$this->registerJs("
    $('#modal_filemanager').css('height', document.body.clientHeight - 200 + 'px');
");
?>

<iframe id="modal_filemanager" width="100%" frameborder="0" src="<?=Yii::$app->request->hostInfo . TinymceAsset::register($this)->baseUrl .
    '/filemanager/dialog.php?type=2&field_id=&relative_url=1&descending=false&lang=ru&akey=' . urlencode(serialize($configPath));?>">
</iframe>