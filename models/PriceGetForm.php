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
            ['fio', 'match', 'pattern' => '/^(([a-z\(\)\s]+)|([а-яё\(\)\s]+))$/isu'],
            ['phone', 'string', 'max' => 20],
            ['phone', 'match', 'pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $to the target email address
     * @param  string  $url страница (URL) с которой было отправлено сообщение
     * @return boolean whether the email was sent
     */
    public function sendEmail($to, $url)
    {
        return Yii::$app->mailer->compose(['html' => 'price-get-html'], ['model' => $this, 'url' => $url])
            ->setTo($to)
            ->setBcc('support@astonia.ru')
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject(($this->type === 'clarifyprice' ? 'Уточнение стоимости' : 'Заказ прайса') . ' на сайте' . Yii::$app->name)
            ->send();
    }
}