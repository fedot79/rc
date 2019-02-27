<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 06.02.2019
 * Time: 17:52
 */

/* @var $this \yii\web\View */
/* @var $widget_id int */
/* @var $buttons string */
/* @var $show_contact bool */
/* @var $object \app\modules\objects\models\Objects|\app\modules\searches\models\Search */

use app\assets\GmapsAsset;
use app\widgets\card\CardAsset;
use app\widgets\card\CardHelper;
use app\widgets\gmap\GmapHelper;
use app\widgets\stars\StarsWidget;
use app\widgets\usercard\UserCardWidget;

CardAsset::register($this);

$map_block = '';

if($object->address)
{
    GmapsAsset::register($this);
    if($show_contact)
    {
        $lat = (float)$object->address->lat;
        $lng = (float)$object->address->lng;
        $radius = null;
    }
    else
    {
        $lat = $object->address->lat+0.0015;
        $lng = $object->address->lng-0.0013;
        $radius = 400;
    }

    $this->registerJs('window.gmapstyle  = '.GmapHelper::$style_json.'; ', $this::POS_END);
    if($object::CLASS_STRING=='search')
    {
        if($object->distance>0)
            $radius = $object->distance;
    }
    $map_block = '<div class="mobile-close-map"></div>'.
        '<div class="map-container" data-lat="'.$lat.'" data-lng="'.$lng.'" data-radius="'.$radius.'"></div>'.
        '<div class="map-control zoom m-shadow"><svg><use xlink:href="/img/map-zoom.svg#map-zoom.svg"></use></svg>открыть карту</div>'.
        '<div class="map-control zoom-plus m-shadow"><svg><use xlink:href="/img/map-zoom-plus.svg#map-zoom-plus.svg"></use></svg></div>'.
        '<div class="map-control zoom-minus m-shadow"><svg><use xlink:href="/img/map-zoom-minus.svg#map-zoom-minus.svg"></use></svg></div>';

    //TODO show coords
}
if(property_exists($object, 'searchGenCity'))
{
    $map_block = '<div class="city"><img src="/img/baloon.svg"><span>'.$object->searchGenCity->city->name.'<span></div>';
}




?>
<div class="card-new"
     id="<?=$widget_id?>"
     data-id="<?=$object->id?>"
     data-type="<?=$object::CLASS_STRING?>"
>
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
            <?=$map_block?>
        </div>
        <dl class="card-info">
            <?php
            echo CardHelper::getInfo($object);
            ?>
        </dl>
        <div class="card-actions">
            <?=$buttons?>
        </div><?=YII_ENV_DEV?$object->id:''?>
    </div>
    <?php
    if($show_contact)
        echo UserCardWidget::widget(['user'=>$object->master, 'new_design' => true]);
    ?>
</div>
