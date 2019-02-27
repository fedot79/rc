<?php

use app\widgets\stars\StarsAssets;

StarsAssets::register($this);
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 08.08.2018
 * Time: 11:47
 */

/* @var $this \yii\web\View */
/* @var $stars  int*/
/* @var $counter  int*/

?>

<div class="stars stars-<?=$stars?>" counter="<?=$counter?>">
    <svg viewBox="0 0 444 424"><use xlink:href="#svg-star"></use></svg>
    <svg viewBox="0 0 444 424"><use xlink:href="#svg-star"></use></svg>
    <svg viewBox="0 0 444 424"><use xlink:href="#svg-star"></use></svg>
    <svg viewBox="0 0 444 424"><use xlink:href="#svg-star"></use></svg>
    <svg viewBox="0 0 444 424"><use xlink:href="#svg-star"></use></svg>
</div>
