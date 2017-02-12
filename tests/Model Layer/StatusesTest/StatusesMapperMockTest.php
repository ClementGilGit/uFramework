<?php
/**
 * Created by PhpStorm.
 * User: Rémi
 * Date: 08/02/2017
 * Time: 11:35
 */

namespace ModelLayer\StatusesTest;

use Model\Business\Status;
use Persistance\StatusesMapper;

class StatusesMapperMockTest extends \TestCase
{

    private $mock;

    protected function setUp()
    {
        $this->mock = \Mockery::mock('MockConnection');
    }

    public function testPersistMock()
    {
        $this->mock->shouldReceive('prepareAndExecuteQuery', 'getResult')
            ->andReturn(true);

        $status = new Status(1, 'toto', 'ceci est le contenu', date("Y/m/d H:i:s"));
        $statusMapper = new StatusesMapper($this->mock);
        $this->assertTrue($statusMapper->persist($status));
    }

    public function testRemoveMock()
    {
        $this->mock->shouldReceive('prepareAndExecuteQuery', 'getResult')
            ->andReturn(true);

        $status = new Status(1, 'toto', 'ceci est le contenu', date("Y/m/d H:i:s"));
        $statusMapper = new StatusesMapper($this->mock);
        $this->assertTrue($statusMapper->remove($status));
    }

}