<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
require_once dirname(__DIR__).'/vendor/autoload.php';
$controller = new \User\DantegaComposer\Controller\ChatController();
$message = new \User\DantegaComposer\Model\Message();
$uri = $_SERVER['REQUEST_URI'];
$up = new \User\DantegaComposer\Model\UserRepository();
//var_dump($up->checkIsLogged());
//var_dump($up->users);
switch ($uri){
    case '/send':
    {
        $controller->SendMessage();
        break;
    }
    case '/logout':
    {
        setcookie('login', '', time()-36000);
        setcookie('token', '', time()-36000);
        header("Location: ");
        break;
    }
    case '/delUS':
    {
        $up->deleteById($_POST['login'], $_POST['password']);
        header("Location: ");
        break;
    }
    case '/findus':
    {
        echo ("Пользователь: ".$up->findById($_POST['id'])->login);
        //header("Location: http://localhost");
        break;
    }
    case '/reg':
    {
        $up->add($_POST['login'], $_POST['password']);
        header("Location: ");
        break;
    }
    default:
    {
        $controller->PrintMessages();
        break;
    }
}
$messages=$message->getAll();
$loader = new FilesystemLoader(dirname(__DIR__, 1)."/templates/");
$twig = new Environment($loader);
$template = $twig->load('index.html.twig');
echo ($template->render(['logged'=>$up->checkIsLogged()]));
if($up->checkIsLogged()){
    if (isset($_POST['allMessages'])){
        $template = $twig->load('table.html.twig');
        echo ($template->render(['message'=>$messages]));
    }
    if (isset($_POST['getId'])) {
        $template = $twig->load('searchById.html.twig');
        echo($template->render());
    }
    if (isset($_POST['findId'])){
        $messages = $message->getId($_POST['id']);
        $template = $twig->load('table.html.twig');
        echo ($template->render(['message'=>$messages]));
    }
    if (isset($_POST['getName'])){
        $template = $twig->load('searchByName.html.twig');
        echo ($template->render());
    }
    if(isset($_POST['name'])){
        $messages = $message->getName($_POST['getName']);
        $template = $twig->load('table.html.twig');
        echo ($template->render(['message'=>$messages]));
    }
    if (isset($_POST['delete'])){
        $template = $twig->load('delete.html.twig');
        echo ($template->render());
    }
    if (isset($_POST['del'])){
        $message->delete($_POST['delId']);
    }
    if (isset($_POST['save'])){
        $template = $twig->load('save.html.twig');
        echo ($template->render());
    }
    if (isset($_POST['add'])){
        $message->save($_POST['Name'],$_POST['message']);
    }
}
