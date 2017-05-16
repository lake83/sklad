<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Catalog;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CatalogController extends AdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => $this->actionsPath.'Index',
                'search' => $this->modelPath.'CatalogSearch'
            ],
            'update' => [
                'class' => $this->actionsPath.'Update',
                'model' => $this->modelPath.'Catalog',
                'redirect' => Yii::$app->request->referrer,
                'scenario' => 'main'
            ],
            'delete' => [
                'class' => $this->actionsPath.'Delete',
                'model' => $this->modelPath.'Catalog'
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => $this->modelPath.'Catalog',
                'attribute' => 'is_active'
            ]
        ];
    }
    
    /**
     * Создание первого элемента каталога если его нет.
     * 
     * @return string
     */
    public function actionFirst()
    {
        if (!Catalog::find()->where(['slug' => 'catalog'])->exists()) {
            $countries = new Catalog(['name' => 'Каталог', 'slug' => 'catalog']);
            if ($countries->makeRoot()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Запись добавлена.'));
                return $this->redirect(['index']);
            }
        }
    }
    
    /**
     * Добавить элемент после указаного.
     * 
     * @param integer $id ID элемента после которого добавится новый
     * @return string
     */
    public function actionAdd($id)
    {
        $model = new Catalog;
        
        if ($model->load(Yii::$app->request->post())) {
            if (($catalog = Catalog::findOne($id)) && $model->appendTo($catalog)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Запись добавлена.'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }
    
    /**
     * Перемещение элементов каталога.
     * 
     * @return string
     */
    public function actionMove($id, $target, $position)
    {
        $model = Catalog::findOne($id);

        $t = Catalog::findOne($target);

        switch ($position) {
            case 0:
                $model->insertBefore($t);
                break;

            case 1:
                $model->appendTo($t);
                break;
            
            case 2:
                $model->insertAfter($t);
                break;
        }
    }
    
    /**
     * Создание и редактирование локальных версий для регионов
     * 
     * @param integer $parent_id ID родительской модели
     * @param string $region субдомен региона
     * @return string
     */
    public function actionLocalization($parent_id, $region)
    {
        if (!$model = Catalog::findOne(['parent_id' => $parent_id, 'region' => $region])) {
            $parent = Catalog::find()->select('lft,rgt,depth,slug')->where(['id' => $parent_id])->one();
            $model = new Catalog;
            $model->lft = $parent->lft;
            $model->rgt = $parent->rgt;
            $model->depth = $parent->depth;
            $model->slug = $parent->slug;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->refresh();
        }
        return $this->render('_form', ['model' => $model]);
    }       
}