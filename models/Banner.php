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
 * @property string $not_show_in_regions
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
            [['name', 'position'], 'required'],
            [['is_active', 'width', 'height'], 'integer'],
            [['images'], 'file', 'maxFiles' => 0],
            [['name', 'link', 'position'], 'string', 'max' => 255],
            ['not_show_in_regions', 'safe']
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
            'not_show_in_regions' => 'Не показывать в городах',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageToBanners()
    {
        return $this->hasMany(ImageToBanner::className(), ['banner_id' => 'id']);
    }

    public static function renderPosition($position = '', $not_slide = false) {
        $banners = self::find()->where(['position' => $position, 'is_active' => 1]);
        if ($banners->count()) {
            return Yii::$app->view->renderPhpFile(Yii::getAlias('@app'). '/views/banner/position.php', ['banners' => $banners->all(), 'position' => $position, 'not_slide' => $not_slide]);
        } else {
            return '';
        }
    }
}
