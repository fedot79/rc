<?php
/**
 * Created by PhpStorm.
 * User: fedot
 * Date: 25.02.2019
 * Time: 9:54
 */

namespace app\models;


use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Second extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }

    public static function getAll()
    {
        $data_role = self::find()->all();
        return $data_role;
    }
}
