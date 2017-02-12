<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 02/02/2017
 * Time: 11:39
 */
namespace Persistance;

use Model\Business\Status;

class StatusesMapper
{
    private $con;

    public function __construct($con)
    {
        $this->con=$con;
    }

    public function persist($status)
    {
        $request = 'INSERT into Statuses(username, content, date) VALUES (:username,:content,:date)';

        return $this->con->prepareAndExecuteQuery($request,
            array(
                'username'=>$status->getUserName(),
                'content'=>$status->getContent(),
                'date'=>$status->getDate()
            ));
    }

    public function remove($status)
    {
        $request = 'DELETE FROM Statuses WHERE Id=:id';

        return $this->con->prepareAndExecuteQuery($request, array('id'=>$status->getId()));
    }
}
