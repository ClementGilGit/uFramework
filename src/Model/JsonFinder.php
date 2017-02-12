<?php

namespace Model;

class JsonFinder implements FinderInterface
{
    private $data;
    //private $jsonFile = 'C:\wamp\www\php\uframework\php-practicals-ufw\src\Model\data\statuses.json';
    private $jsonFile = __DIR__.'/data/statuses.json';
    
    public function __construct()
    {
        $this->data = json_decode(file_get_contents($this->jsonFile), true);

        if (empty($this->data)) {
            $this->data['tweets'] = array();
        }
    }


    public function findAll($criterion)
    {
        return $this->data;
    }


    public function findOneById($id)
    {
        foreach ($this->data['tweets'] as $status) {
            if ($status['id']==$id) {
                return $status;
            }
        }
        return null;
    }
    
    public function add($user, $message)
    {
        $id = $this->getMaxIdOfStatuses()+1;
        array_push($this->data['tweets'], array("id"=>$id,"content" => array("message"=>$message,"username"=>$user)));
                
        file_put_contents($this->jsonFile, json_encode($this->data));
    }

    public function delete($tweetId)
    {
        $statusId = array_search($tweetId, array_column($this->data['tweets'], 'id'));
        unset($this->data['tweets'][$statusId]);

        $this->data['tweets'] = array_values($this->data['tweets']);
        file_put_contents($this->jsonFile, json_encode($this->data));
    }
    
    
    public function getMaxIdOfStatuses()
    {
        $max = 0;
        foreach ($this->data['tweets'] as $status) {
            if ($status['id'] > $max) {
                $max = $status['id'];
            }
        }
        return $max;
    }

    public function findOneByLogin($login)
    {
        // TODO: Implement findOneByLogin() method.
    }
}
