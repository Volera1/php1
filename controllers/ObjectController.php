<?php

class ObjectController extends BaseCharTwigController
{
    public $template = "object.twig"; // указываем шаблон

    public function getContext(): array
    {
        $context = parent::getContext();

        // готовим запрос к БД, допустим вытащим запись по id=3
        // тут уже указываю конкретные поля, там более грамотно
        $query = $this->pdo->prepare("SELECT description, id,title,image,info FROM char_table WHERE id= :my_id");
        // стягиваем одну строчку из базы
        $query->bindValue("my_id", $this->params['id']);
        $query->execute();
        $data = $query->fetch();

        // передаем описание из БД в контекст
        $context['description'] = $data['description'];
        $context['title'] = $data['title'];
        $context['image'] = $data['image'];
        $context['url_prefix'] = $data['id'];
        $context['info'] = $data['info'];
        $context["messages"] = isset($_SESSION['messages']) ? $_SESSION['messages'] : "";

        if (isset($_GET['show'])) {
            $context['is_info'] = preg_match("#info#", $_GET['show']);
            $context['is_image'] = preg_match("#image#", $_GET['show']);
        } else {
            $context['is_info'] = false;
            $context['is_image'] = false;
        }
        if ($context['is_image']){
            $context['template'] = "image.twig";
        }

        return $context;
    }
}
