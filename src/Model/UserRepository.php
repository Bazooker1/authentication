<?php

namespace User\DantegaComposer\Model;
class UserRepository
{
    public $users = array();
    public $map;
    public function __construct()
    {
        $this->map = new UserMapper();
        $this->users = $this->map->All();
    }
    //получение всех записей
    function getAll(){
        return $this->map;
    }
    //фильтрация по полям
    function checkLoginPass($login, $pass){
        foreach ($this->users as $user){
            if($user->login==$login && $user->password==md5($pass.User::salt)){
                setcookie('token', md5($pass.User::salt));
                setcookie('login', $user->login);
                return true;
            }
        }
        return false;
    }

    function checkIsLogged(){
        foreach ($this->users as $user){
            if($user->login==$_COOKIE['login'] && $user->password==$_COOKIE['token']){
                return true;
            }
        }
        return false;
    }

    //поиск по id
    function findById($id){
        foreach ($this->users as $user){
            if($user->id == $id){
                return $user;
            }
        }
        return null;
    }
    //сохранение
    function add($login, $pass){
        $this->map->add($login, md5($pass.User::salt));
        $this->users=$this->map->All();
    }
    //удаление
    function deleteById($id, $pass){
        $this->map->del($id, $pass);
        $this->users=$this->map->All();
    }
}