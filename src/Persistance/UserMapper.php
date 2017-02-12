<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 07/02/2017
 * Time: 15:19
 */
namespace Persistance;

use Model\Business\User;

class UserMapper
{
    private $con;

    public function __construct($con)
    {
        $this->con=$con;
    }

    public function persist($user)
    {
        $request = 'INSERT into Users(login, password) VALUES (:login,:password)';

        return $this->con->prepareAndExecuteQuery($request,
            array(
                'login'=>$user->getLogin(),
                'password'=>$user->getPassword()
            ));
    }
}
