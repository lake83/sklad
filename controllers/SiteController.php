<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Materials;
use yii\caching\TagDependency;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $db = Yii::$app->db;
        $main = $db->cache(function ($db) {
            return Materials::find()->where(['slug' => 'main'])->localized()->one();
        }, 0, new TagDependency(['tags' => 'main']));
        $news = $db->cache(function ($db) {
            return Materials::find()->where(['type' => 1, 'is_active' => 1, 'parent_id' => 0])->orderBy('created_at DESC')->limit(2)->localized()->asArray()->all();
        }, 0, new TagDependency(['tags' => 'news']));
        
        return $this->render('index', ['main' => $main, 'slider' => Materials::getClients(), 'news' => $news]);
    }
    
    /**
     * Установка нового региона в куки пользователя.
     * 
     * @param string|null $subdomain субдомен региона
     * @return string
     */
    public function actionRegion($subdomain)
    {
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'region',
            'value' => $subdomain,
            'expire' => time() + 86400*30,
            'domain' => '.' . DOMAIN
        ]));
        Yii::$app->params['region'] = $subdomain;
        return $this->redirect((Yii::$app->request->isSecureConnection ? 'https://' : 'http://') . ($subdomain ? $subdomain . '.' : '') . DOMAIN);
    }

    /**
     * Login admin action.
     *
     * @return string
     */
    public function actionAdmin()
    {
        $this->layout = '@app/modules/admin/views/layouts/main-login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $status = $model->login()) {
            return $this->redirect(['admin/user/index']);
        }
        return $this->render('@app/modules/admin/views/admin/login', ['model' => $model]);
    }
}