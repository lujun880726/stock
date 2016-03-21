<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * http://blog.csdn.net/ustbhacker/article/details/8365756
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
    $dayArr   = array(
        'stock_id'  => $stockId,
        'type'      => $stockTYpe,
        'day_time'  => date('Ymd'),
        'week_time' => date('YW'),
        'mon_time'  => date('Ym'),
        'year_time' => date('Y'),
        'open'      => $tmp['5'],//开
        'top'       => $tmp['33'], //最低
        'footer'    => $tmp['34'], //最低
        'now_price'   =>  $tmp['3'], // 当前
        'now_zf'   =>  $tmp['32'], // 涨幅
    );
    return $dayArr;
}
