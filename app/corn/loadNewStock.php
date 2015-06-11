<?php

/**
 *  /usr/bin/php /home/wwwroot/stock.waiteat.com/app/corn/loadNewStock.php
 *
 * D: && cd D:\LJ\stock\app\corn  && php loadNewStock.php
 */
set_time_limit(0);
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include dirname(dirname(dirname(__FILE__))) . '/web/init.php';

getStockListBYeastmoney();
//organizationViewpointByQQ(0, 0);

/**
 * 获取股票列表eastmoney
 */
function getStockListBYeastmoney() {
    $objBase = m('m_base');
//添加每天新的股票
    $page = 100;
    $url = 'http://datainterface.eastmoney.com/EM_DataCenter/JS.aspx?type=FD&sty=TSTC&st=1&sr=1&p=';
    $urlEnd = '&ps=50&js=var%20vevHhpuG=(x)&mkt=0&rt=';
    for ($i = 1; $i <= $page; $i++) {
        $endUrl = $url . $i . $urlEnd . time();

        $data = fileGetContents($endUrl);
        if (empty($data)) {
            sleep(60);
            $data = fileGetContents($endUrl);
            if (empty($data)) {
                continue;
            }
        }
        if (1 == $i) {
            $page = getStr($data, 'pages:', ',');
        }
        $tmpInfo = getStr($data, 'data:["', '"],cdate:');

        $tmp = explode('","', $tmpInfo);
        if ($tmp) {
            foreach ($tmp as $val) {
                $tmp1 = explode(',', $val);
                if (!empty($tmp1[0])) {
                    //插入或更新数据
                    $row = $objBase->db->get_one("select * from `stock` where stock_id = '{$tmp1[0]}'");
                    if ($tmp1[2] == 2) {
                        $type = 'sz';
                    } else {
                        $type = 'sh';
                    }


                    if (empty($row)) {
                        $objBase->db->insert('stock', array('stock_id' => $tmp1[0], 'type' => $type, 'create_time' => strtotime("today"), 'name' => $tmp1[1]));
                    } else {
                        if (empty($row['name'])) {
                            $objBase->db->update('stock', array('name' => $tmp1[1]), "stock_id = '" . $tmp1[0] . "'"); // iconv("GB2312", "utf-8", $name)
                        }
                    }

                    organizationViewpointByQQ($tmp1[0], $type);

                    $goodStrArr = array('进', '加', '入', '吸', '多', '增', '持有');
                    $badStrArr = array('离', '减', '出', '抛', '空');
                    str_replace($goodStrArr, '1', $tmp1[3], $goodcnt);
                    str_replace($badStrArr, '1', $tmp1[3], $badcnt);

                    //`pl_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0好，1坏',
                    if ($goodcnt > 0) {
                        $objBase->db->insert('stock_pl', array('stock_id' => $tmp1[0], 'pl' => $tmp1[3], 'pl_type' => 0, 'ctime' => strtotime("today")));
                    }
                    if ($badcnt > 0) {
                        $objBase->db->insert('stock_pl', array('stock_id' => $tmp1[0], 'pl' => $tmp1[3], 'pl_type' => 1, 'ctime' => strtotime("today")));
                    }
                }
            }
        }
        sleep(2);
    }
}

/**
 * 获取机构关点
 * @param type $stockId
 */
function organizationViewpointByQQ($stockId, $type) {
    //  $type = 'sz';
    //  $stockId = '300170';
    $url = "http://gu.qq.com/" . $type . $stockId;
    $data = fileGetContents($url);
    if (empty($data)) {
        $data = fileGetContents($url);
    }
    if ($data) {
        str_replace('g_StockRating', '', $data, $cnt);
        if ($cnt < 1) {
            return '';
        }
        $res = trim(getStr($data, 'g_StockRating =', ';'));


        $tmp = explode(":'", $res);

        $tt1 = getAJ($tmp[1], "',");
        $tt2 = getAJ($tmp[1], "',");
        if ($tt1 == '--' || empty($tt2)) {
            return '';
        }


        $s1E = explode("|", getAJ($tmp[10], "'"));
        $s2E = explode("|", getAJ($tmp[12], "'"));
        $s3E = explode("|", getAJ($tmp[14], "'"));
        
        $year  = explode('年',getAJ($tmp[9], "'"));
        $strArr = array(
            'stock_id' => getAJ($tmp[1], "',"),
            'stock_name' => getAJ($tmp[2], "',"),
            'stat_date' => $year[0] . str_replace(array('月', '日'), '', getAJ($tmp[3], "',")),
            'last_agency_rating' => getAJ($tmp[7], "'"),
            'min_price' => getAJ($tmp[5], "',"),
            'expect_price' => getAJ($tmp[4], "',"),
            'max_price' => getAJ($tmp[6], "',"),
            'table_view' => '<table cellspacing="0" cellpadding="0">
                                <tbody><tr class="th"><td>&nbsp;</td><td>报告数</td><td>强烈看涨</td><td>看涨</td><td>看平</td><td>看跌</td><td>强烈看跌</td></tr>
                                <tr id="agents-report-count"><td class="bg1">' . getAJ($tmp[9], "'") . '</td><td>' . $s1E[0] . '</td><td>' . $s1E[1] . '</td><td>' . $s1E[2] . '</td><td>' . $s1E[3] . '</td><td>' . $s1E[4] . '</td><td>' . $s1E[5] . '</td></tr>
                                <tr class="bg1"><td>' . getAJ($tmp[11], "'") . '</td><td>' . $s2E[0] . '</td><td>' . $s2E[1] . '</td><td>' . $s2E[2] . '</td><td>' . $s2E[3] . '</td><td>' . $s2E[4] . '</td><td>' . $s2E[5] . '</td></tr>
                                <tr><td class="bg1">' . getAJ($tmp[13], "'") . '</td><td>' . $s3E[0] . '</td><td>' . $s3E[1] . '</td><td>' . $s3E[2] . '</td><td>' . $s3E[3] . '</td><td>' . $s3E[4] . '</td><td>' . $s3E[5] . '</td></tr>
                              </tbody></table>',
            'utime' => time(),
        );
        $objBase = m('m_organizationviewpoint');
        $objBase->upOrRep($strArr);
    }
}

function getAJ($data, $exStr, $reKey = 0) {
    $tmp = explode($exStr, $data);
    return $tmp[$reKey];
}

///------------------------------------------------------------------------------------------------------------------------------------------------------------
/**
 * 调用存储过程
 * 对比前一日成交量
 */
function callPR() {
    $objBase = m('m_base');
    $objBase->db->get_all("call stock_day_stock_vol(" . date('Ymd') . ");");
}

/**
 * 获取股票列表gtimg
 */
function getStockListBYgtimg() {
    $objBase = m('m_base');
//添加每天新的股票
    $page = 100;
    $url = 'http://stock.gtimg.cn/data/index.php?appn=rank&t=ranka/chr&o=0&l=80&v=list_data&p=';
    for ($i = 1; $i <= $page; $i++) {

        $endUrl = $url . $i;
        $data = fileGetContents($endUrl);
        echo $endUrl;
        if (1 == $i) {
            $page = getStr($data, 'total:', ',');
        }
        $idStr = getStr($data, "data:'", "'");

        $tmp = explode(',', $idStr);
        if ($tmp) {
            foreach ($tmp as $val) {
                $type = substr($val, 0, 2);
                $stock_id = substr($val, 2, 8);
                $arr = $objBase->db->get_one("select stock_id from `stock` where stock_id = '{$stock_id}'");
                if (empty($arr)) {
                    $objBase->db->insert('stock', array('stock_id' => $stock_id, 'type' => $type, 'create_time' => strtotime("today")));
                }
            }
        }
        sleep(2);
    }
}

/**
 * 获取全部股票信息（HeXun）
 * @global type $objBase
 */
function getDayInfoFromHeXun() {
    global $objBase;
    // 每天的收盘信息 停盘不记录
    $list = $objBase->db->get_all("select * from `stock` where 1");
    foreach ($list as $val) {
        echo $val['stock_id'];
        $url = "http://bdcjhq.hexun.com/quote?s2=" . $val['stock_id'] . "." . $val['type'];
        $data = '';
        $data = fileGetContents($url);
        if (empty($data)) {
            sleep(5);
            $data = fileGetContents($url);
        }
        if (empty($data)) {
            file_put_contents(date('Y-m-d') . '.log', $url . "\r\n", FILE_APPEND);
            continue;
        }
        $strInfo = getStr($data, 'bdcallback(', ')}');
        $tmp = explode(":", $strInfo);
        $name = str_replace(array('",pc', '"'), '', $tmp['2']);
        if (!$val['name']) {

            $objBase->db->update('stock', array('name' => iconv("GB2312", "utf-8", $name)), "stock_id = '" . $val['stock_id'] . "'"); //
        }
        $open = str_replace(array('",vo', '"'), '', $tmp['4']);
        $top = str_replace(array('",lo', '"'), '', $tmp['7']);
        $footer = str_replace(array('",la', '"'), '', $tmp['8']);
        $harvest = str_replace(array('",type', '"'), '', $tmp['9']);
        $vol = str_replace(array('",tu', '"'), '', $tmp['5']);
        if ($open < 1) {
            continue;
        }
        $tempTIme = explode(' ', str_replace(array('"', '"'), '', $tmp['11']));
        if (strtotime($tempTIme[0]) != strtotime('today')) {
            continue;
        }
        $dayArr = array(
            'stock_id' => $val['stock_id'],
            'type' => $val['type'],
            'day_time' => date('Ymd'),
            'week_time' => date('YW'),
            'mon_time' => date('Ym'),
            'year_time' => date('Y'),
            'open' => $open,
            'top' => $top,
            'footer' => $footer,
            'harvest' => $harvest,
            'vol' => $vol,
        );
        $objBase->db->insert('day_harvest_info', $dayArr);
        sleep(2);
    }
}

/**
 * 获取全部股票信息（QQ）
 * @global type $objBase
 */
function getDayInfoFromQQ() {
    global $objBase;
    // 每天的收盘信息 停盘不记录
    $list = $objBase->db->get_all("select * from `stock` where 1");
    foreach ($list as $val) {
        $url = "http://qt.gtimg.cn/r=" . (0.28181632646317246 + '0.' . rand(1, 999999999)) . "q=marketStat,stdunixtime," . $val['type'] . $val['stock_id'] . ",";
        $data = '';
        $data = fileGetContents($url);
        if (empty($data)) {
            sleep(5);
            $data = fileGetContents($url);
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
            'stock_id' => $val['stock_id'],
            'type' => $val['type'],
            'day_time' => date('Ymd'),
            'week_time' => date('YW'),
            'mon_time' => date('Ym'),
            'year_time' => date('Y'),
            'open' => $tmp[5],
            'top' => $tmp[33],
            'footer' => $tmp[34],
            'harvest' => $tmp[3],
            'vol' => $tmp[6],
        );

        $objBase->db->insert('day_harvest_info', $dayArr);
        sleep(5);
    }
}

function fileGetContents($url) {
    $timeout = array(
        'http' => array(
            'timeout' => 5 //设置一个超时时间，单位为秒
        )
    );
    $ctx = stream_context_create($timeout);
    echo $url;
    $a = file_get_contents($url, 0, $ctx);
    return $a;
}
