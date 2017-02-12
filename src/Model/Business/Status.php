<?php
/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 30/01/2017
 * Time: 14:57
 */

namespace Model\Business;

use DateTime;

class Status implements \JsonSerializable
{
    private $username;
    private $content;
    private $date;

    public function __construct($id, $username, $content, $date, $optional = null)
    {
        $this->id=$id;
        $this->username=$username;
        $this->content=$content;
        $this->date=new DateTime($date);
        $this->optional=$optional;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date->format("Y/m/d H:i:s");
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array("id"=>$this->getId(),"username"=>$this->getUsername(),
                     "content"=>$this->getContent(),"date"=>$this->getDate());
    }
}
