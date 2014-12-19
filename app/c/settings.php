<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_settings extends c_cabstract
{

    public function typenavAction()
    {
        $err         = '';
        $objType     = m('m_attentiontype');
        $configObj   = m('m_configinfo');
        $typeListTmp = $objType->listKV();
        if ($this->isPost()) {
            $typenav = implode(',', $_POST['typenav']);

            $configObj->typenavUp($typenav);
        }
        $tyepnavTmp = $configObj->typenavGet();
        $tyepnav    = explode(',', $tyepnavTmp['config_var']);
        return array('err' => $err, 'typeList' => $typeListTmp, 'tyepnav' => $tyepnav);
    }

}
