<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 21.09.2018
 * Time: 12:23
 */

use app\models\FeedUploadForm;
use app\widgets\feedUpload\FeedUploadAssets;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
FeedUploadAssets::register($this);
$model = new FeedUploadForm();
?>
<a class="button-dotted" href="#" id="feed_upload">Загрузить XLS</a>
<div class="modal" id="feed_modal">
    <?php
        $form = ActiveForm::begin(['id'=>'feed_form', 'action' => '/feeds/upload', 'options'=>['enctype' => 'multipart/form-data']]);
        echo $form->field($model, 'file', ['template'=>'{input} {label}'])->fileInput(['class'=>'feed_upload_input'])->label('Выберите файл', ['for'=>'feeduploadform-file']);
    ?>
    <input type="submit" class="button-common button-sm" value="Загрузить">
    <?php ActiveForm::end()?>
</div>

