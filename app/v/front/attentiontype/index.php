<script>
    function getNow(stock_id)
    {
        $.getJSON(
                "/attention/getNow/" + stock_id + ".html",
                function(data) {
                    $('#nowprice_' + stock_id).html(data.msg.harvest);
                    tmp_now = (parseFloat(data.msg.harvest) - parseFloat($('#price_' + stock_id).html())) / parseFloat($('#price_' + stock_id).html()) * 100;
                    $('#nowrate_' + stock_id).html(tmp_now + '% ');
                    if (tmp_now < 0)
                    {
                        $('#nowrate_' + stock_id).attr('style', 'color: red');
                    }
                }
        );
    }

    function del(stock_id)
    {
        $.post(
                "/attention/del.html",
                {stock_id: stock_id},
        function(data) {
            alert('删除成功');
            location.reload();
        },
                "json"
                );
    }
</script>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="tab-content">
            <a  href="/attentiontype/index.html"><button class="btn btn-default" type="submit" >新建</button></a>
            <br/>
            <form role="form" method="post" name="form1" action="/attentiontype/index.html">
                <div class="form-group">
                    <label for="exampleInputEmail1">分类名称</label>
                    <input type="" class="form-control" id="exampleInputEmail1"  name="attention_name" placeholder="ACCOUT" size="10" value="<?php echo @$row['attention_name'] ?>">
                    <textarea name="explain_co"><?php echo @$row['explain_co'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-default">提交</button>
                <input type="hidden" name="id" value="<?php echo @$row['id'] ?>" />
            </form>
            <table class="table table-bordered">
                <tr>
                    <td> ID </td>
                    <td> 名称 </td>
                    <td> 说明 </td>
                    <td> 日期 </td>
                    <td> 操作 </td>
                </tr>
                <?php if ($list) : ?>
                    <?php foreach ($list as $val): ?>
                        <tr>
                            <td> <?php echo $val['id'] ?></td>
                            <td> <?php echo $val['attention_name'] ?> </td>
                            <td> <?php echo $val['explain_co'] ?> </td>
                            <td> <?php echo date('Y-m-d', $val['ctime']) ?> </td>
                            <td>
                                <a  href="/attentiontype/index/<?php echo $val['id'] ?>.html"><button class="btn btn-danger" type="submit" >修改</button></a>
                            </td>
                        </tr>
                        <script>
                            getNow('<?php echo $val['stock_id'] ?>');
                        </script>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>


