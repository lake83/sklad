<?php
namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\Object;
use app\models\Catalog;
use app\models\Products;
use app\models\ProductsDeleted;
use app\models\Materials;
 
class UrlRule extends Object implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        if ($route === 'materials/page') {
            if (isset($params['alias'])) {
                return $params['alias'] . '/';
            }
        }
        if ($route === 'catalog/page') {
            if (isset($params['alias'])) {
                $alias = $params['alias'];
                unset($params['alias']);
                if ($params) {
                    return Yii::$app->request->pathInfo . '?' . http_build_query($params);
                } else {
                    return $alias . '/';
                }
            }
        }
        if ($route === 'catalog/product') {
            if (isset($params['alias'])) {
                return $params['alias'] . '/';
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        if (strpos($pathInfo, 'admin') === false && strpos($pathInfo, 'catalog') !== false) {
            $pathInfo = explode('/', $pathInfo);
            $alias = end($pathInfo);
            if (Catalog::find()->where(['slug' => $alias, 'is_active' => 1])->exists()) {
                $params['alias'] = $alias;
                return ['catalog/page', $params];
            }
            if (Products::find()->where(['slug' => $alias, 'is_active' => 1])->exists()) {
                $params['alias'] = $alias;
                return ['catalog/product', $params];
            } elseif ($deleted = ProductsDeleted::find()->where(['product_slug' => $alias])->asArray()->one()) {
                return ['catalog/deleted', ['alias' => $deleted['catalog_slug']]];
            }
            return false;
        }
        if (strpos($pathInfo, '/') !== false && Materials::find()->where(['slug' => $pathInfo, 'is_active' => 1])->exists()) {
            $params['alias'] = $pathInfo;
            return ['materials/page', $params];
        }
        return false;
    }
}