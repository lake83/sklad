<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $position
 * @property integer $width
 * @property integer $height
 *
 * @property ImageToBanner[] $imageToBanners
 */
class Banner extends \yii\db\ActiveRecord
{

    public $images;

    public static $positions = [
        'bannerLeft' => 'Слева',
        'maintop' => 'Сверху на главной',
    ];

        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'position', 'width', 'height'], 'required'],
            [['is_active', 'width', 'height'], 'integer'],
            [['images'], 'file', 'maxFiles' => 0],
            [['name', 'link', 'position'], 'string', 'max' => 255],
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
            'link' => 'Ссылка',
            'position' => 'Позиция',
            'is_active' => 'Активно',
            'images' => 'Изображения',
            'width' => 'Ширина',
            'height' => 'Высота',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageToBanners()
    {
        return $this->hasMany(ImageToBanner::className(), ['banner_id' => 'id']);
    }

    public static function renderPosition($position = '') {
        $banners = self::find()->where(['position' => $position, 'is_active' => 1]);
        if ($banners->count()) {
            return Yii::$app->view->renderPhpFile(Yii::getAlias('@app'). '/views/banner/position.php', ['banners' => $banners->all(), 'position' => $position]);
        } else {
            return '';
        }
    }
}
