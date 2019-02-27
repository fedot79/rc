<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 02.10.2018
 * Time: 16:15
 */

use app\assets\IntroAsset;


/* @var $this \yii\web\View */

IntroAsset::register($this);
?>

<div class="full-wrapper hidden">
    <div class="intro">
        <a class="intro-click prev hidden"></a>
        <div class="intro-frame intro-1 active">
<!--            <img src="/img/logo_main.svg">-->
            <img src="/img/logon.svg">
            <h2>Добро пожаловать в REconnect</h2>
            <a class="button-common intro-next">Расскажите мне о сервисе</a>
            <a class="intro-close">Спасибо, помощь не нужна</a>
        </div>
        <div class="intro-frame intro-2">
            <h2>Создание объектов</h2>
            <img src="/img/createobjects.svg" width="81" height="90">
            <p class="desc">Чтобы мы могли найти для вас подходящие запросы от ритейлеров, добавьте свои объекты в сервис.</p>
            <p class="desc bullet"><strong>Для каждой торговой площади</strong> нужно заполнить <strong>отдельную форму объекта</strong>, указав его параметры: метраж, локацию, высоту потолков и т.д.</p>
            <p class="desc bullet"><strong>Описывайте ваши объекты максимально подробно.</strong> Не все параметры при создании объекта обязательны к заполнению, но чем больше данных вы укажете, тем более релевантные запросы от ритейла получите.</p>
            <p class="mob">Добавьте в сервис свои объекты.</p>
            <p class="mob bullet">Для каждой торговой площади нужно заполнить отдельную форму объекта.</p>
            <p class="mob bullet">Описывайте ваши объекты максимально подробно. Больше параметров = более релевантные контакты.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-3">
            <h2>Локация</h2>
            <img src="/img/location.svg" width="89" height="89">
            <p class="desc">Поставьте точку на карте, и ваш объект будет показан всем ритейлерам, в радиус поиска которых он попадает.</p>
            <p class="desc bullet">Мы не будем раскрывать точный адрес объекта ритейлерам на этапе просмотра предложений. Они увидят только
                <strong>примерную область расположения</strong> на карте</p>
            <p class="desc bullet">Адрес откроется вашему потенциальному партнеру только после того, как вы подтвердите
                <strong>взаимную заинтересованность</strong> в переговорах. </p>
            <p class="mob">Поставьте точку на карте, и объект будет показан всем ритейлерам, в радиус поиска которых он попадает.</p>
            <p class="mob bullet">Ритейлеры увидят примерное расположение объекта.</p>
            <p class="mob bullet">Точный адрес откроется им при взаимной заинтересованности в переговорах.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-4">
            <h2>Поиск партнеров</h2>
            <img src="/img/partner.svg" width="88" height="89">
            <p class="desc">Сразу после создания объекта, система предложит вам список запросов от ритейлеров, которым он подходит. Он будет постоянно пополняться.</p>
            <p class="desc bullet">Если через два дня или месяц в системе появится новый подходящий запрос, он добавится в ваш список.</p>
            <p class="desc bullet">Вам остается только выбрать из списка <strong>лучшие запросы и подтвердить свой интерес</strong>. В этот момент потенциальному партнеру придет оповещение.</p>
            <p class="mob">Сразу после создания объекта, система предложит вам список запросов от ритейлеров, которым он подходит. Он будет постоянно пополняться.</p>
            <p class="mob bullet">Если через два дня или месяц в системе появится новый подходящий запрос, он добавится в ваш список.</p>
            <p class="mob bullet">Вам остается только выбрать из списка лучшие.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-5">
            <h2>Как проходят переговоры</h2>
            <img src="/img/nego.svg" width="88" height="89">
            <p class="desc">Возможность начать переговоры открывается только тогда, когда обе стороны подтверждают интерес. В этот момент открываются контакты (как ваши, так и потенциального партнера) и локация объекта.</p>
            <p class="desc bullet"><strong>Стоимость переговоров зависит от размера объекта, по поводу которого они
                    проводятся.</strong> Чем выше метраж — тем выше стоимость.Таблицу тарифов можно посмотреть <a class="def-link" href="<?=\yii\helpers\Url::to(['/tariff/default/plans'])?>">здесь</a>.</p>
            <p class="mob">Возможность начать переговоры открывается только при взаимном интересе.</p>
            <p class="mob bullet">Стоимость переговоров зависит от размера объекта, по поводу которого они проводятся. Таблицу тарифов можно посмотреть <a class="def-link" href="<?=\yii\helpers\Url::to(['/tariff/default/plans'])?>">здесь</a>.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-6">
            <h2>Рейтинг</h2>
            <img src="/img/rating.svg" width="78" height="78">
            <p class="desc">В RE-CONNECT есть система взаимной оценки, которая поможет вам определить уровень доверия к потенциальному партнеру. Вы можете ориентироваться на рейтинг, выбирая предложения из списка.</p>
            <p class="desc">Вы можете поставить проведенным переговорам от 1 до 5 звезд и оставить отзыв.</p>
            <p class="desc bullet"><strong>Ваш рейтинг будет сформирован на основании оценок от других
                    пользователей.</strong>
                Однако начальный можно получить сразу после создания первого объекта.</p>
            <p class="mob">Вы можете поставить проведенным переговорам от 1 до 5 звезд и оставить отзыв.</p>
            <p class="mob bullet">Ваш рейтинг будет сформирован на основании оценок от других пользователей. Начальный можно получить после регистрации.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-7">
            <h2>Мануал</h2>
            <p><strong>Что-то осталось непонятным?</strong><br>
                Посмотрите видео о том, как создать свой первый объект, и найти для него подходящие запросы от ритейлеров. Это займет не больше 5 минут.</p>
            <video controls="controls"  id="intro_manual">
                <source src="/dev_manual.mp4" type='video/mp4'>
            </video>
            <a class="button-common intro-done">Начать работу с сервисом</a>
        </div>
        <span class="intro-close-top"></span>
        <a class="intro-click next"></a>
        <div class="intro-pager hidden">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
</div>
