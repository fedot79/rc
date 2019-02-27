<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 18.12.2018
 * Time: 11:00
 */

/* @var $this \yii\web\View */
/* @var $user  \app\models\UserModel*/
use app\widgets\usercard\UserCardAssets;

UserCardAssets::register($this);
$reviews_count = count($user->reviewsAbout);
$nameArray = $user->getNameArray();

 ?>
<div class="card-contacts">
    <div class="card-contacts-wrap">
        <p class="name"><strong><?=$nameArray[0]?></strong><?=($nameArray[1])?'<br>'.$nameArray[1]:''?></p>
        <img class="av-peregovory" src="<?=$user->getAvatarPic()?>">
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
            <img class="mobilka" src="/img/phone.svg">
            <?=($user->wa)?'<img class="whatsapp" src="/img/whatsapp.svg">':''?>
            <?=($user->tg)?'<img class="telega" src="/img/telegram.svg">':''?>
            <?=$user->username[0]?><?=$user->username[1]?> <?=$user->username[2]?><?=$user->username[3]?><?=$user->username[4]?> <?=$user->username[5]?><?=$user->username[6]?><?=$user->username[7]?> <?=$user->username[8]?><?=$user->username[9]?> <?=$user->username[10]?><?=$user->username[11]?>
        </div>
        <?php
        if($user->profile->public_email)
            echo
        '<div class="info-line email">'.
            '<img src="/img/mail-g.svg">'.
            $user->profile->public_email.
        '</div>';
        ?>
        <?php
        if($user->fb)
            echo
                '<div class="info-line fb">'.
                '<img src="/img/facebook.svg">'.
                $user->fb.
                '</div>';
        ?>
        <?php
        if($user->skype)
            echo
                '<div class="info-line skype">'.
                '<img src="/img/skype.svg">'.
                $user->skype.
                '</div>';
        ?>
    </div>

    <?php
//    if($review_button)
//    {
//        echo '<button class="button-common sm left-review-button" data-user="'.$user->id.'" data-pred="'.$user->getNamesArr()[5].'" data-rod="'.$user->getNamesArr()[1].'">Оставить отзыв</button>';
//    }
//    if($review_left && $review)
//    {
//        echo '<button class="button-dotted left-review-button" data-type="show" data-review="'.$review->id.'" data-user="'.$user->id.'" data-pred="'.$user->getNamesArr()[5].'" data-rod="'.$user->getNamesArr()[1].'">Отзыв оставлен</button>';
//    }
    ?>
</div>
