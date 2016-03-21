<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * 获得股票信息
 * @param type $stockId
 * @param type $stockTYpe
 * @return type
 */
function getStockAPI($stockId, $stockTYpe)
{
    $url  = "http://qt.gtimg.cn/q=" . $stockTYpe . $stockId;
    $data = '';
    $data = file_get_contents($url);
    if (empty($data)) {
        return -1;
    }
    $strInfo  = getStr($data, '="', '";');
    $tmp      = explode("~", $strInfo);
    $name     = $tmp['1'];
    $open     = s$tmp['5'];
    $top      = $tmp['33'];
    $footer   = $tmp['34'];
    $harvest  = $tmp['37'];
    $vol      = $tmp['36']);
    $lastprice      = $tmp['3'];
    $tempTIme = explode(' ', str_replace(array('"', '"'), '', $tmp['11']));
    $dayArr   = array(
        'stock_id'  => $stockId,
        'type'      => $stockTYpe,
        'day_time'  => date('Ymd'),
        'week_time' => date('YW'),
        'mon_time'  => date('Ym'),
        'year_time' => date('Y'),
        'open'      => $open,
        'top'       => $top,
        'footer'    => $footer,
        'harvest'   => $harvest,
        'vol'       => $vol,
        'lastprice' => $lastprice,
    );
    return $dayArr;
}
