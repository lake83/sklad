<?php

namespace app\modules\admin\controllers;

use app\models\ImageToBanner;
use Yii;
use app\models\Banner;
use app\models\BannerSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
{
    public $layout = '@app/modules/admin/views/layouts/main';
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'toggle' => [
                'class' => \pheme\grid\actions\ToggleAction::className(),
                'modelClass' => $this->modelPath.'Banner',
                'attribute' => 'is_active'
            ]
        ];
    }

    /**
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    private function loadImages($model) {
        $path = Yii::getAlias('@webroot').'/upload/actions/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //Обработка изображений
        $images_dir = $path . $model->id;
        if (!file_exists($images_dir)) {
            mkdir($images_dir, 0777, true);
        }

        $images = UploadedFile::getInstances($model, 'images');

        foreach ($images as $key => $image) {
            $image_path = '/upload/actions/'.$model->id.'/'.time().'_'.$key.'.'. $image->extension;
            if ($image->saveAs(Yii::getAlias('@webroot') . $image_path)) {
                $banner_image = new ImageToBanner();
                $banner_image->banner_id = $model->id;
                $banner_image->image = $image_path;
                $banner_image->save();
            }
        }
    }
    public function actionCreate()
    {
        $model = new Banner();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->loadImages($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->loadImages($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDeleteImage($id)
    {
        $image = ImageToBanner::findOne($id);
        if (file_exists(Yii::getAlias('@webroot') . $image->image)) {
            unlink(Yii::getAlias('@webroot') . $image->image);
        }
        $image->delete();
        return $this->redirect(['update', 'id' => $image->banner_id]);
    }

    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
