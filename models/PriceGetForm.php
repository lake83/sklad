<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PriceGetForm extends Model
{
    public $fio;
    public $phone;
    public $email;
    public $city;
    public $catalog_id;
    public $product_id;
    public $organization;
    public $how_did_you_know;
    public $comment;
    public $type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'city', 'organization', 'comment'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['fio', 'phone', 'city', 'organization', 'how_did_you_know', 'comment', 'type'], 'string'],
            [['email'], 'email'],
            [['catalog_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $to the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($to)
    {
        return Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject($this->type === 'clarifyprice' ? 'Уточнение стоимости' : 'Заказ прайса')
            ->setTextBody("
                ФИО: {$this->fio}
                Телефон: {$this->phone}
                Каталог: " . Catalog::findOne($this->catalog_id)->name . "
                " . ($this->type === 'clarifyprice' ? 'Продукт:' . Products::findOne($this->product_id)->name : '') . "
                Email: {$this->email}
                Город: {$this->city}
                Организация: {$this->organization}
                Откуда вы узнали о нас: {$this->how_did_you_know}
                Комментарий: {$this->comment}
            ")
            ->send();
    }
}
