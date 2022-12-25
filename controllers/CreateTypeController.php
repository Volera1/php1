<?php
require_once "BaseCharTwigController.php";

class CreateTypeController extends BaseCharTwigController
{
    public $template = "createtype.twig";
    public function get(array $context) // добавили параметр
    {
        
        parent::get($context); // пробросили параметр
    }

    public function post(array $context)
    { // добавили параметр
        // получаем значения полей с формы
        $name_type = $_POST['name_type'];
        
        // вытащил значения из $_FILES
        $tmp_name = $_FILES['image']['tmp_name'];
        $name =  $_FILES['image']['name'];

        // используем функцию которая проверяет
        // что файл действительно был загружен через POST запрос
        // и если это так, то переносит его в указанное во втором аргументе место
        move_uploaded_file($tmp_name, "../puplic/media/$name");
        $image_url = "/media/$name"; // формируем ссылку без адреса сервера
        // создаем текст запрос
        $sql = <<<EOL
INSERT INTO types(name, image)
VALUES(:name_type, :image_url)
EOL;
        // подготавливаем запрос к БД
        $query = $this->pdo->prepare($sql);
        // привязываем параметры
        $query->bindValue("name_type", $name_type);
        $query->bindValue("image_url", $image_url);
       
        // выполняем запрос
        $query->execute();

        $context['title']="ДобавитьВселенную";
        $context['message'] = 'Вы успешно создали тип '; // добавили сообщение
        $context['id'] = $this->pdo->lastInsertId(); // получаем id нового добавленного объекта
        $this->get($context); // пробросили параметр
    }
}