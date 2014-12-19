<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_stock extends m_mabstract
{

    function getStock($stockId)
    {
        return $this->db->get_one("select * from stock where  stock_id = '{$stockId}' ");
    }

}
