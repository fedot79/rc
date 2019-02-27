<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 23.01.2019
 * Time: 15:01
 */

namespace app\widgets\customRequest;


use app\models\CustomRequest;
use Yii;
use yii\base\Widget;

class CustomRequestWidget extends Widget
{
    public $type;

    public function run()
    {
        if(!CustomRequest::find(['user_id'=>Yii::$app->user->id])->one())
        {
            if($this->type == 'buttons')
                return $this->render('buttons');
            if($this->type == 'popup')
                return $this->render('custom-request');
        }
        return '';
    }
}