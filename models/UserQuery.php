<?php
/**
 * Created by PhpStorm.
 * User: Daniellz
 * Date: 15.06.2018
 * Time: 17:51
 */

namespace app\models;


class UserQuery extends \Da\User\Query\UserQuery
{
    /**
     * @param $phone
     *
     * @return $this
     */
    public function wherePhone($phone)
    {
        return $this->andWhere(['username' => $phone]);
    }

    public function notBlocked()
    {
        return $this->andWhere(['blocked_at' => null]);

    }
}