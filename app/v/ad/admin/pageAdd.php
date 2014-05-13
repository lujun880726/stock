<style>
    form {
        margin: 0;
    }
    textarea {
        display: block;
    }
</style>
<link rel="stylesheet" href="/kindeditor/themes/default/default.css" />
<script charset="utf-8" src="/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/kindeditor/lang/zh_CN.js"></script>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="page_val"]', {
            allowFileManager: true
        });
        K('input[name=getHtml]').click(function(e) {
            alert(editor.html());
        });
        K('input[name=isEmpty]').click(function(e) {
            alert(editor.isEmpty());
        });
        K('input[name=getText]').click(function(e) {
            alert(editor.text());
        });
        K('input[name=selectedHtml]').click(function(e) {
            alert(editor.selectedHtml());
        });
        K('input[name=setHtml]').click(function(e) {
            editor.html('<h3>Hello KindEditor</h3>');
        });
        K('input[name=setText]').click(function(e) {
            editor.text('<h3>Hello KindEditor</h3>');
        });
        K('input[name=insertHtml]').click(function(e) {
            editor.insertHtml('<strong>插入HTML</strong>');
        });
        K('input[name=appendHtml]').click(function(e) {
            editor.appendHtml('<strong>添加HTML</strong>');
        });
        K('input[name=clear]').click(function(e) {
            editor.html('');
        });
    });
</script>

<div id="demo">
    <?php include_once(ROOT_V . 'ad' . DS . "admin/comm/left.php") ?>
    <div id="demo_content">
        <div class="page-header">
            <form class="form-search" role="form" action=""  method="post">
                名称：<input type="text" placeholder="名称" name="page_name" value="<?php echo @$data['page_name'] ?>"/>
                <br />

                <div>
                    内容：
                    <textarea name="page_val" style="width:800px;height:400px;visibility:hidden;"><?php echo @$data['page_val'] ?></textarea>
                </div>
                <button class="btn btn-primary" type="submit">提交</button>
                <input type="hidden" value="<?php echo @$data['id'] ?>" name="id" />
            </form>
        </div>
    </div>
</div>
<div class="clear"></div>
<?php if (isset($err) && !empty($err)) : ?>
    <script>
        alert('<?php echo $err; ?>');
    </script>
<?php endif; ?>

