<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 30.08.2018
 * Time: 14:57
 */

use app\assets\FooterAsset;
use app\widgets\footer\FooterWidget;
use yii\helpers\Url;

/* @var $this \yii\web\View */
FooterAsset::register($this);
?>
<div class="float-footer down" id="footer">
<!--    <div class="footer-thumb" id="footer-thumb"><img src="/img/chevron-arrow-up.svg"></div>-->
    <div class="footer-thumb" id="footer-thumb"><svg><use xlink:href="/img/chevron-arrow-up.svg#chevron-arrow-up.svg"></use></svg></div>
    <div class="footer-col col-1st">
        <a class="logo" href="/"></a>
        <a href="<?=Url::to(['/site/contacts'])?>">Контакты</a>
        <a href="<?=Url::to(['/site/faq'])?>">FAQ</a>
        <a href="<?=Url::to(['/site/tariff'])?>">Тарифы</a>
        <a class="pdf" href="<?=Url::to(['/site/user-agreement'])?>">Пользовательское соглашение</a>
        <a class="pdf" href="<?=Url::to(['/site/privacy-policy'])?>">Политика конфиденциальности</a>
        <a class="pdf" href="<?=Url::to(['/pdf/offer.pdf'])?>">Договор оферты</a>
    </div>
    <div class="footer-col col-2nd">
        <p>Другие проекты RETAILER</p>
        <a class="re" href="https://retailer.ru/?utm_source=crosslink&utm_medium=re-connect">retailer.ru - СМИ</a>
        <a class="de" href="https://detail4retail.ru/?utm_source=crosslink&utm_medium=re-connect">технологии</a>
        <a class="an" href="https://retailers.retailer.ru/?utm_source=crosslink&utm_medium=re-connect">Центр Исследований</a>
        <a class="cp" href="http://center.retailer.ru/?utm_source=crosslink&utm_medium=re-connect">Центр Переговоров</a>
    </div>
    <div class="footer-col col-3rd">
        <p>Способы оплаты</p>
        <img class="tinkoff" src="/img/tinkoff.svg">
        <img class="mc" src="/img/mastercard.svg">
        <img class="visa" src="/img/visa.svg">
        <img class="mir" src="/img/mir.svg">
    </div>
</div>
