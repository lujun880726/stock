<script>
    function getNow(stock_id)
    {
        $.getJSON(
                "/attention/getNow/" + stock_id + ".html",
                function(data) {
                    $('#nowprice_' + stock_id).html(data.msg.harvest);
                    tmp_now = (parseFloat(data.msg.harvest) - parseFloat($('#price_' + stock_id).html())) / parseFloat($('#price_' + stock_id).html()) * 100;
                    $('#nowrate_' + stock_id).html(tmp_now + '% ');
                    $('#qgqp_' + stock_id).html(data.msg.pl);
                    if (tmp_now < 0)
                    {
                        $('#nowrate_' + stock_id).attr('style', 'color: red');
                    }
                    nowzf  = (parseFloat(data.msg.harvest) - parseFloat(data.msg.lastprice)) / parseFloat(data.msg.lastprice) * 100;
                    $('#nowzf_' + stock_id).html( nowzf  + '% ');
                    if (nowzf < 0)
                    {
                        $('#nowzf_' + stock_id).attr('style', 'color: red');
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
            location.href = '/attention/index/_<?php echo @$navTypeId;?>.html';
        },
                "json"
                );
    }
</script>
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="tab-content">
            <br/>
            <div class="tab-content">

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" <?php if ($navTypeId < 1) echo 'class="active"';?>><a href="/formula/index/0.html">重合</a></li>
                    <?php foreach($formulaSelectTypeArr as $key=>$val) :?>
                    <li role="presentation" <?php if ($key == $navTypeId) echo 'class="active"';?>><a href="/formula/index/<?php echo $key;?>.html"><?php echo $val?></a></li>
                    <?php endforeach;?>

<!--                    <li role="presentation" class="active"><a href="#">Home</a></li>
                    <li role="presentation"><a href="#">Profile</a></li>
                    <li role="presentation"><a href="#">Messages</a></li>-->
                </ul>
            </div>
            <br/>
            <table class="table table-bordered">
                <tr>
                    td> nf </td>
                    <td> 股票 </td>
                    <td> 名称 </td>
                    <
                    <td> 关注时价格 </td>
                    <td> 当前价 </td>
                    <td> 今日涨幅 </td>
                    <td> 百分比 </td>
                    <td> 关注类型 </td>
                    <td> 理由 </td>
                    <td> 千股千评 </td>
                    <td>操作</td>
                </tr>
                <?php if ($list) : ?>
                    <?php foreach ($list as $val): ?>
                        <tr>
                            <td> <a target="_black" href="http://stockhtm.finance.qq.com/sstock/ggcx/<?php echo $val['stock_id'] ?>.shtml"><?php echo $val['stock_id'] ?> </a></td>
                            <td> <?php echo $val['name'] ?> </td>
                            <td> <?php echo date('Y-m-d', $val['ctime']) ?> </td>
                            <td> <span id="price_<?php echo $val['stock_id'] ?>"><?php echo $val['attention_price'] ?></span></td>
                            <td> <span id="nowprice_<?php echo $val['stock_id'] ?>"> 当前价</span> </td>
                            <td> <span id="nowzf_<?php echo $val['stock_id'] ?>"> 今日涨幅</span> </td>
                            <td> <span id="nowrate_<?php echo $val['stock_id'] ?>"> 百分比</span> </td>
                            <td> <?php echo $typeList[$val['attention_id']] ?> </td>
                            <td> <?php echo $val['attention_co'] ?> </td>
                             <td> <span id="qgqp_<?php echo $val['stock_id'] ?>"> 千股千评</span> </td>
                            <td>
                                <button class="btn btn-danger" type="submit" onclick="del('<?php echo $val['stock_id'] ?>')">删除</button>
                                <a  href="/attention/index/<?php echo $val['stock_id'] ?>_<?php echo $navTypeId?>.html"><button class="btn btn-danger" type="submit" >修改</button></a>
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


