<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_attentiontype extends c_cabstract
{

    public function indexAction()
    {
        $err = '';
        $row = array();
        $obj = m('m_attentiontype');
        if ($this->isPost()) {
            $attentionName = trim($_POST['attention_name']);
            $explain       = trim($_POST['explain_co']);
            $id            = (int) @$_POST['id'];
            if ($id > 0) {
                $obj->uInfo(array('attention_name' => $attentionName, 'explain_co' => $explain), $id);
            } else {
                $obj->add(array('attention_name' => $attentionName, 'explain_co' => $explain));
            }
        } else {
            $id = $this->getInt(0);
            if ($id > 0) {
                $row = $obj->getOne($id);
            }
        }
        $list = $obj->getList();
        return array('err' => $err, 'list' => $list, 'row' => $row);
    }

}
