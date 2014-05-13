<?php
$memarr = array(
    '咨询管理' => array(
        1 => array(
            'name' => '添加咨询',
            'link' => '/admin/newsAdd.html',
        ),
        2 => array(
            'name' => '咨询列表',
            'link' => '/admin/newsList/1.html',
        ),
    ),
    '物品管理' => array(
        3 => array(
            'name' => '添加物品',
            'link' => '/admin/goodsAdd.html',
        ),
        4 => array(
            'name' => '物品列表',
            'link' => '/admin/goodsList/1.html',
        ),
        5 => array(
            'name' => '物品类型',
            'link' => '/admin/goodsType.html',
        ),
    ),
    '全局配置' => array(
        '6' => array(
            'name' => '添另页面信息',
            'link' => '/admin/pageAdd.html',
        ),
        '7' => array(
            'name' => '页面信息列表',
            'link' => '/admin/pageList.html',
        ),
    ),
);
?>
<div id="demo_menu">
    <h3>欢迎你，admin</h3><br/>

    <?php foreach ($memarr as $key => $row): ?>
        <h3><?php echo $key; ?></h3>
        <ul index="line">
            <?php foreach ($row as $keyv => $val) : ?>
                <li id="<?php echo $keyv ?>" <?php if ($urlid == $keyv) echo 'class="cur"'; ?>><a href="<?php echo $val['link'] ?>"><?php echo $val['name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

    <br/><br/><br/><br/><br/><br/><br/><br/><br/>


</div>