<?php

/**
 *  Description of Examine
 *
 * @author LJ <jun.lu.726@gmail.com>
 * @copyright @copyright
 * @history    2014-05-13 02:17:24::  Lujun  ::  Create File
 * $Id: cron.php 0 2014-05-13 02:17:24Z lujun $
 */

include 'init.php';

$REQUEST_URI =$_SERVER['REQUEST_URI'];


$file = trim(ROOT_CORN,DS) . $REQUEST_URI;
if (!file_exists($file)){
    die('err');
}

include_once $file;
