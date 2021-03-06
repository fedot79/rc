<?php

/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 23.01.2019
 * Time: 15:02
 */

use app\assets\CustomRequestAsset;
use yii\helpers\Url;

CustomRequestAsset::register($this);
/* @var $this \yii\web\View */
?>
<div class="popup wholerf hidden">
    <span class="close-popup"></span>
    <div class="popup-wrapper">
        <h2>Ищете торговую недвижимость по всей РФ?</h2>
        <p>На основе только что созданной вами потребности вы можете создать точно такие же по всей Российской Федерации. Все другие параметры, кроме локации, сохранятся в ранее введенном вами виде.</p>
        <h2>Как это работает?</h2>
        <p>Вы только что опубликовали потребность в недвижимости. Далее вы можете
            разместить идентичные потребности во всех городах РФ с населением >1000 человек. Поиск по каждой из них начнется
            автоматически, и те, по которым сразу появятся совпадения, будут показаны наверху списк всех потребностей на
            странице “Мои потребности”. Всего таких потребностей получится <strong>1172</strong>.</p>
        <p>Чтобы вы смогли удобно работать с таким большим количеством потребностей, на соответствующей странице появятся
            фильтры:</p>
        <ul>
            <li>По типу объекта</li>
            <li>По типу сделки</li>
            <li>По наличию предложений</li>
            <li>По диапазону площади</li>
        </ul>
        <h2>Чем это чревато?</h2>
        <p>Сервис REconnect работает с точечными потребностями. Это значит, что максимальный радиус поиска ограничен 1.5
            км, чтобы ваши потребности, попадая в подборы к операторам торговых площадей, оставались для них максимально
            релевантными. Актуальность потребностей к объектам и объектов к потребностям - основная философия нашего
            сервиса. Соответственно, размещая потребности по всей России, вы снижаете релевантность последующих подборов -
            как для себя, так и для ваших потенциальных партнеров по переговорам.</p>
        <p>В связи с чем настоятельно рекомендуем дважды подумать, прежде чем идти на этот шаг. На выходе вы увидите ваш
            запрос на торговую недвижимость по всей РФ, представленный в виде 1172 карточек, по каждой из которых будет
            работать отдельный подбор, который вы будете обрабатывать в поисках нужного объекта. Поэтому, соглашаясь на
            размножение потребности, убедитесь, что вы ввели максимальное количество известных вам дополнительных параметров
            - этаж, шаг колонн, высота потолков, наличие зоны разгрузки/отдельного входа. Таким образом вы повысите
            актуальность поступающих предложений.</p>

        <span class="send-custom-request help-me">Я все понял, дублировать потребность на всю РФ</span>
        <p>Нажимая эту кнопку, вы принимаете описанные условия. Дублирование потребности  по всем городам РФ займет до 24 часов. Мы оповестим вас по смс, когда REconnect закончит работу, и созданные потребности будут доступны на соответствующей
            <a class="def-link" href="<?=Url::to(['/searches/default/my'])?>">странице</a>.
        </p>

    </div>
</div>