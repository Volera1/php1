<?php
class LoginRequiredMiddleware extends BaseMiddleware
{

    public function apply(BaseController $controller, array $context)
    {  // заводим переменные под правильный пароль
        
        // берем значения которые введет пользователь
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
        $q = $controller->pdo->prepare("select username, password from users where (username=:user and password=:password)");
        $q->bindValue("user", $user);
        $q->bindValue("password", $password);
        $q->execute();
        $users = $q->fetch();
        // сoверяем с корректными

        if ($users) {
            
        }
        else{
            // если не совпали, надо указать такой заголовок
            // именно по нему браузер поймет что надо показать окно для ввода юзера/пароля
            header('WWW-Authenticate: Basic realm="Space objects"');
            http_response_code(401); // ну и статус 401 -- Unauthorized, то есть неавторизован
            exit; // прерываем выполнение скрипта
        }
    }
}
