<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%manufacturers}}".
 *
 * @property integer $id
 * @property string $brand
 * @property string $image
 * @property string $name
 * @property string $slug
 * @property string $intro_text
 * @property string $full_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property integer $is_active
 */
class Manufacturers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manufacturers}}';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            [['brand', 'name'], 'required'],
            [['intro_text', 'full_text', 'description'], 'string'],
            [['is_active'], 'integer'],
            [['brand', 'image'], 'string', 'max' => 100],
            [['name', 'slug', 'title', 'keywords'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand' => 'Бренд',
            'image' => 'Лого',
            'name' => 'Название',
            'slug' => 'Алиас',
            'intro_text' => 'Короткий текст',
            'full_text' => 'Полный текст',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'is_active' => 'Активно',
        ];
    }
}