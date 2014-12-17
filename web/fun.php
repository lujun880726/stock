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
    $url  = "http://bdcjhq.hexun.com/quote?s2=" . $stockId . "." . $stockTYpe;
    $data = '';
    $data = file_get_contents($url);
    if (empty($data)) {
        return -1;
    }
    $strInfo  = getStr($data, 'bdcallback(', ')}');
    $tmp      = explode(":", $strInfo);
    $name     = str_replace(array('",pc', '"'), '', $tmp['2']);
    $open     = str_replace(array('",vo', '"'), '', $tmp['4']);
    $top      = str_replace(array('",lo', '"'), '', $tmp['7']);
    $footer   = str_replace(array('",la', '"'), '', $tmp['8']);
    $harvest  = str_replace(array('",type', '"'), '', $tmp['9']);
    $vol      = str_replace(array('",tu', '"'), '', $tmp['5']);
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
    );
    return $dayArr;
}