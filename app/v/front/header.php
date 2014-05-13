<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>盛宝贸易 网方网站</title>
        <script src="/js/jquery-1.8.3.min.js"></script>
        <link href="/css/front.css" rel="stylesheet" type="text/css" />
        <base



</head>
<body>
    <div id="header"></div>
    <div id="top_nav">
        <ul>
            <ul>
                <li >
                    <a class="dsclick <?php isSel($p, 1); ?>"  href="/">首页</a>
                </li>
                <li  >
                    <a class="dsclick <?php isSel($p, 2); ?>"  href="/aboutus/index.html">关于我们</a>
                </li>
                <li  >
                    <a class="dsclick<?php isSel($p, 3); ?>"  href="/goods/index.html">产品中心</a>
                </li>
                <li >
                    <a class="dsclick<?php isSel($p, 4); ?>"  href="/job/index.html">招贤纳士</a>
                </li>
                <li  >
                    <a class="dsclick<?php isSel($p, 5); ?>"  href="/contacway/index.html">联系我们</a>
                </li>
                <li >
                    <a class="dsclick<?php isSel($p, 6); ?>"  href="/news/index.html">行业动态</a>
                </li>
            </ul>

        </ul>
    </div>
    <?php

    function isSel($p, $val)
    {
        if ($p == $val) {
            echo ' sel ';
        }
    }
    ?>
