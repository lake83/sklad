<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use app\components\CatalogQuery;
use yii\behaviors\SluggableBehavior;
use app\models\CatalogRegions;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%catalog}}".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property string $intro_text
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $not_show_region
 * @property integer $is_active
 */
class Catalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog}}';
    }
    
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className()
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ]
        ];
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new CatalogQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => 'main'],
            [['intro_text', 'full_text', 'description'], 'string'],
            [['lft', 'is_active', 'not_show_region', 'rgt', 'depth'], 'integer'],
            ['image', 'string', 'max' => 100],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255],
            ['not_show_region', \app\components\ShowRegionValidator::className()],
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
        
        CatalogRegions::deleteAll(['name' => '', 'image' => '', 'intro_text' => '', 'full_text' => '', 'title' => '', 'keywords' => '', 'description' => '', 'not_show_region' => 0]);
        
        parent::afterDelete();
    }
    
    /**
     * Relation для модели
     * Использование:
     * - с текущим регионом
     * Catalog::find()->where(['id' => 3])->localized()->asArray()->one();
     * - с заданым регионом
     * Catalog::find()->where(['id' => 3])->localized('spb')->asArray()->one();
     * @return ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(CatalogRegions::className(), ['catalog_id' => 'id']);
    }
    
    /**
     * Handle 'afterFind' event of the owner.
     */
    public function afterFind()
    {
        if ($this->isRelationPopulated('location') && $related = $this->getRelatedRecords()['location']) {
            foreach ($related as $key => $value) {
                if ($this->hasAttribute($key) && !empty($value)) {
                    $this->setAttribute($key, $value);
                }
            }
        }
        parent::afterFind();
    }      
}
