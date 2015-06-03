<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_organization extends c_cabstract {

    public function indexAction() {

        $obj = m('m_organizationviewpoint');
        
        $list = $obj->getList();
              
        return array('err' => '', 'list' => $list);
    }
}