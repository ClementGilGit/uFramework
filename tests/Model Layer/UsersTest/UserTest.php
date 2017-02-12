<?php
/**
 * Created by PhpStorm.
 * User: Rémi
 * Date: 09/02/2017
 * Time: 14:26
 */

namespace ModelLayer\DataMapper;

use Persistance\Connection;
use Persistance\UserFinder;
use Persistance\UserMapper;
use Model\Business\User;

class UserTest extends \TestCase
{

    private $mock;

    protected function setUp()
    {
        $this->mock = \Mockery::mock('MockConnection');
    }

    public function testPersistMock()
    {
        $this->mock->shouldReceive('prepareAndExecuteQuery', 'getResult')->andReturn(true);
        $user = new User(0, "toto", password_hash("lala", PASSWORD_DEFAULT));
        $userMapper = new UserMapper($this->mock);
        $this->assertTrue($userMapper->persist($user));
    }
}