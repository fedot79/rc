<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 05.02.2019
 * Time: 17:18
 */

namespace app\widgets;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class MyCardsFilterWidget extends Widget
{
    public $filter;

    private $cats = [
        'select'=>['active'=>'С пересечениями', 'new'=>'С новыми пересечениями', 'empty'=>'Без'],
        'square'=>[
            'sq1'=>'0-50 <span>м²</span>',
            'sq2'=>'50-200 <span>м²</span>',
            'sq3'=>'200-500 <span>м²</span>',
            'sq4'=>'500-1000 <span>м²</span>',
            'sq5'=>'1000-2000 <span>м²</span>',
            'sq6'=>'2000-∞ <span>м²</span>'
        ],
        'type'=>['street'=>'Стрит', 'square'=>'Площадь в ТЦ', 'land'=>'Участок', 'building'=>'ОСЗ'],
        'deal'=>['sell'=>'Продажа', 'rent'=>'Аренда', 'sellrent'=>'Аренда и продажа']
    ];

    public function run()
    {

        $out = '';

        foreach ($this->cats as $cat=>$items) {
            $filter = $this->filter;
            foreach ($filter as $i=>$_item) {
                if(in_array($_item, array_keys($items)))
                {
                    unset($filter[$i]);
                }
            }
            foreach ($items as $item=>$name) {
                $class = [];
                if(!in_array($item, $filter))
                    $filter[] = $item;
                arsort($filter);
                $filter = array_filter($filter);
                if(array_values($filter)===array_values($this->filter))
                    $class[] = 'active';
                if($cat!=='select')
                    $class[] = 'hidden';
                $out.=Html::a($name, ['/'.Yii::$app->requestedRoute, 'filter'=>implode('-', $filter)], ['data-type'=>$cat, 'class'=>implode(' ', $class)]);
                if(($key = array_search($item, $filter))!==false)
                {
                    unset($filter[$key]);

                }
            }
            $class = [];
            if(array_values($filter)===array_values($this->filter))
                $class[] = 'active';
            if($cat!=='select')
                $class[] = 'hidden';
            $out.=Html::a('Все', ['/'.Yii::$app->requestedRoute, 'filter'=>implode('-', $filter)], ['data-type'=>$cat, 'class'=>implode(' ', $class)]);
        }

        return $out;

    }
}