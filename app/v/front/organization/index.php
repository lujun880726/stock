<script>
    function getNow(stock_id)
    {
        $.getJSON(
                "/attention/getNow/" + stock_id + ".html",
                function(data) {
                    $('#nowprice_' + stock_id).html(data.msg.now_price);
					$('#nowzf_' + stock_id).html( data.msg.now_zf  + '% ');
                    if (data.msg.now_zf < 0)
                    {
                        $('#nowzf_' + stock_id).attr('style', 'color: red');
                    }
					$('#qgqp_' + stock_id).html(data.msg.pl);

                }
        );
    }
</script>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="tab-content">
            
            <table class="table table-bordered">
                <tr>
                    <td> 股票 </td>
                    <td> 名称 </td>
                    <td> 最近时间 </td>
                    <td> 机构评论 </td>
                    <td> 最少价格 </td>
                    <td> 平均价格 </td>
                    <td> 最高价格 </td>
                    <td> 机构报表 </td>
<!--                    <td> 收录价格 </td>-->
                    <td> 当前价 </td>
                    <td> 今日涨幅 </td>
                    <td> 千股千评 </td>
                </tr>
                <?php if ($list) : ?>
                    <?php foreach ($list as $val): ?>
                <?php //var_dump($val);exit;?>
                        <tr>
                            <td> <a target="_black" href="http://stockhtm.finance.qq.com/sstock/ggcx/<?php echo $val['stock_id'] ?>.shtml"><?php echo $val['stock_id'] ?> </a></td>
                            <td> <?php echo $val['stock_name'] ?> </td>
                            <td> <?php echo $val['stat_date'] ?> </td>
                            <td> <?php echo str_replace('|','<BR>',$val['last_agency_rating']) ?> </td>
                            <td> <?php echo $val['min_price'] ?> </td>
                            <td> <?php  echo$val['expect_price'] ?> </td>
                            <td> <?php echo $val['max_price'] ?> </td>
                            <td> <?php echo $val['table_view'] ?> </td>
<!--                            <td> <span id="price_<?php echo $val['stock_id'] ?>"><?php echo $val['attention_price'] ?></span></td>-->
                            <td> <span id="nowprice_<?php echo $val['stock_id'] ?>"> 当前价</span> </td>
                            <td> <span id="nowzf_<?php echo $val['stock_id'] ?>"> 今日涨幅</span> </td>
                             <td> <span id="qgqp_<?php echo $val['stock_id'] ?>"> 千股千评</span> </td>
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


