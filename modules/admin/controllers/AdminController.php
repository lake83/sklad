<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use yii\base\DynamicModel;
use yii\caching\TagDependency;

class AdminController extends Controller
{
    public $layout = '@app/modules/admin/views/layouts/main';
    
    public $actionsPath = 'app\modules\admin\controllers\actions\\';
    
    public $modelPath = 'app\models\\';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->status == User::ROLE_ADMIN) {
            Yii::$app->errorHandler->errorAction = 'admin/admin/error';
        }
        parent::init();
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [$this->action->id],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                            return Yii::$app->user->status == User::ROLE_ADMIN;                    
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }
    
    /**
     * Редактирование настроек в админ панели
     * 
     * @return array|object
     */
    public function actionSettings()
    {
        $request = Yii::$app->request;
        $model = $request->post('DynamicModel');
                
        if ($model && Yii::$app->db->createCommand('UPDATE settings SET value="'.array_values($model)[0].'" WHERE name="'.array_keys($model)[0].'"')->execute()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            TagDependency::invalidate(Yii::$app->cache, 'settings');        
            return [
                'message' => '<div class="alert-success alert fade in">Изменения сохранены.</div>',
                'name' => array_keys($model)[0],
                'value' => array_values($model)[0]
            ];
        }
        if ($request->isAjax && $field = $request->post('field')) {
            $param = (new \yii\db\Query())->from('settings')->where(['name' => $field])->one();
            $model = new DynamicModel([$field]);
            $model->addRule($field, 'required')->addRule($field, $param['rules']);
            return $this->renderAjax('settings', ['model' => $model, 'param' => $param]);            
        }
    }
    
    /**
     * Создание настроек в админ панели
     * 
     * @return string|object
     */
    public function actionCreateSetting()
    {
        if ($model = Yii::$app->request->post('DynamicModel')) {
            if (Yii::$app->db->createCommand()->insert('settings', $model)->execute()) {
                TagDependency::invalidate(Yii::$app->cache, 'settings');
                echo '<div class="alert-success alert fade in">Изменения сохранены.</div>';
            }
            Yii::$app->end();
        }
        if (Yii::$app->request->isAjax) {
           $model = new DynamicModel(['name', 'value', 'label', 'icon', 'rules', 'hint']);
           $model->addRule(['name', 'value', 'label'], 'required')->addRule(['icon', 'rules', 'hint'], 'string');
           return $this->renderAjax('createSetting', ['model' => $model]); 
        }
    }
    
    /**
     * Очистка всего кеша приложения
     * 
     * @return string
     */
    public function actionClearCache()
    {
        Yii::$app->cache->flush();
        Yii::$app->session->setFlash('success', 'Очистка кеша успешно завершена.');
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}