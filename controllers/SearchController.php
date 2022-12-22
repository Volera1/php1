<?php

class SearchController extends BaseCharTwigController
{
    public $template = "search.twig"; // шаблон страницы
    public function getContext() : array
    {
        $context = parent::getContext();
        $type=isset($_GET['type'])?$_GET['type']:'';
        $title=isset($_GET['title'])?$_GET['title']:'';
        $info=isset($_GET['info'])?$_GET['info']:'';

        $sql=<<<EOL
        select id,title,info from char_table
        where (:title='' OR title like CONCAt('%',:title,'%'))
        and (type like CONCAt('%',:type,'%')) 
        and (:info='' OR info like CONCAt('%',:info,'%'))
        EOL;

        $query=$this->pdo->prepare($sql);
        $query->bindValue("title",$title);
        $query->bindValue("type",$type);
        $query->bindValue("info",$info);
        $query->execute();
        $context['objects']=$query->fetchAll();
        $context['title']="Поиск";
        return $context;
    }
}