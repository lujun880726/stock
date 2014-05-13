<?php
$goodsTypeKV = model('goods')->goodsTypeKV();
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
                <th width="10%">物品名称</th>
                <th width="10%">物品描述</th>
                <th width="10%">图片</th>
                <th width="10%">创建时间</th>
                <th width="10%">更新时间</th>
                <th width="10%">类型</th>
                <th width="10%">操作</th>
            </tr>
            <?php if ($list): ?>
                <?php foreach ($list as $val) : ?>
                    <tr >
                        <th><?php echo $val['id']; ?></th>
                        <th><?php echo sysSubStr($val['goods_name'], 50); ?></th>
                        <th><?php echo sysSubStr(strip_tags($val['goods_content']), 20) . '...'; ?></th>
                        <th><img  src="<?php echo $val['goods_img']; ?>" height="50px" width="50px" /></th>
                        <th><?php echo date('Y-m-d H:i:s', $val['ctime']); ?></th>
                        <th><?php echo date('Y-m-d H:i:s', $val['utime']); ?></th>
                        <th><?php echo $goodsTypeKV[$val['goods_type']]; ?></th>
                        <th><a href="/admin/goodsAdd/<?php echo $val['id'] ?>.html">修改</a></th>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <?php echo pageHtml('/admin/goodsList/', $page, $cnt); ?>
    </div>
</div>
<div class="clear"></div>