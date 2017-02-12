<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 06/02/2017
 * Time: 11:01
 */
class MockConnection extends \Persistance\Connection
{

    private $statement;

    public function __construct()
    {
    }

    public function prepareAndExecuteQuery($query,array $parameters = [])
    {
        $this->statement = $this->prepare($query);
        return $this->statement->execute($parameters);
    }

    public function getResult()
    {
        return $this->statement->fetchAll();
    }
}