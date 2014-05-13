<?php
$typeArr = array(
    1 => '新闻',
    2 => '招聘',
);
?>
<div id="demo">
    <?php include_once(ROOT_V . 'ad' . DS . "admin/comm/left.php") ?>
    <div id="demo_content" style="height: 500px;">
        <div class="page-header">
            资讯列表
        </div>
        <table class =" table table-bordered table-striped table-hover">
            <tr style="background-color: ghostwhite;">
                <th width="10%">ID </th>
                <th width="10%">资讯标题</th>
                <th width="10%">内容简要</th>
                <th width="10%">创建时间</th>
                <th width="10%">更新时间</th>
                <th width="10%">类型</th>
                <th width="10%">操作</th>
            </tr>
            <?php if ($list): ?>
                <?php foreach ($list as $val) : ?>
                    <tr >
                        <th><?php echo $val['id']; ?></th>
                        <th><?php echo sysSubStr(strip_tags($val['title']), 15) . '...'; ?></th>
                        <th><?php echo sysSubStr(strip_tags($val['content']), 20) . '...'; ?></th>
                        <th><?php echo date('m-d H:i:s', $val['ctime']); ?></th>
                        <th><?php echo date('m-d H:i:s', $val['utime']); ?></th>
                        <th><?php echo $typeArr[$val['news_type']]; ?></th>
                        <th><a href="/admin/newsAdd/<?php echo $val['id'] ?>.html">修改</a></th>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <?php echo pageHtml('/admin/newsList/', $page, $cnt); ?>
    </div>
</div>
<div class="clear"></div>