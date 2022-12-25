<?php
class SetWelcomeController extends BaseController
{
    public function get(array $context)
    {
        $url = $_SERVER['HTTP_REFERER'];
        $_SESSION['welcome_message'] = $url;
        
        // проверяем существует ли значение messages в списке
        if (!isset($_SESSION['messages'])) {
            // если пустое, инициализируем его пустым списком
            $_SESSION['messages'] = [];
        }
        // добавляем в список сообщений, введенное сообщение
        array_push($_SESSION['messages'],$url);
        
        header("Location: $url");
        exit;
    }
}
