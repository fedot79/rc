<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 26.08.2018
 * Time: 17:59
 */

use app\assets\GmapsAsset;
use app\components\Color;
use app\widgets\card\CardAsset;
use app\widgets\card\CardHelper;
use app\widgets\gmap\GmapHelper;
use app\widgets\stars\StarsWidget;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $color string */
/* @var $id string */
/* @var $logo string */
/* @var $branded bool */
/* @var $edit bool */
/* @var $contact_price bool */
/* @var $contact_price_price int */
/* @var $new_edit bool */
/* @var $seen bool */
/* @var $type string */
/* @var $button string */
/* @var $no_button string */
/* @var $object \app\modules\objects\models\Objects|\app\modules\searches\models\Search */


$map_container = '';
if($object->address)
{
    GmapsAsset::register($this);
    $lat = ($edit||$new_edit)?$object->address->lat:$object->address->lat+0.0015;
    $lng = ($edit||$new_edit)?$object->address->lng:$object->address->lng-0.0013;
    $radius = 400;
    $this->registerJs('window.gmapstyle  = '.GmapHelper::$style_json.'; ', $this::POS_END);
    $js = <<<JS
$(document).ready(function(){
    $('#$id').cardMap();
});
JS;
    if(!$edit && !$new_edit)
        $this->registerJs($js);

    $map_container = '<div class="mobile-close-map"></div>'.
        '<div class="map-container" data-lat="'.$lat.'" data-lng="'.$lng.'" data-radius="'.$radius.'"></div>'.
        '<div class="map-control zoom m-shadow"><svg><use xlink:href="/img/map-zoom.svg#map-zoom.svg"></use></svg>открыть карту</div>';
    $map_container.=($new_edit)?CardHelper::getMapInfo($object):'';
    $map_container.=
        '<div class="map-control zoom-plus m-shadow"><svg><use xlink:href="/img/map-zoom-plus.svg#map-zoom-plus.svg"></use></svg></div>'.
        '<div class="map-control zoom-minus m-shadow"><svg><use xlink:href="/img/map-zoom-minus.svg#map-zoom-minus.svg"></use></svg></div>';
    $map_container.=($new_edit)?'<div class="map-error m-shadow hidden"><span class="close"></span><p class="red">Ошибка при добавлении адреса. Это может происходить по одной из следующих причин</p>
                <p class="red">•  Адрес невозможно найти на карте<br>
                    •  Адрес введен не полностью</p>
                <p>Что делать?</p>
                <p>•  Проверьте, правильно ли введен адрес<br>
                    •  Проверьте формат ввода: город, улица, дом<br>
                    •  Если адрес верный, попробуйте добавить координаты точки в формате “59.983957, 30.234495”; для этого
                    найдите свой объект в google maps или на Яндекс Картах, поставьте на него точку и скопируйте
                    координаты точки в строку поиска</p>
            </div>':'';


}
else
{
    $map_container = '<div class="city"><img src="/img/baloon.svg"><span>'.$object->searchGenCity->city->name.'<span></div>';
}
CardAsset::register($this);





if($branded) //render needed brand <style> block
    echo CardHelper::getBrandStyle($color, $id);
else
    echo '<style id="style-for-'.$id.'"></style>';


if($object->getClass()=='Search')
{
    if($object->distance>0)
        $radius = $object->distance;
}


$alt_name = $name ?'title="'.$name.'"':'';

$style = GmapHelper::$style_json;




//else
$this->registerJs('window.gmapstyle  = '.$style.'; ', $this::POS_END);
if($color==null)
    $branded = false;

if($branded)
    $classes[] = 'branded';

if($seen)
    $classes[] = 'seen';
?>
<div class="<?=implode(' ', $classes)?>" id="<?=$id?>" data-id="<?=$object->id?>"<?=($branded)?'data-color="'.$color.'"':''?> data-type="<?=mb_strtolower($object->getClass())?>">
    <div class="card-spine">
        <?=CardHelper::getSpine($object)?>
    </div>
    <div class="card-self">
        <div class="card-header">
            <div class="card-type<?=($logo)?' with-logo':''?>">
                <?=($edit)?CardHelper::getTypeForm($object, $logo, $alt_name):CardHelper::getType($object, $logo, $alt_name)?>
            </div>
            <div class="card-master">
                <p><?=$object->master->getNameArray()[0]?></p>
                <?= StarsWidget::widget(['stars' => $object->master->rating])?>
            </div>
        </div>
        <div class="card-deal">
            <?php
            echo ($edit)?CardHelper::getDealBlockForm($object):(($new_edit)?CardHelper::getDealBlockNew($object):CardHelper::getDealBlock($object));
            ?>
        </div>
        <div class="card-map">
            <?=$map_container?>

            <?=($new_edit)?'<div class="map-address'.(($object->address->getAddressString()!=='')?'':' hidden').'">'.$object->address->getAddressString().'</div>':''?>
            <?=($edit || $new_edit)?CardHelper::getMapForm($object):''?>
        </div>
        <dl class="card-info">
            <?php
            echo ($edit)?CardHelper::getInfoForm($object):CardHelper::getInfo($object);
            ?>
        </dl>
        <div class="card-actions <?=($no_buttons)?'no-buttons':''?><?=($contact_price)?' price':''?>">
            <?php
            if(!$new_edit)
            {
                if($contact_price)
                {
                    echo '<span id="contact_price">0</span>';
                }
                else
                {
                    if($type && $type=='selection' && $button)
                    {
                        ?>
                        <span class="button-alter"><?=$no_button?></span>
                        <?=$button?>
                        <?php
                    }
                    else
                    {
                        if($contact_price_price)
                            $price = $contact_price_price;
                        else
//                            $price = $object->getContactPrice();
                            //TODO dirty hack, make sure that all calls to $object->getContactPrice() have another object in it
                            $price = 0;

                        ?>
                        <span class="button-alter"><?=$no_button?></span>
                        <span class="button-common button-sm"><strong>интересно</strong> | <?=$price?></span>
                        <?php
                    }
                }
            }
            else
            {
                echo '<span id="contact_price"></span>';
            }
            ?>
        </div>
    </div>
</div>
