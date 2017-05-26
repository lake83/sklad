<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%catalog_options}}".
 *
 * @property integer $id
 * @property integer $catalog_id
 * @property string $name
 * @property integer $show_anons
 * @property integer $show_short
 * @property integer $position
 * @property integer $is_active
 *
 * @property Catalog $catalog
 */
class CatalogOptions extends \yii\db\ActiveRecord
{
    /**
     * @var integer используется при смене категории опции
     */
    public $change_category;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['catalog_id', 'show_anons', 'show_short', 'position', 'is_active'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'catalog_id' => 'Категория',
            'name' => 'Название',
            'show_anons' => 'Показовать в анонсе',
            'show_short' => 'Показовать в Коротко',
            'position' => 'Позиция',
            'is_active' => 'Активно',
            'change_category' => 'Сменить категорию'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }
}