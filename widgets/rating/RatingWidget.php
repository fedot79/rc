<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 17.07.2018
 * Time: 13:43
 */

namespace app\widgets\rating;


use app\modules\rating\models\Rating;
use yii\base\Widget;

class RatingWidget extends Widget
{
    public $containerClass = null;
    public $buttonText = 'ПОЛУЧИТЬ НАЧАЛЬНЫЙ РЕЙТИНГ';

    public function run()
    {
        if(Rating::find()->select('id')->thisUser()->one()==null)
        {
            $model = new Rating(['scenario' => Rating::SCENARIO_NEW]);
            return $this->render('rating', ['model'=>$model, 'containerClass'=>$this->containerClass, 'buttonText'=>$this->buttonText]);
        }
    }
}