<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 3/27/2016
 * Time: 9:43 PM
 */
use Ratchet\ConnectionInterface;

class ChatConn{

    private $_username,
            $_connection;

    public function __construct(ConnectionInterface $conn,$name=""){
        $this->_connection=$conn;
        $this->_username=$name;
    }

    public function getConnection(){
        return $this->_connection;
    }
    public function setName($name){
        if($name!==""){
            $this->_username=$name;
        }
    }
    public function getName(){
        return $this->_username;
    }


}