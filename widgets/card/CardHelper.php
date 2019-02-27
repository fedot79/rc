<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 31.08.2018
 * Time: 18:40
 */

namespace app\widgets\card;


use app\components\Color;
use app\modules\objects\models\Objects;
use app\modules\searches\models\Search;
use Yii;

class CardHelper
{
    public static function getBrandStyle($color, $id): string
    {
        $rgba = Color::hex2rgba($color, 0.1);
        $color_style =
            '#'.$id.'{color: '.$color.';
border-color: '.$color.';
background-color: '.$color.';
fill: '.$color.';
stroke: '.$color.';
box-shadow: 0px 10px 21px 0px '.$rgba.';
}
#'.$id.' .card-deal{background-color:'.$rgba.'}#'.$id.' .button-common:hover{background-color:'.$color.'}';
        if($color==null)
            return '';
        return '<style id="style-for-'.$id.'">'.$color_style.'</style>';
    }

    /**
     * @param Objects|Search $object
     * @return string
     */
    public static function getDealBlock($object): string
    {
        $price_rent = '';
        $no_choose_rent = ' no-choose';
        if ($object->price_rent) {
            $price_rent = $object->price_rent;
            $no_choose_rent = '';
        }
        $price_sell = '';
        $no_choose_sell = ' no-choose';
        if ($object->price_sell) {
            $price_sell = $object->price_sell;
            $no_choose_sell = '';
        }
        $out = '';
        $gain = '';
        $rent = ($object->price_rent > 0) ? number_format($object->price_rent, 0, '', '&thinsp;') . '₽/мес' : '';
        $gain = ($object->gain_percent>0)?('+'.$object->gain_percent.'%'):'';
        $sell = ($object->price_sell > 0) ? number_format($object->price_sell, 0, '', '&thinsp;') . '₽' : '';
        if ($object->deal_type == 'rent' || $object->deal_type == 'sell-rent') {
            $out .= '<div class="card-label' . $no_choose_rent . '">
                <span>Аренда</span>' . $rent.$gain. '
        </div>';
        }
        if ($object->deal_type == 'sell' || $object->deal_type == 'sell-rent') {
            $out .= '<div class="card-label' . $no_choose_sell . '">
                <span>Продажа</span>' . $sell . '
        </div>';
        }
        return $out;
    }

    public static function getDealBlockNew($object): string
    {
        $price_rent = '' ;
        $no_choose_rent=' no-choose';
        if($object->price_rent)
        {
            $price_rent = $object->price_rent;
            $no_choose_rent = '';
        }
        $price_sell = '' ;
        $no_choose_sell=' no-choose';
        if($object->price_sell)
        {
            $price_sell = $object->price_sell;
            $no_choose_sell = '';
        }
        $out = '';
        $gain = '';
        $rent = ($object->price_rent>0)?number_format($object->price_rent, 0, '', '&thinsp;'):'';
        $gain = ($object->gain_percent>0)?('+'.$object->gain_percent.'%'):'';
        $sell = ($object->price_sell>0)?number_format($object->price_sell, 0, '', '&thinsp;'):'';
        $out .= '<div class="card-label'.$no_choose_rent.''.(($object->deal_type=='rent' || $object->deal_type=='sell-rent')?'':' hidden').'">
            <span>Аренда</span>'.$rent.' ₽/мес'.$gain.'
        </div>';
        $out .= '<div class="card-label'.$no_choose_sell.''.(($object->deal_type=='sell' || $object->deal_type=='sell-rent')?'':' hidden').'">
            <span>Продажа</span>'.$sell.' ₽
        </div>';
        return $out;
    }

    /**
     * @param Objects|Search $object
     * @return string
     */
    public static function getDealBlockForm($object): string
    {
        $price_rent = '' ;
        $no_choose_rent=' no-choose';
        if($object->price_rent)
        {
            $price_rent = $object->price_rent;
            $no_choose_rent = '';
        }
        $price_sell = '' ;
        $no_choose_sell=' no-choose';
        if($object->price_sell)
        {
            $price_sell = $object->price_sell;
            $no_choose_sell = '';
        }
        $out = '<label class="card-label'.$no_choose_rent.'">
            <span>Аренда</span><input type="text" name="'.$object->getClass().'[price_rent]" id="form_price_rent" value="'.$price_rent.'"> ₽/мес
        </label>
        <label class="card-label'.$no_choose_sell.'">
            <span>Продажа</span><input type="text" name="'.$object->getClass().'[price_sell]" id="form_price_sell" value="'.$price_sell.'"> ₽
        </label><input type="hidden" name="'.$object->getClass().'[deal_rent]" id="form_deal_rent" value="'.($object->deal_rent?1:0).'"><input type="hidden" name="'.$object->getClass().'[deal_sell]" id="form_deal_sell"  value="'.($object->deal_sell?1:0).'">';
        return $out;
    }

    /**
     * @param Objects|Search $object
     * @return string
     */
    public static function getInfoForm($object): string
    {
        $square = ($object->canGetProperty('square'))?'square':'square_string';

        return
            '<dt>Площадь</dt>
            <dd><input type="text" id="form_square" name="'.$object->getClass().'['.$square.']" value="'.$object->$square.'"> м²</dd>
            <dt>Этаж</dt>
            <dd><input type="text" id="form_floor" name="'.$object->getClass().'[floor]" value="'.$object->floor.'"></dd>
            <dt>Шаг колонн</dt>
            <dd><input type="text" id="form_column" name="'.$object->getClass().'[column]" value="'.$object->column.'"></dd>
            <dt>Высота потолков</dt>
            <dd><input type="text" id="form_ceil" name="'.$object->getClass().'[ceil]" value="'.$object->ceil.'"> м</dd>
            <dt class="short">Зона разгрузки</dt>
            <dd><span class="tristate tristate-switcher">
                <input type="radio"  name="'.$object->getClass().'[shipping_zone]" value="-1" '.(($object->shipping_zone==-1)?'checked':'').'>
                <input type="radio"  name="'.$object->getClass().'[shipping_zone]" value="0" '.(($object->shipping_zone==0)?'checked':'').'>
                <input type="radio"  name="'.$object->getClass().'[shipping_zone]" value="1" '.(($object->shipping_zone==1)?'checked':'').'>
                <i></i>
            </span></dd>
            <dt class="short">Отдельный вход</dt>
            <dd><span class="tristate tristate-switcher">
                <input type="radio"  name="'.$object->getClass().'[entrance]" value="-1" '.(($object->entrance==-1)?'checked':'').'>
                <input type="radio"  name="'.$object->getClass().'[entrance]" value="0" '.(($object->entrance==0)?'checked':'').'>
                <input type="radio"  name="'.$object->getClass().'[entrance]" value="1" '.(($object->entrance==1)?'checked':'').'>
                <i></i>
            </span></dd>';
    }

    /**
     * @param Objects|Search $object
     * @return string
     */
    public static function getInfo($object): string
    {
        $svg_not = '<svg class="not"><use xlink:href="/img/cross-remove-sign-g.svg#cross-remove-sign-g.svg"></use></svg>';
        $svg_ok = '<svg class="ok"><use xlink:href="/img/correct-symbol-g.svg#correct-symbol-g.svg"></use></svg>';


        return
        '<dt>Площадь</dt>
        <dd>'.$object->getSquareString().'</dd>
        <dt>Этаж</dt>
        <dd>'.self::getDash($object->floor).'</dd>
        <dt>Шаг колонн</dt>
        <dd>'.self::getDash($object->column,' м').'</dd>
        <dt>Высота потолков</dt>
        <dd>'.self::getDash($object->ceil, ' м').'</dd>
        <dt>Зона разгрузки</dt>
        <dd>'.(($object->shipping_zone!==null && $object->shipping_zone!==0)?'<span class="'.$object->getYesNo('shipping_zone').'">'.$svg_not.$svg_ok.'</span>': $svg_not.$svg_ok.'&mdash;').'</dd>
        <dt>Отдельный вход</dt>
        <dd>'.(($object->entrance!==null && $object->entrance!==0)?'<span class="'.$object->getYesNo('entrance').'">'.$svg_not.$svg_ok.'</span>': $svg_not.$svg_ok.'&mdash;').'</dd>';
    }

    /**
     * @param Objects|Search $object
     * @return string
     */
    public static function getSpine($object)
    {
        return
            '
        <svg class="close-map" title="Закрыть карту"><use xlink:href="/img/left-arrow.svg#left-arrow.svg"></use></svg>
        <div class="card-th th-square">
            <svg><use xlink:href="/img/area.svg#area"></use></svg>
        </div>
        <div class="metrik square">'.$object->getSquareString().'</div>
        <div class="card-th th-floor">
            <svg><use xlink:href="/img/floor.svg#floor"></use></svg>
        </div>
        <div class="metrik floor">'.self::getDash($object->floor).'</div>
        <div class="card-th th-column">
            <svg><use xlink:href="/img/columns.svg#columns"></use></svg>
        </div>
        <div class="metrik column">'.self::getDash($object->column, ' м').'</div>
        <div class="card-th th-height">
            <svg><use xlink:href="/img/ceilingheight.svg#ceil"></use></svg>
        </div>
        <div class="metrik height">'.self::getDash($object->ceil, ' м').'</div>
        <div class="card-th th-shipping">
            <svg><use xlink:href="/img/shippingzone.svg#shipping"></use></svg>
        </div>
        <div class="metrik shipping">'.(($object->shipping_zone!==null && $object->shipping_zone!==0)?'<span class="'.$object->getYesNo('shipping_zone').'">'.$object->getYesNoSvg('shipping_zone').'</span>': '&mdash;').'</div>
        <div class="card-th th-entrance">
            <svg><use xlink:href="/img/separateexit.svg#entrance"></use></svg>
        </div>
        <div class="metrik entrance">'.(($object->entrance!==null && $object->entrance!==0)?'<span class="'.$object->getYesNo('entrance').'">'.$object->getYesNoSvg('entrance').'</span>': '&mdash;').'</div>';
    }

    private static function getDash($val, $dim=null){
        if($val!==null)
            return $val.($dim?(' '.$dim):'');
        else
            return '&mdash;';
    }

    /**
     * @param Objects|Search $object
     * @param string $logo
     * @param string $alt_name
     * @return string
     */
    public static function getTypeForm($object, $logo, $alt_name)
    {
        return '<div class="object-slider">
            <div class="slide card-type" data-id="square"><img src="'.($logo ?'/uploads/'.$logo:'/img/ttse.png').'" alt="ПЛОЩАДЬ В ТЦ" width="72px" height="72px">ПЛОЩАДЬ В ТЦ</div>
            <div class="slide card-type" data-id="street"><img src="'.($logo ?'/uploads/'.$logo:'/img/separate.svg').'" alt="СТРИТ-РИТЕЙЛ" width="72px" height="72px">СТРИТ-РИТЕЙЛ</div>
            <div class="slide card-type" data-id="building"><img src="'.($logo ?'/uploads/'.$logo:'/img/separate1.svg').'" alt="ОТДЕЛЬНОЕ ЗДАНИЕ" width="72px" height="72px">ОТДЕЛЬНОЕ ЗДАНИЕ</div>
            <div class="slide card-type" data-id="land"><img src="'.($logo ?'/uploads/'.$logo:'/img/stead1.svg').'" alt="УЧАСТОК" width="72px" height="72px">УЧАСТОК</div>
        </div><input type="hidden" name="'.$object->getClass().'[type]" id="form_type" value="'.$object->type.'">';
    }

    /**
     * @param Objects|Search $object
     * @param string $logo
     * @param string $alt_name
     * @return string
     */
    public static function getType($object, $logo, $alt_name): string
    {
        return '<img src="'.$object->getTypeImg().'" alt="'.$object->getTypeString().'" width="72px" height="72px">
                '.$object->getTypeString(true).'
                '.(($logo)?('<div class="logo" '.$alt_name.' style="background-image: url(/uploads/'.$logo.')"></div>'):'');
    }

    /**
     * @param Objects|Search $object
     * @return string
     */
    public static function getMapForm($object)
    {
        Yii::info($object->address->getAddressString());
        $out =
            '<input type="hidden" id="addressform-lat" name="AddressForm[lat]" value="'.$object->address->lat.'">'.
            '<input type="hidden" id="addressform-lng" name="AddressForm[lng]" value="'.$object->address->lng.'">'.
            '<input type="text" id="addressform-address_string" data-type="'.$object->getClass().'" class="form-control  m-shadow" name="AddressForm[address_string]" autocomplete="off" aria-invalid="true" value="'.$object->address->getAddressString().'">'.
            '<svg class="search-icon"><use xlink:href="/img/search.svg#search.svg"></use></svg>'.
            '<svg class="clear-icon hidden"><use xlink:href="/img/cross-remove-sign-g.svg#cross-remove-sign-g.svg"></use></svg>'.
            '<input type="hidden" id="addressform-city" name="AddressForm[city]" value="'.$object->address->city->name.'">'.
            '<input type="hidden" id="addressform-region" name="AddressForm[region]" value="'.$object->address->region->name.'">'.
            '<input type="hidden" id="addressform-street" name="AddressForm[street]" value="'.$object->address->street.'">'.
            '<input type="hidden" id="addressform-house" name="AddressForm[house]" value="'.$object->address->house.'">'            ;
        if($object->getClass()=='Search')
            $out.='<div class="map-control slider-wrapper  m-shadow">Радиус поиска <input type="text" data-slider-highlight="true" data-slider-range="20,1500" data-slider="true" id="form-distance" name="Search[distance]" value="'.($object->distance).'"><span><input type="text" id="form_distance_text" value="'.($object->distance).'">м</span></div>';

        return $out;
    }

    public static function getMapInfo($object)
    {
        $info = ($object->getClass()=='Search')
            ? '•  Чтобы найти нужное место на карте, начните вводить адрес и выберите нужный из предложенных вариантов<br><br>
•  Или просто отметьте область, кликнув на карту в нужном месте<br><br>
•  Чтобы скорректировать зону поиска перемещайте ее по карте перетаскиванием<br><br>
•  Чтобы уточнить радиус поиска, используйте шкалу внизу'
            : '•  Начните вводить адрес и выберите нужный вариант<br><br>
•  Если адрес не удается найти, укажите ближайший и поставьте точку кликом<br><br>
•  Адрес можно указать с помощью координат в формате “59.983957, 30.234495”; для этого найдите свой объект в <a href="https://www.google.com/maps" class="def-link" target="_blank" rel="nofollow">google maps</a> или на <a href="http://maps.yandex.ru/" class="def-link" target="_blank" rel="nofollow">Яндекс Картах</a> и скопируйте координаты точки в строку поиска<br><br>
•  Точку можно переместить, кликом по карте';

        return
            '<div class="map-info">Инструкция<svg><use xlink:href="/img/chevron-arrow-up.svg#chevron-arrow-up.svg"></use></svg></div><div class="map-full-info">'.$info.'</div>';
    }
}