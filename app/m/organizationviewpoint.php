<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class m_organizationviewpoint extends m_mabstract
{
    
    public function upOrRep($strArr)
    {
        if ($row = $this->db->get_one("select * from organization_viewpoint  where stock_id = '{$strArr['stock_id']}'"))
        {
            if ($strArr['stat_date'] != $row['stat_date']) {
                 $this->db->update('organization_viewpoint', $strArr, " id = {$row['id']}");
            }
        } else {
            $id = $this->db->insert('organization_viewpoint', $strArr);
        }
    }
    
    public function getList()
    {
        return  $this->db->get_all("select * from organization_viewpoint where stat_date >= ".date('Ymd',strtotime('-30 day'))." order by stat_date desc ");
        
    }

}