<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Catalog;
use app\models\CatalogRegions;
use app\models\CatalogOptions;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CatalogController extends AdminController
{
    use actions\MultipleTraite;
    
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
        if (!$model = CatalogRegions::findOne(['catalog_id' => $parent_id, 'region' => $region])) {
            $model = new CatalogRegions;
            $model->catalog_id = $parent_id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
            return $this->refresh();
        }
        return $this->render('_form', ['model' => $model]);
    }
    
    /**
     * Опции каталога
     * 
     * @param integer $id ID категории каталога
     * @return string
     */
    public function actionOptions($id)
    {
        if (!$model = Catalog::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена.'));
        }
        $models = CatalogOptions::find()->where(['catalog_id' => $id])->orderBy('ISNULL(position), position ASC')->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($options = $this->multipleUpdate($model, CatalogOptions::className(), $models, 'catalog_id')) {
                foreach ($options as $key => $one) {
                    if (!empty($_POST['CatalogOptions'][$key]['change_category'])) {
                        $one->catalog_id = $_POST['CatalogOptions'][$key]['change_category'];
                        $one->save();     
                    }
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Изменения сохранены.'));
                return $this->redirect(['index']);
            }
        }
        return $this->render('options', [
            'model' => $model,
            'models' => (empty($models)) ? [new CatalogOptions] : $models
        ]);
    }
}