<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_formula extends m_mabstract
{

    public function add($strArr)
    {
        $strArr['create_time'] = strtotime("today");
        $strArr['create_day'] = date('Y-m-d');
        $tmp             = $this->db->insert('formula_select', $strArr);
        return $tmp;
    }
    
    public function getList($type)
    {
        $tmp = date('Y-m-d',strtotime("-30 day"));
       return $this->db->get_all("select * from formula_select where create_day > '{$tmp}' and date_type = '{$type}'");
    }
    
    public function getListunion()
    {
        
        $tmp = date('Y-m-d',strtotime("-30 day"));
       return $this->db->get_all("select * from (select *,count(*) as num  from formula_select where create_day > '{$tmp}' group by create_day,stock_id  ) as a where num > 1;");
    }
}