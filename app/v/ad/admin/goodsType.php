<div id="demo">
    <?php include_once(ROOT_V . 'ad' . DS . "admin/comm/left.php") ?>
    <div id="demo_content" style="height: 500px;">
        <form class="form-search" role="form" action=""  method="post">
            <div class="page-header">
                物品分类：<input type="text" placeholder="物品分类" name="type_name" value="<?php echo @$goodsTypeArr['type_name']; ?>"/>
                <button class="btn btn-primary" type="submit">提交</button>
            </div>
        </form>
        <table class =" table table-bordered table-striped table-hover">
            <tr style="background-color: ghostwhite;">
                <th width="10%">ID </th>
                <th width="10%">分类名称</th>
                <th width="10%">操作</th>
            </tr>
            <?php if ($list): ?>
                <?php foreach ($list as $val) : ?>
                    <tr >
                        <th><?php echo $val['id']; ?></th>
                        <th><?php echo $val['type_name']; ?></th>
                        <th><a href="/admin/goodsType/<?php echo $val['id'] ?>.html">修改</a></th>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>
<div class="clear"></div>

<?php if (isset($err) && !empty($err)) : ?>
    <script>
        alert('<?php echo $err; ?>');
    </script>
<?php endif; ?>