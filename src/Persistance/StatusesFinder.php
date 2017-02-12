<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 02/02/2017
 * Time: 10:51
 */
namespace Persistance;

use Model\Business\Status;

class StatusesFinder implements \Model\FinderInterface
{
    private $con;

    public function __construct(Connection $con)
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
        !empty($criterion['orderBy'])
            ?$criterion['orderBy']='ORDER BY '.$criterion['orderBy']
            :$criterion['orderBy']='ORDER BY id ASC';

        !empty($criterion['limit'])
            ?$criterion['limit']='LIMIT '.$criterion['limit']
            :$criterion['limit']='';

        $request = 'SELECT * FROM Statuses '.$criterion['orderBy'].' '.$criterion['limit'];
        $this->con->prepareAndExecuteQuery($request);
        $result = $this->con->getResult();
        $this->con->destroyQuery();

        $statuses = array();

        foreach ($result as $row) {
            $status = new Status($row['id'], $row['username'], $row['content'], $row['date']);
            array_push($statuses, $status);
        }

        return $statuses;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        $request = 'SELECT * FROM Statuses WHERE Id=:id';
        $this->con->prepareAndExecuteQuery($request, array('id'=>$id));
        $result = $this->con->getResult();
        $this->con->destroyQuery();
        $status = new Status($result[0]['id'], $result[0]['username'], $result[0]['content'], $result[0]['date']);
        return $status;
    }

    public function findOneByLogin($login)
    {
        // TODO: Implement findOneByLogin() method.
    }
}
