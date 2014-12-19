<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_pl extends m_mabstract
{

    public function getList($stockId = '', $pageSize = 100)
    {
        $sql = 'select a.*,b.name,b.type from stock_pl a join stock b on a.stock_id=b.stock_id  where 1 ';
        if ($stockId) {
            $sql .= " and a.stock_id='{$stockId}'";
        }
        $sql .= 'ORDER BY a.id desc limit ' . $pageSize;

        return $this->db->get_all($sql);
    }

    public function getOne($stockId, $day = '')
    {
        if (empty($day)) {
            $day = strotime('today');
        }
        $sql = "select * from stock_pl  where stock_id = '{$stockId}' ";
        if ($day) {
            $sql .= " and ctime = '{$day}' ";
        }
        $sql .= ' limit 1 ';
        return $this->db->get_one($sql);
    }

}
