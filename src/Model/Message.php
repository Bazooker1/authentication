<?php
namespace User\DantegaComposer\Model;
use PDO;
class Message
{
    public $id;
    public $text;
    public $name;
    public $bd;
    function __construct(){
        $this->bd = new PDO('mysql:host=127.0.0.1;dbname=chat', 'root', 'zxczxczxc');
    }
    public function getAll(){
        $query = 'SELECT * from message';
        $connect = $this->bd->prepare($query);
        $connect->execute();
        return $connect->fetchAll();
    }
    public function getId($id){
        $sel = 'SELECT * from message WHERE id=:id';
        $connect = $this->bd->prepare($sel);
        $connect->bindParam('id', $id);
        $connect->execute();
        return $connect->fetchAll();
    }
    public function getName($name)
    {
        $sel = 'SELECT * from message WHERE name=:name';
        $connect = $this->bd->prepare($sel);
        $connect->bindParam('name', $name);
        $connect->execute();
        return $connect->fetchAll();
    }
    public function delete($id){
        $sel = 'DELETE FROM `chat`.`message` WHERE id=:id;';
        $connect = $this->bd->prepare($sel);
        $connect->bindParam('id', $id);
        $connect->execute();
    }
    public function save($name, $text){
        $sel = 'INSERT INTO `chat`.`message` (`name`,`text`) VALUES (:name, :text);';
        $connect = $this->bd->prepare($sel);
        $connect->bindParam('name', $name);
        $connect->bindParam('text', $text);
        $connect->execute();
    }
}