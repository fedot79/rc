<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 17.07.2018
 * Time: 13:43
 */

namespace app\widgets\help;


use yii\base\Widget;

class HelpWidget extends Widget
{
    public function run()
    {
        $model = new HelpForm();
        return $this->render('@app/widgets/help/views/helpWidget', ['model'=>$model]);
    }
}