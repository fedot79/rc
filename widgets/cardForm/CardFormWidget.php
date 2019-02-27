<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 13.09.2018
 * Time: 16:38
 */

namespace app\widgets\cardForm;


use app\modules\objects\models\AddressForm;
use app\modules\objects\models\Objects;
use app\modules\searches\models\Search;
use yii\base\Widget;

class CardFormWidget extends Widget
{
    /**
     * @var Objects|Search
     */
    public $object;

    /**
     * @var AddressForm
     */
    public $address;

    public function run(){

        return $this->render('cardForm', ['object'=>$this->object, 'address'=>$this->address]);
    }
}