<?php

namespace app\models;

use Yii;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%catalogRegions}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $article_name
 * @property integer $catalog_id
 * @property string $region
 * @property string $image
 * @property string $intro_text
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $not_show_region
 * @property integer $is_active
 *
 * @property Catalog $catalog
 */
class CatalogRegions extends \yii\db\ActiveRecord
{
    public $slug;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_regions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'not_show_region', 'is_active'], 'integer'],
            [['intro_text', 'full_text', 'description'], 'string'],
            [['name', 'article_name', 'title', 'keywords'], 'string', 'max' => 255],
            [['region'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 100],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'article_name' => 'Заголовок',
            'slug' => 'Алиас',
            'image' => 'Изображение',
            'intro_text' => 'Короткий текст',
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
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        TagDependency::invalidate(Yii::$app->cache, 'catalog');
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        TagDependency::invalidate(Yii::$app->cache, 'catalog');
        
        parent::afterDelete();
    }
}
