<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 23.08.2018
 * Time: 14:45
 */

use app\assets\MenuAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $user \app\models\UserModel */
MenuAsset::register($this);
?>
<span class="mobile-menu" id="mobile-menu"></span>
<nav class="side-nav menu">
    <a href="/" class="logo">
<!--        <svg class="min">-->
<!--            <use xlink:href="/img/logo-short.svg"></use>-->
<!--        </svg>-->
        <img class="min" src="/img/logo-short.svg">
        <img class="full" src="/img/logon.svg">
    </a>
    <div class="user">
        <?php
        $img = '<img src="/img/default_userpic.svg">';
        if($user)
        {
            $img = '<img src="'.$user->getAvatarPic().'">';
            if(strpos($img, 'uploads')==false)
                $img = '<a href="'.Url::to(['/site/settings']).'"><svg><use xlink:href="/img/add_avatar.svg#add_avatar.svg"></use></svg></a>';
        }

        ?>
        <?=$img?>
        <div class="full"><?=$user?$user->getNameString():''?></div>
    </div>
    <?php
    foreach ($items as $item) {
        if($item['href'])
            echo '<a href="'.$item['href'].'" class="left'.(!empty($item['class'])?' '.$item['class'].'':'').'"><svg><use xlink:href="'.$item['svg'].'"></use></svg><div class="full">'.$item['txt'].'</div></a>';
        else
            echo '<span class="left'.(!empty($item['class'])?' '.$item['class'].'':'').'"><svg><use xlink:href="'.$item['svg'].'"></use></svg><div class="full">'.$item['txt'].'</div></span>';

        if(!empty($item['after']))
            echo $item['after'];
    }
    ?>
</nav>
