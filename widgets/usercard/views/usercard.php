<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 14.08.2018
 * Time: 0:34
 */

use app\widgets\usercard\UserCardAssets;

/* @var $this \yii\web\View */
/* @var $user \app\models\UserModel */
/* @var $review_button bool */
/* @var $close_negotiation bool */
/* @var $review_left bool */
UserCardAssets::register($this);
$reviews_count = count($user->getReviewsAbout()->all());
$nameArray = $user->getNameArray();
?>
<div class="card-contacts">
    <p class="name"><strong><?=$nameArray[0]?></strong><?=($nameArray[1])?'<br>'.$nameArray[1]:''?></p>
    <img class="av-peregovory" src="/img/default_userpic.svg">
    <?=\app\widgets\stars\StarsWidget::widget(['stars'=>$user->rating])?>
    <div class="rate-line rate-number">
        Рейтинг<hr><span><?=$user->rating?></span>
    </div>
    <?php
    if($reviews_count>0)
    {
        ?>
        <div class="rate-line reviews-number">
            <a class="button-dotted" href="/reviews/<?= $user->id ?>">Отзывов</a>
            <hr>
            <span><?= $reviews_count ?></span>
        </div>
        <?php
    }
    ?>
    <hr>
    <div class="info-line mobile">
        <img class="mobilka" src="/img/mobile.png">
<!--        <img class="whatsapp" src="/img/whatsapp.png">-->
<!--        <img class="telega" src="/img/telegram.png">-->
        <?=$user->username[0]?><?=$user->username[1]?> <?=$user->username[2]?><?=$user->username[3]?><?=$user->username[4]?> <?=$user->username[5]?><?=$user->username[6]?><?=$user->username[7]?> <?=$user->username[8]?><?=$user->username[9]?> <?=$user->username[10]?><?=$user->username[11]?>
    </div>
    <hr>
    <div class="info-line email">
        <img src="/img/mail.png">
        <?=$user->profile->public_email?>
    </div>
    <hr>
    <div class="info-line skype">
        <img src="/img/skype-logo.png">
<!--        @retailer.ru-->
    </div>
    <?php
    if($review_button)
    {
        echo '<button class="button-common sm left-review-button" data-user="'.$user->id.'" data-pred="'.$user->getNamesArr()[5].'" data-rod="'.$user->getNamesArr()[1].'">Оставить отзыв</button>';
    }
    if($review_left && $review)
    {
        echo '<button class="button-dotted left-review-button" data-type="show" data-review="'.$review->id.'" data-user="'.$user->id.'" data-pred="'.$user->getNamesArr()[5].'" data-rod="'.$user->getNamesArr()[1].'">Отзыв оставлен</button>';
    }
    ?>
</div>
