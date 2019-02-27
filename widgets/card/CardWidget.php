<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 26.08.2018
 * Time: 17:57
 */

namespace app\widgets\card;


use app\modules\objects\models\Objects;
use app\modules\searches\models\Search;
use yii\base\Widget;

class CardWidget extends Widget
{
    /**
     * @var Objects|Search
     */
    public $object;
    public $color=null;
    public $logo=null;
    public $name=null;
    public $branded = false;
    public $edit = false;
    public $new_edit = false;
    public $type=null;
    public $button=null;
    public $no_buttons=false;
    public $status = false;
    public $contact_price = false;
    public $no_button = 'Нет';
    public $classes = [];
    public $contact_price_price = false;

    /**
     * @var bool already seen on selection
     */
    public $seen = false;

    public static $autoIdPrefix = 'card';

    public function run()
    {
        $this->classes[] = 'card-new';
        if($this->color || $this->logo)
            $this->branded = true;
        $widget_id = $this->getId();
        return $this->render('card', [
            'id'=>$widget_id,
            'object'=>$this->object,
            'color'=>$this->color,
            'branded'=>$this->branded,
            'logo'=>$this->logo,
            'name'=>$this->name,
            'edit'=>$this->edit,
            'new_edit'=>$this->new_edit,
            'type'=>$this->type,
            'button'=>$this->button,
            'no_buttons'=>$this->no_buttons,
            'status'=>$this->status,
            'seen'=>$this->seen,
            'contact_price'=>$this->contact_price,
            'contact_price_price'=>$this->contact_price_price,
            'no_button'=>$this->no_button,
            'classes'=>$this->classes
        ]);
    }

    private function getColorStyle()
    {

    }
}