<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_attentiontype extends m_mabstract
{

    public function add($strArr)
    {
        $strArr['ctime'] = strtotime("today");
        $tmp             = $this->db->insert('attention_type', $strArr);
        return $tmp;
    }

    public function getList()
    {
        return $this->db->get_all('select * from attention_type  where 1');
    }

    public function getOne($id)
    {
        return $this->db->get_one("select * from attention_type  where id = {$id} ");
    }

    public function uInfo($strArr, $id)
    {
        $this->db->update('attention_type', $strArr, " id = {$id}");
    }

    public function listKV()
    {
        $tmp = $this->getList();
        $res = array();
        if ($tmp) {
            foreach ($tmp as $val) {
                $res[$val['id']] = $val['attention_name'];
            }
        }
        return $res;
    }

//    public function del($stockId)
//    {
//          return $this->db->delete('my_attention_stock', "stock_id = '{$stockId}'");
//    }
}
