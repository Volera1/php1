<?php
//require_once "TwigBaseController.php"; // импортим TwigBaseController
require_once "BaseCharTwigController.php";
class MainController extends BaseCharTwigController {
    public $template = "main.twig";
    public $title = "Главная";
    
    // public $menu = [ // добавил список словариков
    //     [
    //         "title" => "Главная",
    //         "url" => "/",
    //     ],
    //     [
    //         "title" => "Фолыч",
    //         "url" => "/fal",
    //     ],
    //     [
    //         "title" => "ДнД",
    //         "url" => "/dnd",
    //     ]

    // ];


    public function getContext() : array
    {
        $context = parent::getContext(); // вызываем родительский метод
        $context['menu'] = $this->menu; // добавляем title в контекст

        if (isset($_GET['type'])){
            $querytext="SELECT * FROM char_table where type like '%typetoq%'";
            $querytext = preg_replace("<typetoq>",$_GET['type'],$querytext);
            $query = $this->pdo->prepare($querytext);
            
            //$query->bindValue("type",$_GET['type']);
            
            $query->execute();
        }
        else{ 
            $query = $this->pdo->query("SELECT * FROM char_table");
        }
        
         // стягиваем данные через fetchAll() и сохраняем результат в контекст
        $context['characters'] = $query->fetchAll();


        return $context;
    }
}