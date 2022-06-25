<?php

namespace User\DantegaComposer\Model;
use PDO;

class UserMapper
{
    private $PDO;
    public function __construct()
    {
        $this->PDO=new PDO('mysql:host=127.0.0.1;dbname=chat', 'root', 'zxczxczxc');
    }
    public function All(){
        $sql = "SELECT * FROM chat.user;";
        $s=$this->PDO->prepare($sql);
        $s->execute();
        $results=$s->fetchAll();
        $all = array();
        foreach ($results as $result){
            $us = new User();
            $us->login=$result['login'];
            $us->password=$result['password'];
            $us->id=$result['id'];
            array_push($all, $us);
        }
        return $all;
    }
    function add($login, $pass){
        $sql = "INSERT INTO chat.user (login, password) VALUES (:login, :pass);";
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->execute();
    }
    function del($id, $pass){
        $sql = 'DELETE FROM chat.user WHERE (login = :id AND password=:pass);';
        $stmt = $this->PDO->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->execute();
    }
}