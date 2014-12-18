<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_attention extends m_mabstract
{

    public function add($strArr)
    {
        $strArr['ctime'] = time();
        $tmp = $this->db->insert('my_attention_stock', $strArr);
        return $tmp;
    }


    public function getList()
    {
        return $this->db->get_all('select a.*,b.name,b.type from my_attention_stock a join stock b on a.stock_id=b.stock_id  where 1 ORDER BY a.id desc');
    }

    public function del($stockId)
    {
          return $this->db->delete('my_attention_stock', "stock_id = '{$stockId}'");
    }
}