<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if ((isset($_REQUEST['dbg']) && 'debug' == $_REQUEST['dbg'])) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'Off');
    error_reporting(0);
}


if (substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.')) == 'stockc') {
    include 'cron.php';
    exit;
}

$REQUEST_URI = $_SERVER['REQUEST_URI'];

$m       = 'index';
$f       = 'index';
$paraArr = array();


if ('/' == $REQUEST_URI) {
    $m = 'index';
    $f = 'index';
} else {
    str_replace('.html', '', $REQUEST_URI, $cnt);
    if (1 != $cnt) {
        $m = 'error';
        $f = 'index';
    } else {
        $tmp = explode('/', trim($REQUEST_URI, '/'));
        if (1 == count($tmp)) {
            $tmpH = explode('.', $tmp[0]);
            $m    = $tmpH[0];
            $f    = 'index';
        } elseif (2 == count($tmp)) {
            $tmpH = explode('.', $tmp[1]);
            $m    = $tmp[0];
            $f    = $tmpH[0];
        } elseif (3 == count($tmp)) {
            $tmpH    = explode('.', $tmp[2]);
            $m       = $tmp[0];
            $f       = $tmp[1];
            $paraArr = explode('_', $tmpH[0]);
        } else {
            $m = 'error';
            $f = 'index';
        }
    }
}

include 'init.php';
include 'fun.php';

//$fFile = ROOT_C . $f . '.php';
//if (!file_exists($fFile)) {
//    $m = 'error';
//    $f = 'index';
//}


session_start();

$mc            = 'c_' . $m;
$obj           = new $mc();
$fm            = $f . 'Action';
$obj->_paraArr = $paraArr;

$obj->init();
$endArr = $obj->$fm();
if (3 == $obj->_viewType) {
    header('Content-type: text/json');
    header('Content-type: application/json; charset=UTF-8');
    exit(json_encode($endArr));
}

if (false == $obj->_bg) {
    // 前台
    $basePath = ROOT_V . 'front' . DS;
} else {
    // 后台
    $basePath = ROOT_V . 'ad' . DS;
}

if (2 == $obj->_viewType) {


    if (!empty($endArr)) {
        extract($endArr);
    }

    include_once $basePath . $m . DS . $f . '.php';
} else {
    if (!empty($endArr)) {
        extract($endArr);
    }

    include_once $basePath . 'header.php';

    include_once $basePath . $m . DS . $f . '.php';

    include_once $basePath . 'footer.php';
}



