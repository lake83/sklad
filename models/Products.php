<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use app\components\LocalizedActiveRecord;
use yii\caching\TagDependency;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property integer $id
 * @property integer $catalog_id
 * @property string $name
 * @property string $slug
 * @property integer $parent_id
 * @property string $region
 * @property string $image
 * @property double $price
 * @property integer $currency
 * @property integer $not_show_price
 * @property integer $manufacturer_id
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $not_show_region
 * @property integer $is_active
 * 
 * @property Catalog $catalog
 * @property CatalogOptions[] $anonsOptions
 * @property ProductsRelated[] $productsRelated
 * @property ProductsVideo[] $productsVideo
 * @property ProductsBrochures[] $broductsBrochures
 */
class Products extends LocalizedActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'manufacturer_id'], 'required'],
            [['catalog_id', 'name', 'currency'], 'required', 'on' => 'main'],
            [['catalog_id', 'parent_id', 'currency', 'not_show_price', 'manufacturer_id', 'not_show_region', 'is_active'], 'integer'],
            [['price'], 'number'],
            [['full_text', 'description'], 'string'],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255],
            [['region'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 100],
            ['not_show_region', \app\components\ShowRegionValidator::className()],
            ['slug', 'unique', 'on' => 'clone'],
            ['currency', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_id' => 'Категория',
            'name' => 'Название',
            'parent_id' => 'Родитель',
            'slug' => 'Алиас',
            'region' => 'Регион',
            'image' => 'Изображение',
            'price' => 'Цена',
            'currency' => 'Валюта',
            'not_show_price' => 'Не показовать цену',
            'manufacturer_id' => 'Производитель',
            'full_text' => 'Полный текст',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'not_show_region' => 'Не выводить для региона',
            'is_active' => 'Активно'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsRelated()
    {
        return $this->hasMany(self::className(), ['id' => 'related_id'])->viaTable(ProductsRelated::tableName(), ['product_id' => 'id'])->localized();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsVideo()
    {
        return $this->hasMany(ProductsVideo::className(), ['product_id' => 'id'])->andWhere(['is_active' => 1]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsBrochures()
    {
        return $this->hasMany(ProductsBrochures::className(), ['product_id' => 'id'])->andWhere(['is_active' => 1]);
    }
    
    /**
     * Опции спецификации товара
     * 
     * @param boolean $anons опции для анонса
     * @return array
     */
    public function getOptions($anons = false)
    {
        $parents = $this->catalog->parents()->andWhere(['is_active' => 1])->column();
        return CatalogOptions::find()->select('name,value,show_short')
            ->where(['catalog_id' => $this->catalog_id, 'is_active' => 1])
            ->orWhere(['catalog_id' => $parents])
            ->join('RIGHT JOIN', ProductsOptions::tableName(), 'option_id='.CatalogOptions::tableName().'.id' . ($anons ? ' AND show_anons=1' : '') . ' AND product_id='.$this->id)
            ->asArray()->all();
    }
    
    /**
     * Возвращает список валют или название валюты
     * 
     * @param integer $key ключ в массиве названий
     * @return mixed
     */
    public static function getСurrency($key = null)
    {
        $currency = [1 => 'руб', 2 => 'USD', 3 => 'EUR'];
        return is_null($key) ? $currency : $currency[$key];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'product');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'product');
        
        self::deleteAll(['parent_id' => $this->id]);
        self::deleteAll(['name' => '', 'image' => '', 'currency' => '', 'not_show_price' => '', 'full_text' => '', 'title' => '', 'keywords' => '', 'description' => '', 'not_show_region' => 0]);
        
        parent::afterDelete();
    }
    
    /**
     * Создание url товара
     * 
     * @return string
     */
    public function getUrl()
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) {
            $parents = Catalog::findOne($this->catalog_id)->parents()->asArray()->all();
            $slug = '';
            foreach ($parents as $parent) {
                if ($parent['not_show_region'] == 0) {
                    $slug.= $parent['slug'] . '/';
                }
            }
            return Url::to(['catalog/product', 'alias' => $slug . $this->slug]);
        }, 0, new TagDependency(['tags' => 'product']));
    }
}