<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 14.01.2019
 * Time: 17:43
 */

namespace app\widgets;


use yii\base\Widget;

class GooddayWidget extends Widget
{
    public function run()
    {
        $days = ["Хорошего воскресения", 'Хорошего понедельника', 'Хорошего вторника',  "Хорошей среды", "Хорошего четверга", "Хорошей пятницы", "Хорошей субботы", "Хорошего воскресения"];
        $dow = date('N');
        return $days[$dow].'!';
    }
}