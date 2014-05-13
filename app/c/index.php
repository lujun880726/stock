<?php

class c_index extends c_cabstract
{

    public function indexAction()
    {
        $listNews = model('news')->getPage(array('news_type' => 1), 0, 8);
        $listJob  = model('news')->getPage(array('news_type' => 2), 0, 8);


        return array('listNews' => $listNews, 'listJob' => $listJob, 'p' => 1);
    }

}
