<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 07/02/2017
 * Time: 15:19
 */
namespace Persistance;

use Model\FinderInterface;
use Model\Business\User;

class UserFinder implements FinderInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll($criterion)
    {
        // TODO: Implement findAll() method.
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        // TODO: Implement findOneById() method.
    }

    public function findOneByLogin($login)
    {
        $request = 'SELECT * FROM Users WHERE login=:login';
        $this->con->prepareAndExecuteQuery($request, array('login'=>$login));
        $result = $this->con->getResult();
        if($this->con instanceof Connection){
            $this->con->destroyQuery();
        }

        if (!empty($result)) {
            $user = new User($result[0]['id'], $result[0]['login'], $result[0]['password']);
            return $user;
        }

        return null;
    }
}
