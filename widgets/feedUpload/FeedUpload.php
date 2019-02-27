<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 21.09.2018
 * Time: 12:22
 */

namespace app\widgets\feedUpload;
use yii\base\Widget;
class FeedUpload extends Widget
{
    public function run(){
        return $this->render('feedUpload');
    }
}