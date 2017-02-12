<?php
/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 07/02/2017
 * Time: 15:21
 */

namespace Model\Business;

class User
{
    private $login;
    private $password;

    /**
     * UserDB constructor.
     * @param $login
     * @param $password
     */
    public function __construct($id, $login, $password)
    {
        $this->id=$id;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
