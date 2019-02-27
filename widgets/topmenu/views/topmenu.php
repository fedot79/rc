<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 30.08.2018
 * Time: 13:45
 */

use app\assets\TopMenuAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $urls array */
/* @var $current_url array */
TopMenuAsset::register($this);
?>
<div class="top-menu">
<?php
foreach ($urls as $url=>$name) {
    $tag = ($current_url==$url)?'span':'a';
    $href = ($current_url==$url)?'':'href="'.Url::toRoute([$url]).'"';
    echo '<'.$tag.' '.$href.'>'.$name.'</'.$tag.'>';
}
?>
</div>


