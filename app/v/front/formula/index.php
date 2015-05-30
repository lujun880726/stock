<script>
    function getNow(stock_id)
    {
        $.getJSON(
                "/attention/getNow/" + stock_id + ".html",
                function (data) {
                    $('#nowprice_' + stock_id).html(data.msg.harvest);
                    tmp_now = (parseFloat(data.msg.harvest) - parseFloat($('#price_' + stock_id).html())) / parseFloat($('#price_' + stock_id).html()) * 100;
                    $('#nowrate_' + stock_id).html(tmp_now + '% ');
                    $('#qgqp_' + stock_id).html(data.msg.pl);
                    if (tmp_now < 0)
                    {
                        $('#nowrate_' + stock_id).attr('style', 'color: red');
                    }
                    nowzf = (parseFloat(data.msg.harvest) - parseFloat(data.msg.lastprice)) / parseFloat(data.msg.lastprice) * 100;
                    $('#nowzf_' + stock_id).html(nowzf + '% ');
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
        function (data) {
            alert('删除成功');
            location.href = '/attention/index/_<?php echo @$navTypeId; ?>.html';
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
                    <li role="presentation" <?php if ($navTypeId < 1) echo 'class="active"'; ?>><a href="/formula/index/0.html">重合</a></li>
                    <?php foreach ($formulaSelectTypeArr as $key => $val) : ?>
                        <li role="presentation" <?php if ($key == $navTypeId) echo 'class="active"'; ?>><a href="/formula/index/<?php echo $key; ?>.html"><?php echo $val ?></a></li>
                    <?php endforeach; ?>

                    <!--                    <li role="presentation" class="active"><a href="#">Home</a></li>
                                        <li role="presentation"><a href="#">Profile</a></li>
                                        <li role="presentation"><a href="#">Messages</a></li>-->
                </ul>
            </div>
            <br/>


            <table class="table table-bordered">
                <tbody>
                    <tr >
                        <td >日期</td>
                        <td >代码</td>
                        <td >名称</td>
                        <td  >收盘价</td>
                        <td  >当天涨幅</td>
                        <td >公式</td>
                        <td> 当前价 </td>
                        <td> 今日涨幅 </td>
                        <td> 百分比 </td>
                    </tr>
                <tbody>
                <colgroup>
                    <col  span="6" >
                </colgroup>
                <?php if ($list) : ?>
                    <tbody>
                    <?php foreach ($list as $day =>$Dval): ?>
                        <?php foreach($Dval as $key => $row) :?>
                        <tr height="18" style="height:13.5pt">
                            <?php if ($key < 1) :?>
                           <td  rowspan=" <?php echo count($list[$day]);?>"><?php echo $day;?></td>
                            <?php endif;?>
                           <td ><?php echo $row['stock_id'];?></td>
                           <td ><?php echo $row['name'];?></td>
                           <td ><span id="price_<?php echo $row['stock_id'] ?>"><?php echo $row['harvest'];?></span></td>
                           <td ><?php echo $row['zf'];?>%</td>
                           
                           <?php if ($navTypeId < 1) :?>
                                <td >重合数(<?php echo $row['num']?>）</td>
                           <?php else :?>
                                <td ><?php echo $formulaSelectTypeArr[$row['date_type']];?></td>
                           <?php endif;?>
                           
                           
                           <td> <span id="nowprice_<?php echo $row['stock_id'] ?>"> 当前价</span> </td>
                            <td> <span id="nowzf_<?php echo $row['stock_id'] ?>"> 今日涨幅</span> </td>
                            <td> <span id="nowrate_<?php echo $row['stock_id'] ?>"> 百分比</span> </td>
                             <script>
                            getNow('<?php echo $row['stock_id'] ?>');
                        </script>
                       </tr>
                        <?php endforeach;?>
                    <?php endforeach;?>
                    </tbody>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>


