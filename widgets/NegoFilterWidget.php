<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 08.02.2019
 * Time: 12:38
 */

namespace app\widgets;


use yii\base\Widget;

class NegoFilterWidget extends Widget
{
    public $filter;

    private $cats =  [0=>['', 'все'], 'waiting'=>['/waiting', 'ожидают ответа'], 'pending'=>['/pending', 'начались'], 'finished'=>['/finished', 'завершенные']];

    public function run()
    {
        $out = '';
        foreach ($this->cats as $f=>$_filter) {
            $active = ($f===$this->filter)?' class="active"':'';
            $tag = ($f===$this->filter)?'span':'a';
            $out.= '<'.$tag.' href="/negotiations'.$_filter[0].'"'.$active.'>'.$_filter[1].'</'.$tag.'>';
        }
        return $out;
    }
}