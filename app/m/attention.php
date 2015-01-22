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
        $strArr['ctime'] = strtotime("today");
        $tmp             = $this->db->insert('my_attention_stock', $strArr);
        return $tmp;
    }

    public function getListSame($con = '')
    {
        return $this->db->get_all('select * from (select a.*,b.name,b.type,count(*) as num from my_attention_stock a join stock b on a.stock_id=b.stock_id  group by stock_id ) as c where c.num >1');
    }

     public function getList($con = '')
    {
        return $this->db->get_all('select a.*,b.name,b.type from my_attention_stock a join stock b on a.stock_id=b.stock_id  where 1 ' . $con. ' ORDER BY a.id desc');
    }

    public function del($stockId)
    {
        return $this->db->delete('my_attention_stock', "stock_id = '{$stockId}'");
    }

    public function uInfo($strArr, $id)
    {
        $this->db->update('my_attention_stock', $strArr, " id = {$id}");
    }

    public function getOne($stockId)
    {
        return $this->db->get_one("select * from my_attention_stock  where stock_id = '{$stockId}' ");
    }

}
