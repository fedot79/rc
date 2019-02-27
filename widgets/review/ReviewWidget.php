<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 05.08.2018
 * Time: 18:00
 */

namespace app\widgets\review;


use app\models\UserModel;
use app\modules\negotiation\models\Negotiations;
use app\modules\review\models\Reviews;
use yii\base\Widget;

class ReviewWidget extends Widget
{

    /**
     * @var UserModel
     */
    public $user;

    public function run()
    {
        $form = new Reviews(['scenario'=>Reviews::SCENARIO_NEW]);
        return $this->render('review', ['model'=>$form]);
    }
}