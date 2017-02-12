<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 02/02/2017
 * Time: 10:33
 */
namespace Persistance;

use PDO;

class Connection extends PDO
{
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    private $statement;

    public function __construct($dsn, $username, $passwd)
    {
        parent::__construct($dsn, $username, $passwd);
    }

    public function prepareAndExecuteQuery($query, array $parameters = [])
    {
        $this->statement = $this->prepare($query);
        return $this->statement->execute($parameters);
    }

    public function getResult()
    {
        return $this->statement->fetchAll();
    }

    public function destroyQuery()
    {
        $this->statement->closeCursor();
        $this->statement=null;
    }
}
