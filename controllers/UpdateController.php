<?php
require_once "BaseCharTwigController.php";

class UpdateController extends BaseCharTwigController
{
    public $template = "create.twig";
    public function getContext() : array // добавили параметр
    {
        $context = parent::getContext();
        $id = $this->params['id']; // взяли id
        // parent::get($context); // пробросили параметр
        $sql = <<<EOL
        select * from char_table where id=:id
        EOL;
                // подготавливаем запрос к БД
                $query = $this->pdo->prepare($sql);
                // привязываем параметры
                $query->bindValue("id", $id);
                $query->execute();
                $data=$query->fetch();
                $context['object']=$data;
                return $context;
    }

    public function post(array $context)
    {// добавили параметр
        // получаем значения полей с формы
        $id = $_GET['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $info = $_POST['info'];
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
update char_table set title=:title, description=:description, type=:type, info=:info, image=:image_url
WHERE id = :id 
EOL;
        // подготавливаем запрос к БД
        $query = $this->pdo->prepare($sql);
        // привязываем параметры
        $query->bindValue("id", $id);
        $query->bindValue("title", $title);
        $query->bindValue("description", $description);
        $query->bindValue("type", $type);
        $query->bindValue("info", $info);
        $query->bindValue("image_url", $image_url);
       
        // выполняем запрос
        $query->execute();

        $context['title']="Добавить";
        $context['message'] = 'Вы успешно отредачили объект '; // добавили сообщение
        // $context['id'] = $this->pdo->lastInsertId(); // получаем id нового добавленного объекта
        $this->get($context); // пробросили параметр
    }
}