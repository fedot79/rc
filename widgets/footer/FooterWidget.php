<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 30.08.2018
 * Time: 14:56
 */

namespace app\widgets\footer;


use yii\base\Widget;

class FooterWidget extends Widget
{

    public function run()
    {
        return $this->render('footer');
    }
}