<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%products_deleted}}".
 *
 * @property integer $id
 * @property string $product_slug
 * @property string $catalog_slug
 */
class ProductsDeleted extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_deleted}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_slug', 'catalog_slug'], 'required'],
            [['product_slug', 'catalog_slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_slug' => 'Товар',
            'catalog_slug' => 'Категория товара',
        ];
    }
}