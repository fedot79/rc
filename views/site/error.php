<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <img src="/img/404t.svg">

    <?php
    if(nl2br(Html::encode($message))!=='')
    {
        echo '<h1>'.nl2br(Html::encode($message)).'</h1>';
    }
    else
    {
        echo '<h1>Что-то пошло не так</h1>';
    }
    ?>
    <a href="javascript:history.back(1)">Вернуться назад</a>
</div>
