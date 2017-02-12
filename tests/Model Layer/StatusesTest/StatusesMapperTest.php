<?php

/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 06/02/2017
 * Time: 11:08
 */
namespace ModelLayer\StatusesTest;

use Persistance\StatusesMapper;
use Model\Business\Status;
use TestCase;
use PDO;

class StatusesMapperTest extends TestCase
{

    private $con;

    public function setUp()
    {
        $this->con=new \Persistance\Connection("sqlite::memory:", "", "");
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->con->exec(<<<SQL
        CREATE TABLE IF NOT EXISTS Statuses(
          id INT(11) PRIMARY KEY ,
          username varchar(255) NOT NULL,
          content varchar(255),
          date DATETIME
        );
SQL
        );
    }

    public function testPersist()
    {
        $statusesMapper = new StatusesMapper($this->con);
        $status = new Status(null, "toto", "ceci est le contenu", date("Y/m/d H:i:s"));
        $row=$this->con->query('SELECT COUNT(*) FROM Statuses')->fetch(PDO::FETCH_NUM);
        $this->assertEquals(0, $row[0]);
        $statusesMapper->persist($status);
        $row=$this->con->query('SELECT COUNT(*) FROM Statuses')->fetch(PDO::FETCH_NUM);
        $this->assertEquals(1, $row[0]);
    }

    public function testRemove()
    {
        $statusesMapper = new StatusesMapper($this->con);
        $status = new Status(1, "toto", "ceci est le contenu", date("Y/m/d H:i:s"));
        $this->assertEquals(1, $statusesMapper->persist($status));
        $this->assertEquals(1, $statusesMapper->remove($status));
    }

}