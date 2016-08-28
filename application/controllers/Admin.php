<?php

class AdminController extends ApplicationController 
{
    private $page_size = 20;
    protected $layout = 'backend';

    public function IndexAction() {

    }

    public function ArticleAction() {
        $keywords = $this->getRequest()->getParam("keywords");
        $page = $this->getRequest()->getParam("page",0);

        $novel = new NovelModel();
        $sql = "select * from xy_novel where name like '%$keywords%' limit $page,".$this->page_size;
        $this->novels = $novel->query($sql);
    }
}
