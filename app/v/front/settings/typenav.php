<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="tab-content">
            <label for="exampleInputEmail1">分类独立显示</label>
            <form role="form" method="post" name="form1" action="/settings/typenav.html">
                <?php foreach ($typeList as $typeListTmpKey => $typeListTmpVal) : ?>
                    <input type="checkbox" value="<?php echo $typeListTmpKey; ?>" name=typenav[]' <?php if (in_array($typeListTmpKey, $tyepnav)) echo 'checked' ?> /><?php echo $typeListTmpVal; ?>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-default">提交</button>
            </form>
        </div>
    </div>
</div>


