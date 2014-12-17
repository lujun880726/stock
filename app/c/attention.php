<?php

class c_attention extends c_cabstract
{


    public function indexAction()
    {
        $err      = '';
        $obj      = m('m_attention');
        $stockObj = m('m_stock');
        if ($this->isPost()) {
            $stockId = trim($_POST['stock_id']);
            if ($stockId) {
                $stockInfo = $stockObj->getStock($stockId);
                if (!empty($stockInfo)) {
                    $tmpInfo = getStockAPI($stockInfo['stock_id'], $stockInfo['type']);
                    if ($tmpInfo == -1) {
                        $err = '无法获取请稍后重试';
                    } else {
                        $obj->add(array('stock_id' => $stockId, 'attention_price' => $tmpInfo['harvest']));
                    }
                } else {
                    $err = '没有此股票';
                }
            }
        }

        $list = $obj->getList();

        return array('err' => $err, 'list' => $list);
    }

    public function getNowAction()
    {
        $stockId   = $this->getx(0);
        $stockObj  = m('m_stock');
        $stockInfo = $stockObj->getStock($stockId);
        $tmpInfo   = getStockAPI($stockInfo['stock_id'], $stockInfo['type']);
        $this->jsonx($tmpInfo, 'su');
    }

    public function delAction()
    {
        if ($this->isPost()) {
            $stockId = trim($_POST['stock_id']);
            $obj     = m('m_attention');
            $obj->del($stockId);
            $this->jsonx('删除成功', 'su');
        } else {
            die('err');
        }
    }

}
