<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 14.01.2019
 * Time: 14:10
 */

use app\widgets\GooddayWidget;
use yii\helpers\Url;
$this->title = 'REconnect — торговая недвижимость находится здесь';
?>
<header>
    <div class="circle-bg"></div>
    <div class="wrap">
        <nav>
            <svg class="logo">
                <use xlink:href="img/icons/logo.svg#logo"></use>
            </svg>
            <div class="main-menu">
                <ul>
                    <li><a href="#why">Зачем это нам</a></li>
                    <li><a href="#howitworks">Как это работает</a></li>
                    <li><a href="#what">Зачем это вам</a></li>
                </ul>
            </div>
            <a href="<?= Url::to(['/user/security/' . (Yii::$app->user->isGuest ? 'login' : 'logout')]) ?>"
               class="login"><?= (Yii::$app->user->isGuest ? 'Войти' : 'Выйти') ?></a>
        </nav>
        <div class="header">
            <h1>Поиск торговых площадей еще никогда не был таким <br class="onmobile"><span class="typed"> </span></h1>
            <div class="header-controls">
                <?php
                if (Yii::$app->user->isGuest || Yii::$app->user->can('buyerRole'))
                    echo '<a href="' . Url::to(['/searches/default/new']) . '" class="btn">Я ищу площадь</a>';
                if (Yii::$app->user->isGuest || Yii::$app->user->can('sellerRole'))
                    echo '<a href="' . Url::to(['/objects/default/new']) . '" class="btn">У меня есть площадь</a>';
                ?>
            </div>
        </div>
        <div class="next"><a href="#why" class="next__icons go_to">
                <svg class="mouse">
                    <use xlink:href="img/icons/mouse.svg#mouse"></use>
                </svg>
                <svg class="download">
                    <use xlink:href="img/icons/download.svg#download"></use>
                </svg>
            </a><a href="#why" class="next__text go_to">Листайте вниз, чтобы узнать больше</a></div>
    </div>
</header>
<section id="why" class="problems">
    <div class="circle-bg problems__circle-bg"></div>
    <div class="circle-bg problems__mincircle-bg"></div>
    <div class="wrap">
        <h2 class="title">Инструмент, который меняет все<br><span>и предлагает решения для актуальных проблем рынка торговой недвижимости</span>
        </h2>
        <div class="problems__slider">
            <div class="problems__item--wrap">
                <div class="problems__item">
                    <div class="problems__title">проблема рынка</div>
                    <div class="problems__description">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            Человек тратит много времени на поиск подходящего объекта или арендатора/покупателя для
                            своей площади.
                        </div>
                    </div>
                    <div class="problems__title problems--dark">решение</div>
                    <div class="problems__description problems--dark">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            REconnect <span>существенно сокращает время</span> на поиск нужных объектов и
                            арендаторов/покупателей. Чтобы процесс поиска запустился, вам понадобится
                            <span>1 минута</span> работы в захватывающем интерфейсе.
                        </div>
                    </div>
                </div>
            </div>
            <div class="problems__item--wrap">
                <div class="problems__item">
                    <div class="problems__title">проблема рынка</div>
                    <div class="problems__description">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            Найти действительно подходящий объект - сложно.
                        </div>
                    </div>
                    <div class="problems__title problems--dark">решение</div>
                    <div class="problems__description problems--dark">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            <span>Объекты</span>, которые находит REconnect <span>подходят вам</span> по локации,
                            площади, типу недвижимости, назначению, типу сделки и стоимости. А также по ряду
                            необязательных, но важных для старта переговоров параметров: шаг колонн, высота потолков,
                            этаж, зона разгрузки, отдельный вход.
                        </div>
                    </div>
                </div>
            </div>
            <div class="problems__item--wrap">
                <div class="problems__item">
                    <div class="problems__title">проблема рынка</div>
                    <div class="problems__description">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            Я знаю, где именно я хочу открыть точку продаж.
                        </div>
                    </div>
                    <div class="problems__title problems--dark">решение</div>
                    <div class="problems__description problems--dark">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            REconnect расскажет о вашей потребности представителям <span>нужного вам объекта</span>
                            вместе с вашей рекомендацией.
                        </div>
                    </div>
                </div>
            </div>
            <div class="problems__item--wrap">
                <div class="problems__item">
                    <div class="problems__title">проблема рынка</div>
                    <div class="problems__description">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            На данный момент дорого искать и подходящий объект, и оператора торговой недвижимости.
                        </div>
                    </div>
                    <div class="problems__title problems--dark">решение</div>
                    <div class="problems__description problems--dark">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            Работать с торговой недвижимостью в REconnect можно <span>бесплатно</span> или с минимальным
                            бюджетом.
                        </div>
                    </div>
                </div>
            </div>
            <div class="problems__item--wrap">
                <div class="problems__item">
                    <div class="problems__title">проблема рынка</div>
                    <div class="problems__description">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            Найти действительно подходящего оператора розничных услуг - сложно.
                        </div>
                    </div>
                    <div class="problems__title problems--dark">решение</div>
                    <div class="problems__description problems--dark">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            REconnect находит <span>действительно подходящих</span> операторов розничных услуг.
                            Рекомендуемые операторы действительно хотят открыть точку продаж в вашей локации, им
                            подходит ваш тип недвижимости, назначение объекта, тип сделки и стоимость. Также могут быть
                            учтены пожелания по дополнительным важным для старта переговоров параметрам: шаг колонн,
                            высота потолков, этаж, зона разгрузки, отдельный вход.
                        </div>
                    </div>
                </div>
            </div>
            <div class="problems__item--wrap">
                <div class="problems__item">
                    <div class="problems__title">проблема рынка</div>
                    <div class="problems__description">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            Я знаю, с каким именно оператором я хочу заключить сделку.
                        </div>
                    </div>
                    <div class="problems__title problems--dark">решение</div>
                    <div class="problems__description problems--dark">
                        <div class="problems__circle"></div>
                        <div class="problems__text">
                            REconnect расскажет о вашем объекте представителям <span>нужного вам оператора</span> вместе
                            с вашей рекомендацией.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="info" id="howitworks">
    <div class="wrap">
        <div class="info__map"><img src="img/map2.png" alt="карта">
            <svg class="map-pin1">
                <use xlink:href="img/icons/map-pin.svg#map-pin"></use>
            </svg>
            <svg class="map-pin2">
                <use xlink:href="img/icons/map-pin.svg#map-pin"></use>
            </svg>
            <svg class="map-pin3">
                <use xlink:href="img/icons/map-pin.svg#map-pin"></use>
            </svg>
            <div class="map-dot1"></div>
            <div class="map-dot2"></div>
            <div class="map-dot4"></div>
            <div class="map-dot3"></div>
            <svg class="map-pin4">
                <use xlink:href="img/icons/map-pin.svg#map-pin"></use>
            </svg>
            <svg id="map-ret" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 108.3 55.4"
                 style="enable-background:new 0 0 108.3 55.4;" xml:space="preserve">
            <style type="text/css">
                .st01 {
                    fill: #009BA9;
                }

                .st1 {
                    fill: #FFFFFF;
                }

                .st2 {
                    font-family: 'Gilroy';
                    font-weight: 800;
                }

                .st3 {
                    font-size: 12px;
                }

                .st5 {
                    font-family: 'Lato';
                    font-weight: 400;
                }

                .st6 {
                    font-size: 6.7194px;
                }

                .st7 {
                    fill: none;
                    stroke: #FFFFFF;
                    stroke-miterlimit: 10;
                }
            </style>
                <g>
                    <path d="M96.3,55.4H12c-6.6,0-12-5.4-12-12V12C0,5.4,5.4,0,12,0h84.3c6.6,0,12,5.4,12,12v31.4                    C108.3,50,102.9,55.4,96.3,55.4z"
                          class="st01"></path>
                    <text transform="matrix(1 0 0 1 24.4166 16.5836)">
                        <tspan x="0" y="0" class="st1 st2 st3">100-200 м</tspan>
                        <tspan x="58.2" y="0" class="st1 st3">²</tspan>
                    </text>
                    <text transform="matrix(1 0 0 1 9.6666 36.5267)">
                        <tspan x="0" y="0" class="st1 st5 st6">• АРЕНДА</tspan>
                        <tspan x="0" y="9" class="st1 st5 st6">• ТОРГОВОЕ ПОМЕЩЕНИЕ</tspan>
                    </text>
                    <line x1="6.8" y1="23.3" x2="100.3" y2="23.3" class="st7"></line>
                </g>
          </svg>
            <svg id="map-dev" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 82.5 55.4"
                 style="enable-background:new 0 0 82.5 55.4;" xml:space="preserve">
            <style type="text/css">.st0 {
                    fill: #3E4852;
                }</style>
                <g>
                    <path d="M70.5,55.4H12c-6.6,0-12-5.4-12-12V12C0,5.4,5.4,0,12,0h58.5c6.6,0,12,5.4,12,12v31.4                    C82.5,50,77.1,55.4,70.5,55.4z"
                          class="st0"></path>
                    <text transform="matrix(1 0 0 1 23.4167 16.5837)">
                        <tspan x="0" y="0" class="st1 st2 st3">120 м</tspan>
                        <tspan x="29.5" y="0" class="st1 st3">²</tspan>
                    </text>
                    <text transform="matrix(1 0 0 1 9.6667 36.5267)">
                        <tspan x="0" y="0" class="st1 st5 st6">• АРЕНДА</tspan>
                        <tspan x="0" y="9" class="st1 st5 st6">• ПЛОЩАДЬ В ТЦ</tspan>
                    </text>
                    <line x1="6.8" y1="23.3" x2="76.2" y2="23.3" class="st7"></line>
                </g>
          </svg>
        </div>
        <div class="info__main">
            <div class="info__block">
                <div class="info__title">Операторы розничных товаров и услуг</div>
                <ul class="info__list">
                    <li class="info__item">
                        <div class="num">01</div>
                        Описывают свои потребности в недвижимости
                    </li>
                    <li class="info__item">
                        <div class="num">02</div>
                        Получают список объектов, подходящих по указанным параметрам
                    </li>
                    <li class="info__item">
                        <div class="num">03</div>
                        Отправляют запрос оператору торговой недвижимости
                    </li>
                    <li class="info__item accent">
                        <div class="num">04</div>
                        При <span>взаимном </span>интересе открываются контакты сторон
                    </li>
                </ul>
                <?php
                if (Yii::$app->user->isGuest || Yii::$app->user->can('buyerRole'))
                    echo '<a class="btn" href="' . Url::to(['/searches/default/new']) . '">Добавить потребности в сервис</a>';
                ?>
            </div>
            <div class="info__block info--black">
                <div class="info__title">Операторы торговой недвижимости</div>
                <ul class="info__list">
                    <li class="info__item">
                        <div class="num">01</div>
                        Описывают свои объекты
                    </li>
                    <li class="info__item">
                        <div class="num">02</div>
                        Получают запросы от ритейлеров, которым они подходят
                    </li>
                    <li class="info__item">
                        <div class="num">03</div>
                        Отправляют запрос ритейлеру
                    </li>
                    <li class="info__item accent">
                        <div class="num">04</div>
                        При <span>взаимном </span>интересе открываются контакты сторон
                    </li>
                </ul>
                <?php
                if (Yii::$app->user->isGuest || Yii::$app->user->can('sellerRole'))
                    echo '<a class="btn" href="' . Url::to(['/objects/default/new']) . '">Добавить объекты в сервис</a>';
                ?>
            </div>
        </div>
    </div>
</section>
<section class="choice" id="what">
    <div class="choice__circle-bg choice__circle-bg--left"></div>
    <div class="choice__circle-bg choice__circle-bg--right"></div>
    <div class="wrap">
        <h2>
            <div class="choice__title">REconnect</div>
            <div class="choice__def">
                торговая недвижимость <span>находится</span> здесь
            </div>
        </h2>
        <div class="diagram">
            <div class="diagram__item--wrap">
                <div class="diagram__item">
                    <div class="diagram__title">только релевантные запросы и целевые контакты</div>
                    <div class="diagram_description">Ваши <strong>контакты в безопасности</strong>: без взаимного
                        согласия посмотреть их в сервисе нет возможности, а система рейтинга и отзывов поможет вам
                        сделать
                        <strong>осознанный выбор</strong> партнера по переговорам.
                    </div>
                </div>
            </div>
            <div class="diagram__item--wrap">
                <div class="diagram__item">
                    <div class="diagram__title">экономия времени и денег на поиск подходящих объектов</div>
                    <div class="diagram_description">Вам понадобится всего 1 минута работы в захватывающем интерфейсе. И
                        это
                        <strong>бесплатно</strong>.
                    </div>
                </div>
            </div>
            <div class="diagram__item--wrap">
                <div class="diagram__item">
                    <div class="diagram__title">экономия времени на формирование очереди потенциальных клиентов для
                        каждого объекта
                    </div>
                    <div class="diagram_description">Ищете объект в конкретном здании, районе города или в определенной
                        выборке городов? REconnect справится с
                        <strong>любой потребностью</strong>.
                    </div>
                </div>
            </div>
            <div class="diagram__item--wrap">
                <div class="diagram__item">
                    <div class="diagram__title">Повышение дохода от недвижимости</div>
                    <div class="diagram_description">По вашему запросу найдутся не только свободные объекты, но и
                        занятые, с&nbsp;представителями которых можно
                        <strong>вступить в переговоры</strong>.
                    </div>
                </div>
            </div>
            <div class="diagram__circle">
                <div class="circle-top"></div>
                <div class="circle-left"></div>
                <div class="circle-right"></div>
                <div class="circle-bottom"></div>
                <svg class="logo">
                    <use xlink:href="img/icons/logo.svg#logo"></use>
                </svg>
                <svg class="loan">
                    <use xlink:href="img/icons/loan.svg#loan"></use>
                </svg>
                <svg class="cash">
                    <use xlink:href="img/icons/cash.svg#cash"></use>
                </svg>
                <svg class="profile">
                    <use xlink:href="img/icons/profile.svg#profile"></use>
                </svg>
                <svg class="clock">
                    <use xlink:href="img/icons/clock.svg#clock"></use>
                </svg>
            </div>
        </div>
    </div>
</section>
<footer>
    <div class="footer-bg">
        <div class="wrap footer">
            <div class="footer__name">
                <div class="footer__text">Retailer</div>
                <div class="footer__circle">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle circle768"></div>
                    <div class="circle circle768"></div>
                    <div class="circle circle768"></div>
                    <div class="circle circle768"></div>
                </div>
            </div>
            <div class="footer__description">
                <div class="footer__title">Эксперт в коммуникациях на рынке торговой недвижимости</div>
                <div class="footer__subtitle">15 лет мы знакомим нужных друг другу людей и способствуем заключению
                    выгодных сделок
                </div>
            </div>
            <div class="footer__logo">
                <svg class="logo--white">
                    <use xlink:href="img/icons/logo.svg#logo"></use>
                </svg>
            </div>
            <div class="social">
                <div class="social__icons"><a href="https://mssg.me/retailer">
                        <svg class="telegram">
                            <use xlink:href="img/icons/telegram.svg#telegram"></use>
                        </svg>
                    </a><a href="https://mssg.me/retailer">
                        <svg class="whatsapp">
                            <use xlink:href="img/icons/whatsapp.svg#whatsapp"></use>
                        </svg>
                    </a><a href="https://mssg.me/retailer">
                        <svg class="skype">
                            <use xlink:href="img/icons/skype.svg#skype"></use>
                        </svg>
                    </a></div>
                <div class="social__contacts">
                    <!--                <a href="tel:+78005006606" class="phone">+7 (800) 500-66-06</a>-->
                    <a href="mailto:products@re-connect.ru"><span class="mail">products@re-connect.ru</span></a></div>
            </div>
            <div class="footer__menu">
                <ul>
                    <li><a href="<?= Url::to(['/site/tariff']) ?>">Тарифы</a></li>
                    <li><a href="<?= Url::to(['/site/user-agreement']) ?>">Пользовательское соглашение</a></li>
                    <li><a href="<?= Url::to(['/site/privacy-policy']) ?>">Политика конфиденциальности</a></li>
                    <li><a href="<?= Url::to(['/pdf/offer.pdf']) ?>">Договор оферты</a></li>
                </ul>
            </div>
            <div class="footer__login">
                <p>
                    <a href="<?= Url::to(['/user/security/' . (Yii::$app->user->isGuest ? 'login' : 'logout')]) ?>"><?= (Yii::$app->user->isGuest ? 'Регистрация  <span>|</span> Войти' : 'Выйти') ?></a>
                </p>
                <p></p><a href="<?= Url::to(['/site/contacts']) ?>">Контакты</a>
            </div>
            <div class="footer__partners">
                <svg class="tinkoff">
                    <use xlink:href="img/icons/tinkoff.svg#tinkoff"></use>
                </svg>
                <div class="pay">
                    <svg class="mastercard">
                        <use xlink:href="img/icons/mastercard.svg#mastercard"></use>
                    </svg>
                    <svg class="visa">
                        <use xlink:href="img/icons/visa.svg#visa"></use>
                    </svg>
                    <svg class="mir">
                        <use xlink:href="img/icons/mir.svg#mir"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="wrap">
            <div class="rights"><?= GooddayWidget::widget() ?> © <?=date('Y')?> — RETAILER.ru</div>
        </div>
    </div>
</footer>