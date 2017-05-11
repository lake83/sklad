<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;

/**
 * This is the model class for table "{{%materials}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $image
 * @property string $intro_text
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $type
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 */
class Materials extends \yii\db\ActiveRecord
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
                'attribute' => 'name'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'full_text', 'type'], 'required'],
            [['intro_text', 'full_text', 'description'], 'string'],
            [['type', 'is_active', 'created_at', 'updated_at'], 'integer'],
            ['image', 'string', 'max' => 100],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255],
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
            'type' => 'Тип',
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
        if ($this->type == 4) {
            TagDependency::invalidate(Yii::$app->cache, 'clients');
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        if ($this->type == 4) {
            TagDependency::invalidate(Yii::$app->cache, 'clients');
        }
        parent::afterDelete();
    }
    
    /**
     * Список Клиентов
     * 
     * @return array
     */
    public static function getClients()
    {
        $db = Yii::$app->db;
        return $db->cache(function ($db) {
            return self::find()->select('slug,name,image')->where(['type' => 4, 'is_active' => 1])->asArray()->all();
        }, 0, new TagDependency(['tags' => 'clients']));
    }
}