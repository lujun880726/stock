
<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="tab-content">
            <table class="table table-bordered">
                <tr>
                    <td> 股票 </td>
                    <td> 名称 </td>
                    <td> 生成日期 </td>
                    <td> 评论 </td>
                </tr>
                <?php if ($list) : ?>
                    <?php foreach ($list as $val): ?>
                        <tr style="<?php if ($val['pl_type'] == 1) echo 'color: red';?>">
                            <td> <?php echo $val['stock_id'] ?> </td>
                            <td> <?php echo $val['name'] ?> </td>
                            <td> <?php echo date('Y-m-d', $val['ctime']) ?> </td>
                            <td> <?php echo $val['pl'] ?> </td>
                        </tr>

                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>


