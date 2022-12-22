<?php
require_once "../framework/TwigBaseController.php";
class BaseCharTwigController extends TwigBaseController
{
    public function getContext() : array
    {
        $context = parent::getContext();
        $query = $this->pdo->query("SELECT name FROM types");//
        // стягиваем данные
        $types = $query->fetchAll();
        
        $context['types']=$types;
        return $context;
    }
}
