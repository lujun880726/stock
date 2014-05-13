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
        editor = K.create('textarea[name="content"]', {
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
                标题：<input type="text" placeholder="标题" name="title" value="<?php echo @$data['title'] ?>"/>
                <br />
                类型：<select class="span2" name="news_type" id="news_type">
                    <option value="1">新闻</option>
                    <option value="2">招聘</option>
                </select>
                <script>
                    $('#news_type').val('<?php echo @$data['news_type'] ?>');
                </script>
                <div>
                    内容：
                    <textarea name="content" style="width:800px;height:400px;visibility:hidden;"><?php echo @$data['content'] ?></textarea>
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

