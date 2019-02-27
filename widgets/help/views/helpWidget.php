<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 17.07.2018
 * Time: 13:55
 */

use app\assets\HelpAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
HelpAsset::register($this);
/* @var $this \yii\web\View */
/* @var $model \app\widgets\help\HelpForm */
$form = ActiveForm::begin([
    'id' => 'help-form',
    'options' => [
        'class'=>'help hidden'
    ],

//    'fieldConfig' => [
//        'options'=>[
//            'tag'=>false
//        ]
//    ],
]);
echo '<span id="help-close"></span>';
echo '<p class="help-intro">Есть вопрос? Напишите нам.</p>';
echo $form->field($model, 'email')->textInput();
echo $form->field($model, 'text')->textarea();
?>
<div class="form-group">
<?=Html::submitButton('Отправить', ['class'=>'submit'])?>
</div>
<?php ActiveForm::end();?>