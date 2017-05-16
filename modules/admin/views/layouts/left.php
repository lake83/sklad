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
        ['label' => 'Пользователи', 'url' => ['/admin/user/index'], 'icon' => 'users'],
        ['label' => 'Регионы', 'url' => ['/admin/regions/index'], 'icon' => 'arrows-alt'],
        ['label' => 'Каталог', 'url' => ['/admin/catalog/index'], 'icon' => 'table'],
        ['label' => 'Производители', 'url' => ['/admin/manufacturers/index'], 'icon' => 'address-card-o'],
        ['label' => 'Материалы', 'icon' => 'book',
            'items' => [
                ['label' => 'Новости', 'url' => ['/admin/materials/index', 'type' => 1], 'icon' => 'caret-right'],
                ['label' => 'Статьи', 'url' => ['/admin/materials/index', 'type' => 2], 'icon' => 'caret-right'],
                ['label' => 'Страницы', 'url' => ['/admin/materials/index', 'type' => 3], 'icon' => 'caret-right'],
                ['label' => 'Клиенты', 'url' => ['/admin/materials/index', 'type' => 4], 'icon' => 'caret-right']
            ]
        ],
        ['label' => 'Меню', 'url' => ['/admin/menu/index'], 'icon' => 'bars'],
        ['label' => 'Пункты меню', 'url' => ['/admin/menu-items/index'], 'icon' => 'list-ul']
    ]
]);	
?>
    </section>
</aside>