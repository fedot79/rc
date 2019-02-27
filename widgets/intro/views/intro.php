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

<div class="full-wrapper wrapper-blck hidden">
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
            <h2>СОЗДАНИЕ ЗАПРОСОВ</h2>
            <img src="/img/createobjects.svg" width="81" height="90">
            <p class="desc">Чтобы мы могли найти для вас подходящие объекты, добавьте свои потребности в развитии в сервис.</p>
            <p class="desc bullet">Для каждой отдельной <strong>потребности</strong> нужно создать отдельный запрос,
                <strong>указав параметры</strong>: метраж, стрит/ТЦ, высота потолков и т.д.</p>
            <p class="desc bullet"><strong>Описывайте ваши запросы максимально подробно.</strong> Не все параметры при создании потребности обязательны к заполнению, но чем больше данных вы укажете, тем более релевантные объекты получите.</p>
            <p class="mob">Добавьте в сервис свои запросы.</p>
            <p class="mob bullet">Если вам нужны разные объекты, создавайте разные запросы.</p>
            <p class="mob bullet">Описывайте ваши запросы максимально подробно. Больше параметров = более релевантные объекты.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-3">
            <h2>Локация</h2>
            <img src="/img/location.svg" width="89" height="89">
            <p class="desc">Создавая запрос, вы указываете место на карте и задаете радиус поиска от 20 м до 1.5 км. Сервис предложит вам все объекты, подходящие по параметрам в этой зоне.</p>
            <p class="desc bullet">Отбирая предложения, вы увидите <strong>примерную область расположения</strong> на карте. Точный адрес объекта будет скрыт.</p>
            <p class="desc bullet">Адрес откроется сразу после того, как подтвердится <strong>взаимная
                    заинтересованность</strong> в переговорах.</p>
            <p class="mob">Укажите радиус поиска и сервис предложит вам все объекты, подходящие по параметрам в этой зоне.</p>
            <p class="mob bullet">Вы увидите примерное расположение объектов на карте.</p>
            <p class="mob bullet">Точный адрес откроется при взаимной заинтересованности в переговорах.</p>
            <a class="button-common intro-next">Дальше</a>
        </div>
        <div class="intro-frame intro-4">
            <h2>Поиск партнеров</h2>
            <img src="/img/partner.svg" width="88" height="89">
            <p class="desc">Сразу после создания запроса, система предложит вам список подходящих объектов. Он будет постоянно пополняться.</p>
            <p class="desc bullet">Если через два дня или месяц в системе появится новый релевантный объект, он добавится в ваш список.</p>
            <p class="desc bullet">Вам остается только выбрать из списка <strong>лучшие объекты</strong> и подтвердить свой интерес. В этот момент потенциальному партнеру придет оповещение.</p>
            <p class="mob">Сразу после создания запроса, система предложит вам список подходящих объектов. Он будет постоянно пополняться.</p>
            <p class="mob bullet">Если через два дня или месяц в системе появится новый релевантный объект, он добавится в ваш список.</p>
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
                Посмотрите видео о том, как создать свой первый запрос, и найти для него подходящие объекты. Это займет не больше 5 минут. </p>
            <video controls="controls" id="intro_manual">
                <source src="/ret_manual.mp4" type='video/mp4'>
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
