<?php
namespace app\components;

use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;
use yii\bootstrap\Modal;
use xvs32x\tinymce\TinymceAsset;
use kartik\sortinput\SortableInput;

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
        $view = $this->view;
        $view->registerJs("
            $('#modal_filemanager .modal-dialog').css('width', document.body.clientWidth - 60 + 'px');
            $('#modal_filemanager .modal-body').css('height', document.body.clientHeight - 120 + 'px');
        ");
        $view->registerJs("
            function addImage(src, id)
            {
                $('#result-sortable').append('<li data-key=\"' + src + '\" role=\"option\" aria-grabbed=\"false\" draggable=\"true\"><div><img src=\"/images/uploads/thumbs/' + src + '\"/><a href=\"#\" onclick=\"js:delImage(\'' + src + '\', \'' + id + '\');$(this).parents(\'li\').remove();return false;\">&#10060;</a></div></li>');
                $('#result').val($('#result').val() + ',' + src);
                $('#' + id).val($('#result').val().replace(',,', ','));
            }
            function delImage(src, id)
            {
                $('#result').val($('#result').val().replace(src, '').replace(',,', ','));
                $('#' + id).val($('#result').val());
            }
        ", $view::POS_HEAD);
        $view->registerCss(".sortable{border:0}");
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
            $id = Html::getInputId($this->model, $this->attribute);
            if ($this->preview) {
                $items = [];
                if (is_array($this->model->{$this->attribute})) {
                    foreach ($this->model->{$this->attribute} as $img) {
                        $items[$img] = ['content' => '<div>' .
                            Html::img('/images/uploads/thumbs/'. $img) .
                            '<a href="#" onclick="js:delImage(\'' . $img . '\', \'' . $id . '\');$(this).parents(\'li\').remove();return false;">&#10060;</a>' .
                        '</div>'];
                    }
                }
                echo SortableInput::widget([
                    'sortableOptions' => ['type' => 'grid', 'pluginEvents' => ['sortupdate' => 'function() {$("#' . $id . '").val($("#result").val());}']],
                    'name' => 'sort_list',
                    'id' => 'result',
                    'value' => is_array($this->model->{$this->attribute}) ? implode(',', $this->model->{$this->attribute}) : '',
                    'items' => $items
                ]);
            }
            if (!ArrayHelper::getValue($this->options, 'id')) {
                $this->options['id'] = $id;
            }
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options + ['onchange' => 'js:addImage(this.value, \'' . $id . '\')',
                 'value' => is_array($this->model->{$this->attribute}) ? implode(',', $this->model->{$this->attribute}) : '']);
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
        return Yii::$app->request->hostInfo . TinymceAsset::register($this->view)->baseUrl . '/filemanager/dialog.php?type=2&field_id=' .
            $this->options['id'] . '&relative_url=1&descending=false&lang=ru&akey=' . urlencode(serialize($this->configPath));
    }
}
?>