<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;
use app\components\LocalizedActiveRecord;
use app\components\LogBehavior;

/**
 * This is the model class for table "{{%materials}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $parent_id
 * @property string $region
 * @property string $image
 * @property string $intro_text
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $type
 * @property integer $in_slider
 * @property integer $not_show_region
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 */
class Materials extends LocalizedActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%materials}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'immutable' => true
            ],
            LogBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'full_text', 'type'], 'required', 'on' => 'main'],
            [['intro_text', 'full_text', 'description'], 'string'],
            [['parent_id', 'type', 'in_slider', 'is_active', 'not_show_region', 'updated_at'], 'integer'],
            ['region', 'string', 'max' => 50],
            ['image', 'string', 'max' => 100],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255],
            ['not_show_region', \app\components\ShowRegionValidator::className()],
            ['created_at', 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'created_at'],
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
            'parent_id' => 'Родитель',
            'slug' => 'Алиас',
            'region' => 'Регион',
            'image' => 'Изображение',
            'intro_text' => 'Короткий текст',
            'full_text' => 'Полный текст',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'type' => 'Тип',
            'in_slider' => 'Показовать в слайдере "Нам доверяют"',
            'not_show_region' => 'Не выводить для региона',
            'is_active' => 'Активно',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }
    
    /**
     * Возвращает список типов материалов или название типа
     * 
     * @param integer $key ключ в массиве названий
     * @param boolean $count названия в зависимости от количества
     * @return mixed
     */
    public static function getTypes($key = null, $count = true)
    {
        $type = $count ? [1 => 'Новости', 2 => 'Статьи', 3 => 'Страницы', 4 => 'Клиенты'] : [1 => 'новость', 2 => 'статью', 3 => 'страницу', 4 => 'клиента'];
        return is_null($key) ? $type : $type[$key];
    }
    
    /**
     * Возвращает список страниц
     * 
     * @return array
     */
    public static function getPages()
    {
        return ArrayHelper::map(self::find()->select('id,name')->where(['type' => 3, 'is_active' => 1])->asArray()->all(), 'id', 'name');
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->type == 1) {
            TagDependency::invalidate(Yii::$app->cache, 'news');
        }
        if ($this->type == 4) {
            TagDependency::invalidate(Yii::$app->cache, 'clients');
        }
        if ($this->slug == 'main') {
            TagDependency::invalidate(Yii::$app->cache, 'main');
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        if ($this->type == 1) {
            TagDependency::invalidate(Yii::$app->cache, 'news');
        }
        if ($this->type == 4) {
            TagDependency::invalidate(Yii::$app->cache, 'clients');
        }
        if ($this->slug == 'main') {
            TagDependency::invalidate(Yii::$app->cache, 'main');
        }
        self::deleteAll(['parent_id' => $this->id]);
        self::deleteAll(['name' => '', 'image' => '', 'intro_text' => '', 'full_text' => '', 'title' => '', 'keywords' => '', 'description' => '', 'not_show_region' => 0]);
        
        parent::afterDelete();
    }
    
    /**
     * Список Клиентов
     * 
     * @param boolean $in_slider данные для слайдера "Нам доверяют"
     * @return array
     */
    public static function getClients($in_slider = false)
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) use ($in_slider) {
            $query = self::find()->where(['type' => 4, 'is_active' => 1]);
            if ($in_slider) {
                $query->andWhere(['in_slider' => 1]);
            }
            return $query->localized()->asArray()->all();
        }, 0, new TagDependency(['tags' => 'clients']));
    }
}