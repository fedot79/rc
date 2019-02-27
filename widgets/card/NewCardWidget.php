<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 17.12.2018
 * Time: 15:03
 */

namespace app\widgets\card;


use app\modules\negotiation\models\Negotiations;
use app\modules\objects\models\Objects;
use app\modules\searches\models\Search;
use app\modules\selection\models\Selection;
use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class NewCardWidget extends Widget
{
    const EDIT='edit';
    const SELECTION = 'selection';
    const CONTACT = 'contact';
//    const

    /**
     * @var string edit|selection|contact
     */
    public $scenario;

    public $branded = false;
    public $brand = null;
    /**
     * @var Search|Objects
     */
    public $object = null;

    public $params = [];

    public static $autoIdPrefix = 'card';
    public $widget_id;

    public $contact_price;

    public function run()
    {
        $this->widget_id = $this->getId();
        $method = '_run_'.$this->scenario;
        return $this->$method();
    }

    public function _run_selection()
    {
        /** @var Selection $selection */
        $selection = $this->params['selection'];
        $brand = $selection->getOtherUser()->brand;
        $seen = $selection->getISaw();
        $anotherType = (Yii::$app->user->identity->whoAmI()=='seller'?'search':'object');
        $this_type = (Yii::$app->user->identity->whoAmI()=='seller'?'object':'search');
        $actions = '<span class="button-alter reject">Нет</span><a href="'.Url::to(['/payment/default/pay', 'object_id'=>$selection->object_id, 'search_id'=>$selection->search_id, 'type'=>$anotherType]).'" class="button-common button-sm"><strong>интересно</strong> | '.$selection->{$anotherType}->getContactPrice($selection->{$this_type}).'</a>';

        if($selection->getILiked())
            $actions = '<span class="button-alter button-sm cancel">Отмена</span><span class="button-alter no-action">Ждем ответа</span>';
        if($selection->otherSideLiked())
            $actions = '<span class="button-alter reject">Нет</span><a href="'.Url::to(['/payment/default/pay', 'object_id'=>$selection->object_id, 'search_id'=>$selection->search_id, 'type'=>$anotherType]).'" class="button-common button-sm">Взаимно</a>';
        if($selection->getILiked() && $selection->otherSideLiked())
        {
            $nego_id = Negotiations::find()->select('id')->byObjectSearch($selection->object_id, $selection->search_id)->andWhere(['cancelled'=>null])->limit(1)->scalar();
            $anty = $anotherType.'_id';
            $actions = '<a href="'.Url::to(['/payment/default/contact-show', 'nego_id'=>$nego_id, 'object_id'=>$selection->$anty, 'type'=>$anotherType]).'" class="button-common button-sm show-contact">Открыть контакт</a>';
        }


        return $this->render('_card_selection', [
            'brand'=>$brand,
            'object'=>$this->object,
            'widget_id'=>$this->widget_id,
            'seen'=>$seen,
            'actions'=>$actions,
            'widget_counter'=>$this->params['widget_counter']
        ]);
    }

    public function _run_contact()
    {
        return $this->render('_card_contact', [
            'object'=>$this->object,
            'widget_id'=>$this->widget_id,
        ]);
    }
}