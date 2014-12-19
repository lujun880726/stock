<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_configinfo extends m_mabstract
{

    function typenavUp($configValStr)
    {
        $sql = "replace into config_info (config_name,config_var) values('typenav','{$configValStr}')";
        return $this->db->query($sql);
    }

    function typenavGet()
    {
        $sql = "  select * from  config_info where config_name = 'typenav' ";
        return $this->db->get_one($sql);
    }

}
