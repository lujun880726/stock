<?php

include '../../web/init.php';

$objBase = m('m_base');


//添加每天新的股票
$page = 100;
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
foreach ($list as $val) {
    $url = "http://qt.gtimg.cn/r=" . (0.28181632646317246 + '0.' . rand(1, 999999999)) . "q=marketStat,stdunixtime,sh600432,";
    $data = '';
    $data = file_get_contents($url);
    if(empty($data)){
        sleep(5);
        $data = file_get_contents($url);
    }
    if (empty($data)){
        file_put_contents(date('Y-m-d') . '.log', $val['stock_id']."\r\n", FILE_APPEND);
        continue;
    }

    $tmp  = explode('~', $data);
    if (!$val['name']) {
        $objBase->db->update('stock', array('name' => $tmp[1]), "stock_id = '" . $val['stock_id'] . "'");
    }
    $dayArr = array(
        'stock_id'  => $val['stock_id'],
        'type'      => $val['type'],
        'day_time'  => date('Ymd'),
        'week_time' => date('YW'),
        'mon_time'  => date('Ym'),
        'year_time' => date('Y'),
        'open'      => $tmp[5],
        'top'       => $tmp[33],
        'footer'    => $tmp[34],
        'harvest'   => $tmp[3],
        'vol'       => $tmp[6],
    );

    $objBase->db->insert('day_harvest_info', $dayArr);
}

// 星期五做周信息



// 有底做月信息
