<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 02.10.2018
 * Time: 16:14
 */

namespace app\widgets\intro;


use Yii;
use yii\base\Widget;

class IntroWidget extends Widget
{
    public $type;

    public function run(){
        Yii::info($this->type);
//        if(empty($_COOKIE['intro_shown']))
//        {
            if($this->type=='search')
                return $this->render('intro');
            return $this->render('intro-dev');
//        }
    }
}