<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 23.08.2018
 * Time: 14:27
 */

namespace app\widgets\goback;


use yii\base\Widget;

class GoBackWidget extends Widget
{
    public function run()
    {
        return $this->render('goback');
    }
}