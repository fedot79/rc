<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace app\models;

use Da\User\Query\UserQuery;
//use app\models\UserQuery;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends \Da\User\Search\UserSearch
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $phone;
    /**
     * @var int
     */
    public $created_at;
    /**
     * @var int
     */
    public $last_login_at;
    /**
     * @var string
     */
    public $registration_ip;
    /**
     * @var UserQuery
     */
    protected $query;

//    public $selection_count;

    /**
     * UserSearch constructor.
     *
     * @param UserQuery $query
     * @param array     $config
     */
//    public function __construct(UserQuery $query, $config = [])
//    {
//        $this->query = $query;
//        parent::__construct(new UserQuery(), $config);
//    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'safeFields' => [['username', 'registration_ip', 'created_at', 'last_login_at', 'email', 'name', 'blocked_at', 'selection_count'], 'safe'],
            'createdDefault' => [['created_at', 'last_login_at'], 'default', 'value' => null],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name'=>'Имя',
            'email'=>'Почта',
            'username' => Yii::t('usuario', 'Username'),
//            'phone' => Yii::t('usuario', 'Phone'),
            'created_at' => Yii::t('usuario', 'Registration time'),
            'registration_ip' => Yii::t('usuario', 'Registration IP'),
            'last_login_at' => Yii::t('usuario', 'Last login'),
            'selection_count'=> 'Пересечений'
        ];
    }

    /**
     * @param $params
     *
     * @throws InvalidParamException
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->query;
        $query->joinWith(['profile']);

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'sort'=>[
                    'attributes'=>[
                        'name',
                        'username',
                        'email',
                        'created_at',
                        'last_login_at',
//                        'selection_count'
//                        'selection_count'=>[
//                            'asc'=>[]
//                        ]
                    ]
                ]
            ]
        );

        if (!($this->load($params) && $this->validate())) {

//            echo '<pre>'.PHP_EOL;
//            var_dump($dataProvider);
//            echo '</pre>'.PHP_EOL;
//            die;
            return $dataProvider;
        }


        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $date, $date + 3600 * 24]);
        }

        if ($this->last_login_at !== null) {
            $date = strtotime($this->last_login_at);
            $query->andFilterWhere(['between', 'last_login_at', $date, $date + 3600 * 24]);
        }



        $query
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'profile.public_email', $this->email])
            ->andFilterWhere(['like', 'profile.name', $this->name])
//            ->andFilterWhere(['phone'=>$this->phone])

            ->andFilterWhere(['registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }
}
