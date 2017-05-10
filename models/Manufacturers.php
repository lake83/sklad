<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%manufacturers}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $title
 * @property string $keywords
 * @property string $meta_description
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
            [['name'], 'required'],
            [['description', 'meta_description'], 'string'],
            [['is_active'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['title', 'keywords'], 'string', 'max' => 255]
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
            'description' => 'Описание',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'meta_description' => 'Description',
            'is_active' => 'Активно',
        ];
    }
}