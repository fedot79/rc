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

