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

class SingleCardWidget extends Widget
{

    /**
     * @var Search|Objects
     */
    public $object = null;

    /**
     * @var Negotiations|null
     */
    public $nego = null;

    /**
     * @var Selection|null
     */
    public $selection = null;

    public static $autoIdPrefix = 'card';
    public $widget_id;

    private $show_contact=false;
    private $action_button='';

    public function run()
    {
        $this->widget_id = $this->getId();

        if($this->nego)
        {
            if($this->nego->confirmed!==null)
            {
                $this->show_contact = true;
                $this->action_button = $this->showContactButton();
            }
            else
            {
                if($this->nego->author_id==Yii::$app->user->id)
                {
                    $this->action_button = $this->cancelButton();
                }
                else
                {
                    $this->action_button = $this->confirmButton();
                }
            }

        }





        return $this->render('_single_card',
            [
                'object'=>$this->object,
                'widget_id'=>$this->widget_id,
                'buttons'=>$this->action_button,
                'selection'=>$this->selection,
                'nego'=>$this->nego,
                'show_contact'=>$this->show_contact
            ]
        );
    }

    private function showContactButton()
    {
        return '<span class="button-common button-sm show-contact">Открыть контакт</span>';
    }

    private function cancelButton()
    {
        $cancelData = ['o'=>$this->nego->object_id, 's'=>$this->nego->search_id];
        return '<span class="button-alter button-sm cancel" data-cancel="'.htmlspecialchars(json_encode($cancelData), ENT_QUOTES, 'UTF-8').'">Отмена</span><span class="button-alter no-action">Ждем ответа</span>';
    }

    private function confirmButton()
    {
        $cancelData = ['o'=>$this->nego->object_id, 's'=>$this->nego->search_id];
        $acceptData = ['o'=>$this->nego->object_id, 's'=>$this->nego->search_id, 't'=>$this->getPayType()];
        return '<span class="button-alter reject" data-reject="'.htmlspecialchars(json_encode($cancelData), ENT_QUOTES, 'UTF-8').'">Нет</span><a href="#" data-accept="'.htmlspecialchars(json_encode($acceptData), ENT_QUOTES, 'UTF-8').'" class="button-common button-sm accept">Взаимно</a>';
    }

    private function getPayType()
    {
        return $this->object::CLASS_STRING;
    }


}