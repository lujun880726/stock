<script>
    function getNow(stock_id)
    {
        $.getJSON(
                "/attention/getNow/" + stock_id + ".html",
                function(data) {
                    $('#nowprice_' + stock_id).html(data.msg.harvest);
                    tmp_now = (parseFloat(data.msg.harvest) - parseFloat($('#price_' + stock_id).html())) / parseFloat($('#price_' + stock_id).html());
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
            <form role="form" method="post" name="form1" action="/attention/index.html">
                <div class="form-group">
                    <label for="exampleInputEmail1">股票码</label>
                    <input type="" class="form-control" id="exampleInputEmail1"  name="stock_id" placeholder="ACCOUT" size="10">
                </div>
                <button type="submit" class="btn btn-default">关注</button>
            </form>
            <table class="table table-bordered">
                <tr>
                    <td> 股票 </td>
                    <td> 名称 </td>
                    <td> 关注日期 </td>
                    <td> 关注时价格 </td>
                    <td> 当前价 </td>
                    <td> 百分比 </td>
                    <td> 操作 </td>
                </tr>
                <?php if ($list) : ?>
                    <?php foreach ($list as $val): ?>
                        <tr>
                            <td> <a target="_black" href="http://stockhtm.finance.qq.com/sstock/ggcx/<?php echo $val['stock_id'] ?>.shtml"><?php echo $val['stock_id'] ?> </a></td>
                            <td> <?php echo $val['name'] ?> </td>
                            <td> <?php echo date('Y-m-d', $val['ctime']) ?> </td>
                            <td> <span id="price_<?php echo $val['stock_id'] ?>"><?php echo $val['attention_price'] ?></span></td>
                            <td> <span id="nowprice_<?php echo $val['stock_id'] ?>"> 当前价</span> </td>
                            <td> <span id="nowrate_<?php echo $val['stock_id'] ?>"> 百分比</span> </td>
                            <td>
                                <button class="btn btn-danger" type="submit" onclick="del('<?php echo $val['stock_id'] ?>')">删除</button>
                                <a target="_black" href="/pl/index/<?php echo $val['stock_id'] ?>.html"><button class="btn btn-danger" type="submit" >千股千评</button></a>
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


