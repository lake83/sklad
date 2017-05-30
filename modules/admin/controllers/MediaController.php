<?php

namespace app\modules\admin\controllers;

/**
 * MediaController implements show Media library.
 */
class MediaController extends AdminController
{
    public function actionIndex()
    {
        return $this->render('index', ['configPath' => [
            'upload_dir' => '/images/uploads/source/',
            'current_path' => '../../../images/uploads/source/',
            'thumbs_base_path' => '../../../images/uploads/thumbs/'
        ]]);
    }
}