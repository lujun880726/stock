<?php

set_time_limit(0);

file_put_contents(date('Y-m-d') . '.log', '----'.date('Y-m-d').'begin---' . "\r\n", FILE_APPEND);


include '../../web/init.php';

$objBase = m('m_base');
 file_put_contents(date('Y-m-d') . '.log', 'new stock begin---' .time().  "\r\n", FILE_APPEND);
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
    sleep(2);
}
 file_put_contents(date('Y-m-d') . '.log', 'new stock end---' .time(). "\r\n", FILE_APPEND);


 file_put_contents(date('Y-m-d') . '.log', 'getDayInfoFromHeXun -begin---'.time().  "\r\n", FILE_APPEND);
getDayInfoFromHeXun();
 file_put_contents(date('Y-m-d') . '.log', 'getDayInfoFromHeXun -end---'.time().  "\r\n", FILE_APPEND);


  file_put_contents(date('Y-m-d') . '.log', 'call pro -begin---'.time().  "\r\n", FILE_APPEND);
//存储过程计算与上一个交易的比值
$objBase->db->get_all("call stock_day_stock_vol(" . date('Ymd') . ");");
  file_put_contents(date('Y-m-d') . '.log', 'call pro -end---'.time().  "\r\n", FILE_APPEND);

// 星期五做周信息
// 月底做的信息

file_put_contents(date('Y-m-d') . '.log', '----'.date('Y-m-d').'end---' . "\r\n", FILE_APPEND);

function getDayInfoFromHeXun()
{
    global $objBase;
    // 每天的收盘信息 停盘不记录
    $list = $objBase->db->get_all("select * from `stock` where 1");
    foreach ($list as $val) {
        $url  = "http://bdcjhq.hexun.com/quote?s2=" . $val['stock_id'] . "." . $val['type'];
        $data = '';
        $data = file_get_contents($url);
        if (empty($data)) {
            sleep(5);
            $data = file_get_contents($url);
        }
        if (empty($data)) {
            file_put_contents(date('Y-m-d') . '.log', $url . "\r\n", FILE_APPEND);
            continue;
        }
        $strInfo = getStr($data, 'bdcallback(', ')}');
        $tmp     = explode(":", $strInfo);
        $name = str_replace(array('",pc', '"'), '', $tmp['2']);
        if (!$val['name']) {

            $objBase->db->update('stock', array('name' => iconv("GB2312", "utf-8", $name)), "stock_id = '" . $val['stock_id'] . "'"); //
        }
        $open    = str_replace(array('",vo', '"'), '', $tmp['4']);
        $top     = str_replace(array('",lo', '"'), '', $tmp['7']);
        $footer  = str_replace(array('",la', '"'), '', $tmp['8']);
        $harvest = str_replace(array('",type', '"'), '', $tmp['9']);
        $vol     = str_replace(array('",tu', '"'), '', $tmp['5']);
        if ($open < 1) {
            continue;
        }
        $tempTIme = explode(' ', str_replace(array('"', '"'), '', $tmp['11']));
        if (strtotime($tempTIme[0]) != strtotime('today'))
        {
            continue;
        }
        $dayArr = array(
            'stock_id'  => $val['stock_id'],
            'type'      => $val['type'],
            'day_time'  => date('Ymd'),
            'week_time' => date('YW'),
            'mon_time'  => date('Ym'),
            'year_time' => date('Y'),
            'open'      => $open,
            'top'       => $top,
            'footer'    => $footer,
            'harvest'   => $harvest,
            'vol'       => $vol,
        );
        $objBase->db->insert('day_harvest_info', $dayArr);
        sleep(2);
    }
}

function getDayInfoFromQQ()
{
    global $objBase;
    // 每天的收盘信息 停盘不记录
    $list = $objBase->db->get_all("select * from `stock` where 1");
    foreach ($list as $val) {
        $url  = "http://qt.gtimg.cn/r=" . (0.28181632646317246 + '0.' . rand(1, 999999999)) . "q=marketStat,stdunixtime," . $val['type'] . $val['stock_id'] . ",";
        $data = '';
        $data = file_get_contents($url);
        if (empty($data)) {
            sleep(5);
            $data = file_get_contents($url);
        }
        if (empty($data)) {
            file_put_contents(date('Y-m-d') . '.log', $url . "\r\n", FILE_APPEND);
            continue;
        }

        $tmp = explode('~', $data);
        if (!$val['name']) {
            $objBase->db->update('stock', array('name' => iconv("GB2312", "utf-8", $tmp[1])), "stock_id = '" . $val['stock_id'] . "'"); //
        }
        if ($tmp[6] < 1) {
            continue;
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
        sleep(5);
    }
}
