<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\App2Asset;
use app\models\UserModel;
use app\modules\negotiation\models\Negotiations;
use app\widgets\Alert;
use app\widgets\footer\FooterWidget;
use app\widgets\help\HelpWidget;
use app\widgets\topmenu\TopMenuWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode(strip_tags($this->title)) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?=\app\widgets\menu\MenuWidget::widget()?>
    <div class="content-container">
        <nav class="top-nav">
            <?php
            if(!empty($this->params['top_menu']))
            {
                echo TopMenuWidget::widget();
            }
            else
            {
                if(!empty($this->params['topline']))
                    echo $this->params['topline'];
                else
                    echo '<h1>'.($this->title).'</h1>';
            }
            ?>
            <button class="help-me" id="help-me">ПОМОЩЬ</button>
            <?php
            if(Yii::$app->user->isGuest)
                echo '<a class="login-a" href="/login">Войти</a>';
            else
                echo '<a class="login-a" href="/logout">Выйти</a>';
            ?>
        </nav>
        <hr class="all-pages">
        <div id="container" class="<?=(!empty($this->params['container_class']))?$this->params['container_class']:''?>">
            <?= $content ?>
        </div>
        <?=HelpWidget::widget();?>
    </div>
</div>
<?=FooterWidget::widget();?>
<?php $this->endBody() ?>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter49149883 = new Ya.Metrika2({ id:49149883, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/49149883" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<!-- Facebook Pixel Code -->
<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script', 'https://connect.facebook.net/en_US/fbevents.js');fbq('init', '597902600595718');fbq('track', 'PageView');</script>
<noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=597902600595718&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->
</body>
</html>
<?php $this->endPage() ?>

