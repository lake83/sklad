<?php
/**
 * Вывод списка городов из модели Regions и геолокация
 */
namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Regions;
use jisoft\sypexgeo\Sypexgeo;
use yii\web\Cookie;

class RegionSelect extends Widget
{  
    public $regions;
    
    public function run()
    {        
        if (!isset($_COOKIE['region'])) {
            $geo = new Sypexgeo();
            $geo->get();
            
            $l = [];
            foreach ($this->regions as $region) {
                $width = abs($region['lat'] - $geo->city['lat']);
                $height = abs($region['lng'] - $geo->city['lon']);
                $length = sqrt(pow($width,2) + pow($height,2));
                $l[$region['subdomain']] = $length;
            }
            $min = array_keys($l, min($l))[0];
            $thisRegion = $min ? $min : '';
            
            Yii::$app->params['region'] = $thisRegion;
            
        } else {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'region',
                'value' => Yii::$app->params['region'],
                'expire' => time() + 86400*30,
                'domain' => '.' . DOMAIN
            ]));
        }
        return $this->render('/widgets/region_select', [
            'regions' => $this->regions, 
            'thisRegion' => $thisRegion
        ]); 
    }   
}