<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 16.07.2018
 * Time: 21:07
 */

namespace app\widgets\help;


use yii\base\Model;

class HelpForm extends Model
{
    public $email;
    public $text;

    public function rules()
    {
        return [
            ['email', 'email', 'message' => 'Некорректный формат'],
            [['text'], 'string'],
            [['text', 'email'], 'required', 'message' => 'Обязательное поле']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'=>'Ваш email',
            'text'=>'Опишите ситуацию',
        ];
    }
}