<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 10.07.2018
 * Time: 20:54
 */

use app\assets\LoginAsset;
use yii\helpers\Html;


LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style id="svgstyle">
        object, svg, input{
            display: none;
        }
    </style>
</head>
<body class="login">
<?php $this->beginBody() ?>
<div class="wrapper">
    <div class="content">
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter49149883 = new Ya.Metrika2({ id:49149883, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/49149883" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<!-- Facebook Pixel Code -->
<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script', 'https://connect.facebook.net/en_US/fbevents.js');fbq('init', '597902600595718');fbq('track', 'PageView');</script>
<noscript><img height="1" width="1" src="https://www.facebook.com/tr?id=597902600595718&ev=PageView&noscript=1"/></noscript>
<!-- End Facebook Pixel Code -->
</body>
</html>
<?php $this->endPage() ?>
