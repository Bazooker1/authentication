<?php

namespace User\DantegaComposer\Controller;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use User\DantegaComposer\Model\Message;
use User\DantegaComposer\Model\UserRepository;

class ChatController
{
    public function __construct()
    {
    }
    function ToFile($json, $file)
    {
        $filemessage = json_decode(file_get_contents($file));
        $filemessage->messages[] = $json;
        file_put_contents($file, json_encode($filemessage));
        header('Location: /');
    }

    function PrintMessages()
    {
        $message = new Message();
        $messages=$message->getAll();
        $loader = new FilesystemLoader(dirname(__DIR__, 2)."/templates/");
        $twig = new Environment($loader);
        $template = $twig->load('table.html.twig');
        echo ($template->render(['message'=>$messages]));
    }

    function SendMessage()
    {
        $file = __DIR__ . '/storage.json';
        $password = $_POST['password'];
        $message = $_POST['message'];
        $login = $_POST['login'];
        $mes = new Message();
        $up = new UserRepository();
        if ($up->checkLoginPass($login, $password))
        {
                $mes->save($_POST['login'],$_POST['message']);
                header("Location: localhost");
            }
            else
            {
                print("Неверный логин или пароль");
            }

    }

}