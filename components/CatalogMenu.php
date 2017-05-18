<?php
/**
 * Вывод списка городов из модели Regions и геолокация
 */
namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Catalog;
use yii\caching\TagDependency;

class CatalogMenu extends Widget
{  
    public function run()
    {        
        $db = Yii::$app->db;
        $catalogItems = $db->cache(function ($db) {
            $items = Catalog::find()->orderBy('lft ASC')->localized()->asArray()->all();
            foreach ($items as $key => $item) {
                if ($item['depth'] > 0) {
                    $p = Catalog::findOne($item['id']);
                    if (!$parents = $p->parents()->asArray()->all()) {
                        $items[$key]['slug'] = $items[0]['slug'] . '/' . $items[$key]['slug'];
                    }                    
                    $slug = '';
                    foreach ($parents as $parent) {
                        $slug.= $parent['slug'] . '/';
                    }
                    $items[$key]['slug'] = $slug . $items[$key]['slug'];
                }
            }
            return $items;
        }, 0, new TagDependency(['tags' => 'catalog']));
        
        return $this->render('/widgets/catalog_menu', [
            'catalogItems' => $catalogItems
        ]); 
    }   
}