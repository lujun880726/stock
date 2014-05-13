<?php

include '../../web/init.php';

$objBase = m('m_base');


//添加每天新的股票
$page = 100;
$page = 0;
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
    $url = "http://qt.gtimg.cn/r=" . (0.28181632646317246 + '0.' . rand(1, 999999999)) . "q=marketStat,stdunixtime,sh600160,";

    $data = file_get_contents($url);
    $data = 'v_marketStat="2014-05-13 17:25:01|HK_close_已收盘|SH_close_已收盘|SZ_close_已收盘|US_close_未开盘|SQ_close_已休市|DS_close_已休市|ZS_close_已休市"; v_stdunixtime="1399973155"; v_sh600160="1~巨化股份~600160~5.80~5.27~5.80~1382253~571110~811144~5.80~5885~5.79~826~5.78~362~5.77~265~5.76~571~0.00~0~0.00~0~0.00~0~0.00~0~0.00~0~14:59:58/5.80/4/S/2320/14575|14:59:58/5.80/39/S/22620/14572|14:59:38/5.80/30/S/17400/14555|14:59:33/5.80/91/S/52780/14549|14:59:28/5.80/240/S/139200/14546|14:59:28/5.80/4/S/1822/14542~20140513150353~0.53~10.06~5.80~5.66~5.80/1381562/796958265~1382253~79736~7.72~1334.36~~5.80~5.66~2.66~103.91~105.03~1.41~5.80~4.74~"; ';

    print_r($data);
    exit;
}
var_dump($list);
exit;

// 星期五做周信息



// 有底做月信息
