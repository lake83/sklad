<?php
app\assets\AdminAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */

?>
<aside class="main-sidebar">
    <section class="sidebar">
<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Товары', 'url' => ['/admin/products/index'], 'icon' => 'shopping-basket'],
        ['label' => 'Структура каталога', 'url' => ['/admin/catalog/index'], 'icon' => 'table'],
        ['label' => 'Производители', 'url' => ['/admin/manufacturers/index'], 'icon' => 'address-card-o'],
        ['label' => 'Контент', 'icon' => 'book',
            'items' => [
                ['label' => 'Страницы', 'url' => ['/admin/materials/index', 'type' => 3], 'icon' => 'caret-right'],
                ['label' => 'Новости', 'url' => ['/admin/materials/index', 'type' => 1], 'icon' => 'caret-right'],
                ['label' => 'Акции/Баннеры', 'url' => ['/admin/banners/index'], 'icon' => 'caret-right'],
                ['label' => 'Клиенты', 'url' => ['/admin/materials/index', 'type' => 4], 'icon' => 'caret-right'],
                ['label' => 'Статьи', 'url' => ['/admin/materials/index', 'type' => 2], 'icon' => 'caret-right']
            ]
        ],
        ['label' => 'Пункты меню', 'url' => ['/admin/menu-items/index'], 'icon' => 'list-ul'],
        ['label' => 'Расположение меню', 'url' => ['/admin/menu/index'], 'icon' => 'bars'],
        ['label' => 'Регионы', 'url' => ['/admin/regions/index'], 'icon' => 'arrows-alt'],
        ['label' => 'Пользователи', 'url' => ['/admin/user/index'], 'icon' => 'users']
    ]
]);	
?>
    </section>
</aside>