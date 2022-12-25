<?php
// подключаем пакеты которые установили через composer
require_once '../vendor/autoload.php';
require_once "../framework/autoload.php";
require_once "../controllers/MainController.php"; // добавим в самом верху ссылку на наш контроллер

require_once "../controllers/Controller404.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/CreateController.php";
require_once "../controllers/CreateTypeController.php";
require_once "../controllers/DeleteController.php";
require_once "../controllers/UpdateController.php";
require_once "../middlewares/SetWelcomeMiddleware.php";
require_once "../middlewares/LoginRequiredMiddleware.php";

// создаем загрузчик шаблонов, и указываем папку с шаблонами
// \Twig\Loader\FilesystemLoader -- это типа как в C# писать Twig.Loader.FilesystemLoader, 
// только слеш вместо точек
$loader = new \Twig\Loader\FilesystemLoader('../views');

// создаем собственно экземпляр Twig с помощью которого будет рендерить
$twig = new \Twig\Environment($loader, [
  "debug" => true // добавляем тут debug режим
]);
$twig->addExtension(new \Twig\Extension\DebugExtension()); // и активируем расширение


//$url = $_SERVER["REQUEST_URI"];
$pdo = new PDO("mysql:host=localhost;dbname=characters;charset=utf8", "root", "");
// $query = $pdo->query("SELECT DISTINCT type FROM char_table ORDER BY 1");
// // стягиваем данные
// $types = $query->fetchAll();
// // создаем глобальную переменную в $twig, которая будет достпна из любого шаблона
// $twig->addGlobal("types", $types);

$router = new Router($twig, $pdo);
session_set_cookie_params(60*60*10);
        session_start();
//$router->add("/set-welcome/", SetWelcomeController::class);
$router->add("/", MainController::class)->middleware(new SetWelcomeMiddleware());;
$router->add("/search", SearchController::class)->middleware(new SetWelcomeMiddleware());;
$router->add("/char/(?P<id>\d+)", ObjectController::class)->middleware(new SetWelcomeMiddleware());;

//$router->add("/char/(?P<id>\d+)/image", ImageController::class); 
//$router->add("/char/(?P<id>\d+)/info", ObjectController::class); 

$router->add("/char/create", CreateController::class)->middleware(new LoginRequiredMiddleware())->middleware(new SetWelcomeMiddleware());;
$router->add("/type/create", CreateTypeController::class)->middleware(new LoginRequiredMiddleware())->middleware(new SetWelcomeMiddleware());;
$router->add("/char/delete", DeleteController::class)->middleware(new LoginRequiredMiddleware())->middleware(new SetWelcomeMiddleware());;
$router->add("/char/(?P<id>\d+)/edit", UpdateController::class)->middleware(new LoginRequiredMiddleware())->middleware(new SetWelcomeMiddleware());;



$router->get_or_default(Controller404::class);









// ЭТО ВСЕ УЖЕ НЕ НУЖНО
// $title = "";
// $template = "";
// $image = "";
// $url_prefix = "";
//$context = [];
//$controller = new Controller404($twig); // теперь 404 будут нашем контроллером по умолчанию
// тут теперь просто заполняю значение переменных
// if ($url == "/") {
  //$title = "Главная";
  //$template = "main.twig";
  // $controller = new MainController($twig);
// } elseif (preg_match("#/rudolf/image#", $url)) {
//   //$template = "image.twig";
//   $controller = new RudolfImageController($twig);
// } elseif (preg_match("#/rudolf/info#", $url)) {
//   //$template = "/characters/rudolf.twig";  
//   $controller = new RudolfInfoController($twig);
// } elseif (preg_match("#/rudolf#", $url)) {
//   //$title = "Рудольф";
//   // $template = "/characters/rudolf.twig";
//   // $url_prefix="rudolf";
//   // $image = "/images/rudolfcube.png";
//   $controller = new RudolfController($twig);
// } elseif (preg_match("#/jessie/image#", $url)) {
//     //$template = "image.twig";
//     $controller = new JessyImageController($twig);
//   }
//   elseif (preg_match("#/jessie/info#", $url)) {
//     //$template = "/characters/jessie.twig";
//     $controller = new JessyInfoController($twig);
//   }
//   elseif (preg_match("#/jessie#", $url)) {
//   // $title = "Джесси";
//   // $template = "/characters/jessie.twig";
//   // $url_prefix = "jessie";
//   // $image = "/images/jessycube.png";
//   $controller = new JessyController($twig);
//  }
// if ($controller) {
//   $controller->setPDO($pdo); // а тут передаем PDO в контроллер
//   $controller->get();
// } 

// $context['url']=$url;
// $context['url_prefix']=$url_prefix;
// $context['image'] = $image;
// $context['title'] = $title;
// $context['menu'] = $menu;


// // рендеринг делаем один раз по заполненным переменным
// echo $twig->render($template, $context);
// if ($controller) {
//   $controller->get();
// }
