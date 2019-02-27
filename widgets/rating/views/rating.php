<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 17.07.2018
 * Time: 13:55
 */

use app\assets\RatingAsset;
use app\modules\rating\models\Rating;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/** @var Rating $model */
RatingAsset::register($this);
$user = Yii::$app->user->identity;
?>

<p class="intro rating-start"><span class="header">Рейтинг</span>У каждого пользователя сервиса есть рейтинг.<wbr> Он помогает ориентироваться на этапе выбора делового партнера.<wbr> Рейтинг будет сформирован на основании оценок от других пользователей. Но начальный можно получить уже сейчас.</p>
<button class="get-rating rating-start" id="get_start_rating"><?=$buttonText?></button>
<?php
$form = ActiveForm::begin([
    'id' => 'rating-form',
    'enableClientValidation'=>false,
    'options' => [
        'class'=>'hidden form-panel-full'.($containerClass?(' '.$containerClass):'')
    ],
]);
?>
<h2>Повышение рейтинга</h2>
<hr>
<p><?=(Yii::$app->user->can('sellerRole')?'Чтобы получить начальный рейтинг, просто укажите регионы, в которых находятся ваши объекты и их количество.':'Чтобы получить начальный рейтинг, просто укажите приоритетные для развития вашей компании регионы и примерный план открытий в каждом из них.')?></p>
<div class="scroll-box">
    <div class="rating-row hidden">
        <span></span><?=$form->field($model, 'obj_counts[]')->textInput(['disabled'=>true])->label('Объектов', ['class'=>'light'])?><span class="delete">&times;</span>
    </div>
    <div class="input-row">
        <!--    <?//=$form->field($model, 'regions[]')->textInput(['list'=>'regions-list'])?>-->
        <!--    <?//=\app\components\Html::dataList($model->getRegionsDropDown(), ['id'=>'regions-list'])?>-->
        <?=$form->field($model, 'regions[]', ['options'=>['class'=>'superselect-wrap']])->dropDownList($model->getRegionsDropDown(), ['prompt'=>'Выберите регион', 'class'=>'superselect'])->label(false)?>

        <?=Html::button('Добавить регион', ['id'=>'add_regions', 'class'=>'button-plus hidden'])?>
    </div>
</div>
<div class="submit-row">
    <?=Html::submitButton('Отправить', ['class'=>'send button-common'])?>
    <button id="close" class="button-dotted">В другой раз</button>
    <div class="help-block hidden">Введите данные для отправки</div>
</div>
<?php ActiveForm::end();?>
<div class="rating-success hidden form-panel-full">
    <h2>Поздравляем!</h2>
    <p>Вы получили рейтинг, и ваша карточка будет выглядеть более привлекательно.</p>
    <img src="<?=$user->getAvatarPic()?>">
    <?=\app\widgets\stars\StarsWidget::widget(['stars'=>1])?>
    <div class="rating-text dots-between">
        <span>Рейтинг</span>
        <hr>
        <span>1</span>
    </div>
    <button class="button-common" id="close-rating-success">
        Продолжить
    </button>
</div>
