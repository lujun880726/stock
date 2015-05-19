<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_formula extends c_cabstract {

    public function indexAction() {
        $navTypeId = $this->getx(0);

        $obj = m('m_formula');
        if ($navTypeId < 1) {
            $listTmp = $obj->getListunion();
        } else {
            $listTmp = $obj->getList($navTypeId);
        }
        $list = array();
        if ($listTmp){
            foreach($listTmp as $val)
            {
                $list[$val['create_day']][] =  $val;
            }
        }
        
        return array('err' => '', 'navTypeId' => $navTypeId, 'list' => $list);
    }

    public function addAction() {
        $err = '';
        if ($this->isPost()) {
            $obj = m('m_formula');
            $tmp = explode("\r\n", $_POST['tmplist']);
            if ($tmp) {
                foreach ($tmp as $row) {
                    str_replace(array('代码', '数据来源'), '', $row, $cnt);

                    if ($cnt > 0) {
                        continue;
                    }

                    $tmpRow = explode('	', $row);
                    if ((int) $tmpRow[0] < 1) {
                        continue;
                    }
                    $strArr = array(
                        'stock_id' => $tmpRow[0],
                        'name' => $tmpRow[1],
                        'harvest' => $tmpRow[3],
                        'zf' => $tmpRow[2],
                        'date_type' => (int) $_POST['date_type'],
                    );
                    $obj->add($strArr);
                    $err = '上传成功';
                }
            }
        }
        return array('err' => $err);
    }

}
