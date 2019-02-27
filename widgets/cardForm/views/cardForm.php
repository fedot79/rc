<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 13.09.2018
 * Time: 16:43
 */

use app\assets\CreateNewAsset;
use app\assets\CreateSliderAsset;
use app\assets\GmapsAsset;
use function foo\func;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['container_class'] = 'create_new';
/* @var $this \yii\web\View */
/* @var $object \app\modules\objects\models\Objects|\app\modules\searches\models\Search */
CreateSliderAsset::register($this);
GmapsAsset::register($this);
CreateNewAsset::register($this);
BootstrapPluginAsset::register($this);
$type = $object::CLASS_STRING;

//$address = $object->address->fromAddress($object->address);


//$object->type = string;
?>
<?php $form = ActiveForm::begin(['id' => 'card-form', 'options'=>['class'=>'card-form'], 'enableClientValidation'=>false]); ?>
    <strong>Укажите параметры <?=($type=='search')?'вашей потребности':'вашего объекта'?>.</strong>
    <p class="hide-mobile">Справа — финальный вид <?=($type=='search')?'вашей потребности':'вашего объекта'?>. Так <?=($type=='search')?'её':'его'?> увидят <?=($type=='search')?'операторы торговых площадей':'ритейлеры'?>.</p>
    <!--type-array -->
    <?= $form->field($object, 'type')->radioList($object->getTypesDropdown(), ['class'=>'radio-list', 'item'=>function($index, $label, $name, $checked, $value){
        return ($index==2?'<flexdev></flexdev>':'').'<input type="radio" name="'.$name.'" id="'.($name.$index).'" value="'.$value.'" '.($checked?'checked':'').'><label for="'.($name.$index).'">'.$label.'</label>';
    }])->label(false) ?>
    <!--/type-array -->
    <div class="flex-row">
        <?= $form->field($object, 'deal_rent', ['options'=>['class'=>'checkbox'], 'template'=>'{input} {label} '])->checkbox(['class'=>'checkbox'], false)->label('', ['for'=>$type.'-deal_rent']) ?>
        <?= $form->field($object, 'price_rent', ['options'=>['class'=>'price_row'], 'template'=>'{label}{input}<span>₽/мес</span>'.'<span class="tooltip" data-toggle="tooltip" data-placement="right" title="Указывать стоимость необязательно"></span>'])->textInput(['class'=>'positive'])->label('Аренда <span class="fix">Фикс</span>') ?>
        <flexdev></flexdev>
        <?= $form->field($object, 'gain_percent_check', ['options'=>['class'=>'checkbox mini-box'], 'template'=>'{input} {label} '])->checkbox(['class'=>'checkbox'], false)->label('', ['for'=>$type.'-gain_percent_check']) ?>
        <?= $form->field($object, 'gain_percent', ['options'=>['class'=>'price_row input-short'], 'template'=>'{input}<span>% от выручки</span>'])->textInput(['class'=>'positive']) ?>


    </div>
    <div class="flex-row">
        <?= $form->field($object, 'deal_sell', ['options'=>['class'=>'checkbox'], 'template'=>'{input} {label} '])->checkbox(['class'=>'checkbox'], false)->label('', ['for'=>$type.'-deal_sell']) ?>
        <?= $form->field($object, 'price_sell', ['options'=>['class'=>'price_row'], 'template'=>'{label}{input}<span>₽</span>'.'<span class="tooltip" data-toggle="tooltip" data-placement="right" title="Указывать стоимость необязательно"></span>'])->textInput(['class'=>'positive'])->label($object->getClass()=='Search'?'Покупка':'Продажа') ?>
    </div>
    <p class="loc-info"><?=($type=='search')?'Откройте карту и укажите локацию поиска любым способом<br><br>•  Введите адрес в строку поиска<br>
•  Просто кликните на нужное место на карте<br>
•  Или укажите координаты в строке поиска':'Откройте карту и укажите адрес объекта любым способом
<br><br>
•  Введите адрес в строку поиска<br>
•  Просто кликните на нужное место на карте<br>
•  Или укажите координаты в строке поиска'?></p>
    <!-- map -->
    <?= $form->field($address, 'address_string')->hiddenInput(['id'=>'address-string'])->label(false) ?>
    <?= $form->field($address, 'city')->hiddenInput(['id'=>'address-city'])->label(false) ?>
    <?= $form->field($address, 'region')->hiddenInput(['id'=>'address-region'])->label(false) ?>
    <?= $form->field($address, 'street')->hiddenInput(['id'=>'address-street'])->label(false) ?>
    <?= $form->field($address, 'house')->hiddenInput(['id'=>'address-house'])->label(false) ?>
    <?= $form->field($address, 'lat')->hiddenInput(['id'=>'address-lat'])->label(false) ?>
    <?= $form->field($address, 'lng')->hiddenInput(['id'=>'address-lng'])->label(false) ?>
    <?php
    if($object::CLASS_STRING=='search')
        echo $form->field($object, 'distance')->hiddenInput()->label(false);
    ?>
    <!-- /map -->
    <button class="button-common button-black button-wide" id="openMap" type="button">Выбрать локацию</button>

    <div class="flex-row attributes">
        <?php
        if($object::CLASS_STRING=='object')
            echo $form->field($object, $object->getSquareProp(), ['options'=>['class'=>'flex-square'], 'template'=>'{label}{input}<span class="meter">м²</span>'])->textInput(['class'=>'with-val intonly']);
        else
            echo $form->field($object, $object->getSquareProp(), ['options'=>['class'=>'flex-square'], 'template'=>'{label}<span class="tooltip" data-toggle="tooltip" data-placement="right" title="Для выбора диапазона площади укажите ее через &quot;-&quot;: 150-250"></span><span class="optional">Можно диапазон</span>{input}<span class="meter">м²</span>'])->textInput(['class'=>'with-val dashed']);
        ?>
        <?= $form->field($object, 'floor', ['options'=>['class'=>'flex-square'], 'template'=>'{label}<span class="tooltip" data-toggle="tooltip" data-placement="right" title="Для выбора цокольного этажа введите -1"></span><span class="optional">Необязательно</span>{input}'])->textInput(['class'=>'intonly']) ?>
        <flexdev></flexdev>
        <?= $form->field($object, 'column', ['options'=>['class'=>'flex-square'], 'template'=>'{label}<span class="optional">Необязательно</span>{input}<span class="meter">м</span>'])->textInput(['class'=>'with-val floatonly']) ?>
        <?= $form->field($object, 'ceil', ['options'=>['class'=>'flex-square'], 'template'=>'{label}<span class="optional">Необязательно</span>{input}<span class="meter">м</span>'])->textInput(['class'=>'with-val floatonly']) ?>
    </div>
    <div class="flex-col trist-container">
        <div class="flex-row trist">
            <label>Зона разгрузки</label>
                    <?=$form->field($object, 'shipping_zone')->radioList([-1=>'',0=>'',1=>''], ['tag'=>'span', 'class'=>'tristate tristate-switcher', 'item'=>function($index, $label, $name, $checked, $value){
                        if($index<2)
                            return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?'checked':'').'>';
                        else
                            return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?'checked':'').'><i></i>';
                    }])->label(false)?>
        </div>
        <div class="flex-row trist">
            <label>Отдельный вход</label>
                <?=$form->field($object, 'entrance')->radioList([-1=>'',0=>'',1=>''], ['tag'=>'span', 'class'=>'tristate tristate-switcher', 'item'=>function($index, $label, $name, $checked, $value){
                if($index<2)
                    return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?'checked':'').'>';
                else
                    return '<input type="radio" name="'.$name.'" value="'.$value.'" '.($checked?'checked':'').'><i></i>';
            }])->label(false)?>
        </div>
        <div class="helper">
            Нажимайте на переключатели, чтобы указать<?=($type=='search')?', нужна ли вам зона разгрузки и отдельный вход. <br> “&#x2713;” - необходимо / “-” - неважно / “&#x2715;” - не нужно.':' наличие зоны разгрузки и отдельного входа. <br> “&#x2713;” - есть / “-” - не указано
     / “&#x2715;” - нет.'?>
        </div>
    </div>
    <button class="solid-button" id="proceed" type="button">Опубликовать <?=($type=='search')?'потребность':'объект'?></button>
    <?php ActiveForm::end(); ?>
