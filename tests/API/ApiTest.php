<?php
/**
 * Created by PhpStorm.
 * User: Rémi
 * Date: 10/02/2017
 * Time: 16:30
 */
namespace API;

use Goutte;
use TestCase;

class ApiTest extends TestCase
{
    private $client;
    private $endpoint;

    public function setUp()
    {
        $this->client=new Goutte\Client();
        $this->endpoint = "http://localhost:8080";
    }

    public function testGetStatusTextHtml()
    {
        $this->client->setHeader("Accept", "text/html");
        $this->client->request('GET', sprintf('%s/statuses', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals('text/html;charset=UTF-8', $response->getHeader('Content-Type'));
    }

    public function testPostStatusJson()
    {
        $this->client->setHeader("Accept", "application/json");
        $this->client->setHeader("Content-Type", "application/json");
        $content = array('username'=>'test','content'=>'ceci est le contenu');
        $this->client->request('POST', sprintf('%s/statuses', $this->endpoint), [], [], [], json_encode($content));
        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatus());
        $data = array(json_decode($response->getContent(), true));
        $this->assertArrayHasKey("username", $data[0]);
    }

}