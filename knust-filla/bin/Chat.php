<?php
/**
 * Created by PhpStorm.
 * User: SANSON ROOT
 * Date: 3/26/2016
 * Time: 11:32 AM
 */


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $_clients;

    public function __construct()
    {
        $this->_clients = new SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $connectionInterface)
    {

        $this->_clients->attach(new ChatConn($connectionInterface));
        $number = $this->countClients();

        foreach($this->_clients as $client){
            $client->getConnection()->send($this->encode(array(
                'action'=>'online',
               // 'list'=>$this->getClientsConnected(),
                'number'=>$number
            )));
        }
    }

    public function onMessage(ConnectionInterface $connectionInterface, $msg)
    {
        $data=$this->parseMsg($msg);
        //$username=$data->name;
        $state=$data->action;
//        if(isset($username)&& !empty($username)){
//            foreach($this->_clients as $client){
//                if(!$client->getName()===$username && $client->getConnection()==$connectionInterface){
//                    $client->setName($username);
//                }
//            }
//
//        }
        if(isset($state) && $state==='typing'){
            $name=$data->name;
            foreach ($this->_clients as $client) {
                if ($client->getConnection() !== $connectionInterface) {
                    $client->getConnection()->send($this->encode(array(
                        'action'=>'typing',
                        'name'=>$name
                    )));
                }
            }
        }else if(isset($state) && $state==='message'){
            $message=$data->msg;
            $name=$data->name;
            foreach ($this->_clients as $client) {
                if ($client->getConnection() !== $connectionInterface && $msg!=="") {
                    $client->getConnection()->send($this->encode(array(
                        'action'=>'message',
                        'name'=>$name,
                        'msg'=>$message
                    )));
                }
            }
        }



    }

    private function countClients()
    {
        return $this->_clients->count();
    }

    private function parseMsg($msg)
    {
        return json_decode($msg);
    }

    private function encode($data = array())
    {
        return json_encode($data);
    }

    public function onClose(ConnectionInterface $connectionInterface)
    {
        foreach($this->_clients as $client){
            if($client->getConnection()===$connectionInterface){
                $this->_clients->detach($client);
            }
        }

        $number = $this->countClients();

        foreach($this->_clients as $client){
            $client->getConnection()->send($this->encode(array(
                'action'=>'online',
                //'list'=>$this->getClientsConnected(),
                'number'=>$number
            )));
        }
    }

    public function onError(ConnectionInterface $connectionInterface, Exception $e)
    {
        echo 'Error occurred ' . $e->getMessage();
        $connectionInterface->close();
    }
    public function getClientsConnected(){
        $list=array();
        $counter=0;
        foreach($this->_clients as $client){
            $list[$counter++]=$client->getName();
        }
        return $list;
    }
}