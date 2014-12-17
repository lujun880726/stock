<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_pl extends c_cabstract
{
    public function indexAction()
    {
        $obj = m('m_pl');

        $stockId = $this->getx(0);
        if ($stockId) {
             $list = $obj->getList($stockId);
        } else {
             $list = $obj->getList();
        }
        return array('list' => $list);
    }

}