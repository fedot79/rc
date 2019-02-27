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
/* @var $widget_id string */
/* @var $widget_counter int */
/* @var $actions string */
/* @var $seen bool */
/* @var $object \app\modules\objects\models\Objects|\app\modules\searches\models\Search */

if($object->address)
{
    GmapsAsset::register($this);
    $lat = $object->address->lat+0.0015;
    $lng = $object->address->lng-0.0013;
    $radius = 400;
    $this->registerJs('window.gmapstyle  = '.GmapHelper::$style_json.'; ', $this::POS_END);
}
CardAsset::register($this);
//Yii::info('render widget '.$widget_id);



if($object->getClass()=='Search')
{
    if($object->distance>0)
        $radius = $object->distance;
}

//$js = <<<JS
//$(document).ready(function(){
//    $('#$widget_id').cardMap();
//});
//JS;
//
//$this->registerJs($js);


?>
<div class="card-new<?=($seen)?' seen':''?>"
     id="<?=$widget_id?>"
     data-id="<?=$object->id?>"
     data-type="<?=mb_strtolower($object->getClass())?>"
     data-widget="<?=$widget_counter?>">
    <div class="card-spine">
        <?=CardHelper::getSpine($object)?>
    </div>
    <div class="card-self">
        <div class="card-header">
            <div class="card-type">
                <?=CardHelper::getType($object, false, false)?>
            </div>
            <div class="card-master">
                <p><?=$object->master->getNameArray()[0]?></p>
                <?= StarsWidget::widget(['stars' => $object->master->rating])?>
            </div>
        </div>
        <div class="card-deal">
            <?php
            echo CardHelper::getDealBlock($object);
            ?>
        </div>
        <div class="card-map">
            <?php
            if($object->address)
            {
                echo '<div class="mobile-close-map"></div>'.
                '<div class="map-container" data-lat="'.$lat.'" data-lng="'.$lng.'" data-radius="'.$radius.'"></div>'.
                '<div class="map-control zoom m-shadow"><svg><use xlink:href="/img/map-zoom.svg#map-zoom.svg"></use></svg>открыть карту</div>'.
                '<div class="map-control zoom-plus m-shadow"><svg><use xlink:href="/img/map-zoom-plus.svg#map-zoom-plus.svg"></use></svg></div>'.
                '<div class="map-control zoom-minus m-shadow"><svg><use xlink:href="/img/map-zoom-minus.svg#map-zoom-minus.svg"></use></svg></div>';
            }
            else
                echo '<div class="city"><img src="/img/baloon.svg"><span>'.$object->searchGenCity->city->name.'<span></div>';
            ?>

        </div>
        <dl class="card-info">
            <?php
            echo CardHelper::getInfo($object);
            ?>
        </dl>
        <div class="card-actions">
            <?php
                echo $actions;
            ?>
        </div><?=YII_ENV_DEV?$object->id:''?>
    </div>
</div>
