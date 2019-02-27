<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 08.08.2018
 * Time: 11:45
 */

namespace app\widgets\stars;


use Yii;
use yii\base\Widget;

class StarsWidget extends Widget
{
    public $stars;

    public function run()
    {
        static::$counter++;
//        Yii::info('call stars');
//        Yii::info(self::$counter);
        return $this->render('stars', ['stars'=>$this->stars, 'counter'=>self::$counter]);
    }

}