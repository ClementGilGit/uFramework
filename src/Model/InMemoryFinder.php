<?php

namespace Model;

class InMemoryFinder implements FinderInterface
{
    private $data;

    public function __construct()
    {
        $this->data = array(
            '1' => array(
            'id' => '1',
            'message' => 'First Tweet OMG',
            'user' => 'Clement_GIL',
            ),
            '2' => array(
            'id' => '2',
            'message' => 'Im at Alestrem',
            'user' => 'Jonny Walker',
            ),);
    }


    public function findAll()
    {
        return $this->data;
    }


    public function findOneById($id)
    {
        if (!array_key_exists($id, $this->data)) {
            return;
        }
        return $this->data[$id];
    }
}
