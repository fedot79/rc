<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 14.08.2018
 * Time: 0:33
 */

namespace app\widgets\usercard;


use yii\base\Widget;

class UserCardWidget extends Widget
{
    public $user;
    public $review_button = false;
    public $close_negotiation = false;
    public $review_left = false;
    public $nego;
    public $mini = false;
    public $review;
    public $new_design = false;

    public function run()
    {
        if($this->new_design)
            return $this->render('new', ['user'=>$this->user]);

        if($this->mini)
            $view = 'miniCard';
        else
            $view = 'usercard';
        return $this->render($view,
            [
                'user'=>$this->user,
                'review_button'=>$this->review_button,
                'close_negotiation'=>$this->close_negotiation,
                'review_left'=>$this->review_left,
                'review'=>$this->review

            ]);
    }
}