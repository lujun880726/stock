<?php

class c_attention extends c_cabstract
{

    public function indexAction()
    {
        $err      = '';
        $row = array();
        $obj      = m('m_attention');
        $stockObj = m('m_stock');
        if ($this->isPost()) {
            $stockId     = trim($_POST['stock_id']);
            $attentionId = (int) trim($_POST['attention_id']);
            $attentionCo = trim($_POST['attention_co']);

            if ($stockId) {
                $stockInfo = $stockObj->getStock($stockId);
                if (!empty($stockInfo)) {
                    $tmpInfo = getStockAPI($stockInfo['stock_id'], $stockInfo['type']);
                    if ($tmpInfo == -1) {
                        $err = '无法获取请稍后重试';
                    } else {
                        $setArr = array('stock_id' => $stockId, 'attention_price' => $tmpInfo['harvest'], 'attention_id' => $attentionId, 'attention_co' => $attentionCo);
                        $id     = (int) $_POST['id'];
                        if ($id) {
                            $obj->uInfo($setArr, $id);
                        } else {
                            $obj->add($setArr);
                        }
                    }
                } else {
                    $err = '没有此股票';
                }
            }
        } else {
            $stockId = $this->getx(0);
            if ($stockId > 0) {
                $row = $obj->getOne($stockId);
            }
        }

        $list        = $obj->getList();
        $objType     = m('m_attentiontype');
        $typeListTmp = $objType->listKV();

        return array('err' => $err, 'list' => $list, 'typeList' => $typeListTmp,'row' => $row);
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
