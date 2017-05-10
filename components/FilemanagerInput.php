<?php
namespace app\components;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use yii\bootstrap\Modal;
use xvs32x\tinymce\TinymceAsset;

class FilemanagerInput extends InputWidget
{
    public $preview = true;
    
    public $configPath = [
        'upload_dir' => '/images/uploads/source/',
        'current_path' => '../../../images/uploads/source/',
        'thumbs_base_path' => '../../../images/uploads/thumbs/'
    ];
    
    public function init()
    {
        parent::init();
        $this->view->registerJs("
            $('.modal-dialog').css('width', document.body.clientWidth - 60 + 'px');
            $('.modal-body').css('height', document.body.clientHeight - 120 + 'px');
        ");
        Modal::begin([
            'header' => '<b style="font-size: 20px">Файловый менеджер</b>',
            'id' => 'modal_filemanager',
            'toggleButton' => ['label' => 'Выбрать', 'class' => 'btn btn-default']
        ]);
        echo '<iframe src="' . $this->setUrl() . '" frameborder="0" width="100%" height="100%"></iframe>';

        Modal::end();
    }

    public function run()
    {
        if ($this->hasModel()) {
            if ($this->preview) {
                echo '<div class="form-group">
                          <div id="preview" class="control-label col-sm-3">' . Html::img('/images/uploads/thumbs/'. $this->model->{$this->attribute}) . '</div>
                      </div>';
            }
            if (!ArrayHelper::getValue($this->options, 'id')) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            }
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options + ['onchange' => 'js:$("#preview img").attr("src", "/images/uploads/thumbs/" + this.value)']);
        } else {
            if (!ArrayHelper::getValue($this->options, 'id')) {
                $this->options['id'] = Html::getAttributeName($this->name . rand(1, 9999));
            }
            echo Html::hiddenField($this->name, $this->value, $this->options);
        }
    }
    
    /**
     * @return string
     */
    public function setUrl()
    {
        return Yii::$app->request->hostInfo . TinymceAsset::register($this->view)->baseUrl . '/filemanager/dialog.php?type=1&field_id=' .
            $this->options['id'] . '&relative_url=1&descending=false&lang=ru&akey=' . urlencode(serialize($this->configPath));
    }
}
?>