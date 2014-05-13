<?php

$objBase = m('m_base');


//添加每天新的股票
$page = 100;$page = 0;
$url  = 'http://stock.gtimg.cn/data/index.php?appn=rank&t=ranka/chr&o=0&l=80&v=list_data&p=';
for ($i = 1; $i <= $page; $i++) {
    $endUrl = $url . $i;
    $data   = file_get_contents($endUrl);

    if (1 == $i) {
        $page = getStr($data, 'total:', ',');
    }
    $idStr = getStr($data, "data:'", "'");

    $tmp = explode(',', $idStr);
    if ($tmp) {
        foreach ($tmp as $val) {
            $type     = substr($val, 0, 2);
            $stock_id = substr($val, 2, 8);
            $arr      = $objBase->db->get_one("select stock_id from `stock` where stock_id = '{$stock_id}'");
            if (empty($arr)) {
                $objBase->db->insert('stock', array('stock_id' => $stock_id, 'type' => $type, 'create_time' => time()));
            }
        }
    }
}

// 每天的收盘信息 停盘不记录
$list = $objBase->db->get_all("select * from `stock` where 1");
foreach ($list as $val){
    $url = "http://qt.gtimg.cn/r=0.23181622646317246q=marketStat,stdunixtime," . $val['type'].$val['stock_id'].",";
    $url = "http://qt.gtimg.cn/0.694636271243858q=sh600160,s_pksh600160";

    $data = file_get_contents($url);
    print_r($data);exit;
}
var_dump($list);exit;

// 星期五做周信息



// 有底做月信息
