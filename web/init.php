<?php

define('DS', "/");
define('ROOT_PATH', __DIR__);
define('ROOT_APP', ROOT_PATH . DS . '..' . DS . 'app' . DS);
define('ROOT_C', ROOT_APP . 'c' . DS);
define('ROOT_M', ROOT_APP . 'm' . DS);
define('ROOT_V', ROOT_APP . 'v' . DS);
define('ROOT_CORN', ROOT_APP . 'corn' . DS);

function __autoload($className)
{
    $classPath = '';

    if (strpos($className, 'c_') !== false) {
        $classPath = ROOT_APP . str_replace('_', DS, $className);
    }

    if (strpos($className, 'm_') !== false) {
        $classPath = ROOT_APP . str_replace('_', DS, $className);
    }
    include_once $classPath . '.php';
    if (!class_exists($className, false)) {
        trigger_error('<br />Unable to load class: ' . $className, E_USER_WARNING);
        exit();
    }
}

function m($mName)
{
    return new $mName();
}

function model($name)
{
    $modelName = 'm_' . $name;
    return new $modelName();
}

function pageHtml($url, $page, $cnt)
{
    $str = '<span style="float: right;">';
    if ($cnt != 0) {
        if (1 != $page) {
            $str .= '<a href="' . $url . ($page - 1) . '.html" style="text-align:right;">上一页</a>';
        }
        if ($cnt != $page) {
            $str .= '<a href="' . $url . ($page + 1) . '.html" style="text-align:right;">下一页</a>';
        }
    }
    $str .= '共' . $cnt . '页';
    $str .= '</span>';
    return $str;
}

function sysSubStr($String, $Length, $Append = false)
{
    if (strlen($String) <= $Length) {
        return $String;
    } else {
        $I = 0;
        while ($I < $Length) {
            $StringTMP = substr($String, $I, 1);
            if (ord($StringTMP) >= 224) {
                $StringTMP = substr($String, $I, 3);
                $I         = $I + 3;
            } elseif (ord($StringTMP) >= 192) {
                $StringTMP = substr($String, $I, 2);
                $I         = $I + 2;
            } else {
                $I = $I + 1;
            }
            $StringLast[] = $StringTMP;
        }
        $StringLast = implode("", $StringLast);
        if ($Append) {
            $StringLast .= "...";
        }
        return $StringLast;
    }
}

function getStr($data, $f, $e)
{
    $tmp = explode($f, $data);
    $pos = strpos($tmp[1], $e);
    return substr($tmp[1], 0, $pos);
}

