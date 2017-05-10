<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $exception->statusCode . ' ' . nl2br(Html::encode($message));
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Возможные причины, по которым вы увидели это сообщение:</p>
<ul>
    <li>Вы неправильно ввели путь к странице в адресной строке</li>
    <li>Вы перешли по старой ссылке из закладок</li>
    <li>Вы перешли по неправильной ссылке из поисковой системы</li>
</ul>
<p>Если вы попали сюда, нажав на ссылку на нашем сайте, то можете написать об этом по адресу <a href="mailto:zapros@maxi-sklad.ru">zapros@maxi-sklad.ru</a></p>
<p><a href="/">Перейти на главную страницу</a> сайта.</p>