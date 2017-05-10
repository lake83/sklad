<?php
/**
 * Вывод меню из модели Menu
 */
namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Menu;
use yii\caching\TagDependency;
use yii\helpers\Url;
use app\models\Materials;

class MenuWidget extends Widget
{
    public $alias;
    public $menu = '';

    public function run()
    {
        if (!$this->alias) {
            return 'Не указан алиас меню.';
        }
        if (!$output = Yii::$app->cache->get('menu_' . $this->alias)) {
            if ($menu = Menu::find()->where(['slug' => $this->alias, 'is_active' => 1])->one()) {
                $output = '<ul>';
                foreach ($items = $menu->menuItems as $value) {
                    if ($value['parent_id'] == 0) {
                        $this->menu.= '<li><a href="' . $this->url($value) . '">' . $value['name'] . '</a>';
                        $this->children($items, $value['id']);
                        $this->menu.= '</li>';
                    }
                }
                $output.= $this->menu;
                $output.= '</ul>';
                Yii::$app->cache->set('menu_' . $this->alias, $output, 0, new TagDependency(['tags' => 'menu']));
            } else {
                return 'Меню не найдено.';
            }
        }
        return $output;
    }
    
    /**
     * Построение элементов иерархической структуры
     * 
     * @param array $items данные меню
     * @param integer $parent_id ID родительского пункта
     */
    protected function children($items, $parent_id)
    {
        foreach ($items as $item) {
            if ($item['parent_id'] == $parent_id) {
                $this->menu.= '<ul>';
                foreach ($items as $item) {
                    if ($item['parent_id'] == $parent_id) {
                        $this->menu.= '<li><a href="' . $this->url($item) . '">' . $item['name'] . '</a>';
                        $this->children($items, $item['id']);
                        $this->menu.= '</li>';
                    }
                }
                $this->menu.= '</ul>';
                break;
            }
        }
    }
    
    /**
     * Построение url пункта меню
     * 
     * @param array $item данные пункта меню
     * @return string
     */
    protected function url($item)
    {
        switch ($item['type']) {
            case 1: {
                if ($alias = Materials::find()->select('slug')->where(['id' => $item['value'], 'is_active' => 1])->scalar()) {
                    return Url::to(['materials/page', 'alias' => $alias]);
                } else {
                    return '#';
                }
            }
            case 2:
                return Url::to(['materials/' . $item['value']]);
            default:
                return Url::to([$item['value']]);
        }
    }
}
?>