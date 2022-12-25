<?php
class SetWelcomeMiddleware extends BaseMiddleware
{
    public function apply(BaseController $controller, array $context) 
    {
        $url = $_SERVER['REQUEST_URI'];
        $_SESSION['welcome_message'] = $url;
        
        // проверяем существует ли значение messages в списке
        if (!isset($_SESSION['messages'])) {
            // если пустое, инициализируем его пустым списком
            $_SESSION['messages'] = [];
        }
        // добавляем в список сообщений, введенное сообщение
        array_unshift($_SESSION['messages'],$url);
        $_SESSION['messages']=array_slice($_SESSION['messages'], 0, 5);
        
    }
}
