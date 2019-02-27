<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 05.08.2018
 * Time: 18:17
 */

use app\widgets\review\ReviewAsset;
use app\widgets\stars\StarsWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this \yii\web\View */
/* @var $model \app\modules\review\models\Reviews */
ReviewAsset::register($this);


?>
<div id="review-box" class="lightbox review-box">
    <h2 class="icon icon-ok">Переговоры завершены</h2>
    <hr>
    <p class="padded"><strong>Оставьте отзыв о {pred}.</strong><br>
    Это повысит ваш рейтинг и повлияет на рейтинг {rod}.</p>
    <a href="" class="button-dotted">Как работает рейтинг</a>
    <?php

    $form = ActiveForm::begin([
        'id' => 'review-form',
        'enableClientValidation'=>false,
        'options' => [
            'class'=>'edit'
        ],
    ]);
    ?>
        <div class="rating-row column">
            <?=$form->field($model, 'rating')->hiddenInput()->label('Оцените {rod} по 5-ти бальной шкале.')?>
            <?= StarsWidget::widget(['stars' => 0])?>
        </div>
        <div class="rating-row">
            <?=$form->field($model, 'text')->textarea(['placeholder'=>'Напишите пару слов о {pred}', 'rows'=>5])->label(false)?>
        </div>
        <?=$form->field($model, 'negotiation_id')->hiddenInput()->label(false)?>
        <?=$form->field($model, 'id')->hiddenInput()->label(false)?>
        <?=$form->field($model, 'user_id')->hiddenInput()->label(false)?>
        <div class="rating-row">
            <span class="button-dotted button-close">Нет, спасибо</span>
            <button class="send button-common">Отправить</button>
        </div>
    <?php ActiveForm::end();?>
</div>
<div id="review-show-box" class="lightbox review-box column">
    <h2 class="icon icon-eye">Отзыв на модерации</h2>
    <p class="padded">После проверки он будет опубликован<br><a href="" class="button-dotted">Как работает рейтинг</a></p>

    <hr>
    <div class="light-row">
        <?= StarsWidget::widget(['stars' => 0])?>
        <button class="button-edit button-right">Редактировать</button>
    </div>
    <p class="review-text"></p>

    <div class="rating-row">
        <span class="button-dotted button-close hidden">Нет, спасибо</span>
        <button class="button-common send hidden">Отправить</button>
        <button class="button-common button-right button-close">Ок</button>
    </div>
</div>
<div id="review-moderated-box" class="lightbox review-box column">
    <h2 class="icon icon-review">Отзыв опубликован</h2>
    <a href="" class="button-dotted">Как работает рейтинг</a>
    <hr>
    <div class="light-row">
        <?= StarsWidget::widget(['stars' => 0])?>
    </div>
    <p class="review-text"></p>
    <div class="rating-row">
        <button class="button-common button-right button-close">Ок</button>
    </div>
</div>
<div id="thx-box" class="lightbox thx-box column">
    <h2>Спасибо!</h2>
    <p>
        Мы получили отзыв. Он будет опубликован после модерации.
    </p>
    <ul>
        <li>Статус модерации отзыва можно посмотреть на странице <a href="/reviews" class="button-dotted"><strong>Отзывы</strong></a>
            <br>
            В дальнейшем, все отзывы и статус их модерации можно будет смотреть на этой странице
        </li>
    </ul>
    <div class="rating-row">
        <button class="button-common button-right button-close">Ок</button>
    </div>
</div>