<div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="tab-content">
            <br/>
            <form role="form" method="post" name="form1" action="/formula/add.html">
                <div class="form-group">
                    <label for="exampleInputEmail1">选股公式</label>
                    <select name="date_type">
                        <?php foreach($formulaSelectTypeArr as $key => $val) :?>
                        <option value="<?php echo $key;?>"><?php echo $val;?></option>
                        <?php endforeach;?>
                    </select>
                    <BR>
                    <textarea style="width: 600px; height: 300px;" name="tmplist" ><?php echo @$row['explain_co'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-default">提交</button>
                <input type="hidden" name="id" value="<?php echo @$row['id'] ?>" />
            </form>
            
        </div>
    </div>
</div>
