<?php

namespace app\controllers;

use Yii;
use app\models\HaveQuestionForm;
use app\models\PriceGetForm;
use yii\web\Controller;
use app\models\RecallForm;
use yii\web\Response;
use app\models\Regions;

class FormController extends Controller
{
    private $email;
    
    function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $regions = Regions::getRegions();
        $this->email = $regions[Yii::$app->params['region']]['email'] ?: Yii::$app->params['adminEmail'];
        parent::init();
    }

    public function actionRecall()
    {
        $model = new RecallForm();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->sendEmail($this->email, Yii::$app->request->referrer);
        }
        return ['message' => 'Ваша заявка принята. Ожидайте ответа.'];
    }
    
    public function actionGetprice()
    {
        $model = new PriceGetForm();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->sendEmail($this->email, Yii::$app->request->referrer);
        }
        return ['message' => 'Ваша заявка принята. Ожидайте ответа.'];
    }
    
    public function actionHavequestion()
    {
        $model = new HaveQuestionForm();
        
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $model->sendEmail($this->email, Yii::$app->request->referrer);
        }
        return ['message' => 'Ваша заявка принята. Ожидайте ответа.'];
    }
}