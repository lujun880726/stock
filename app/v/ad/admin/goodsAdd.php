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
<link href="/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/uploadify/jquery.uploadify.min.js"></script>

<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="goods_content"]', {
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
    });</script>

<div id="demo">
    <?php include_once(ROOT_V . 'ad' . DS . "admin/comm/left.php") ?>
    <div id="demo_content">
        <div class="page-header">
            <form class="form-search" role="form" action=""  method="post">
                物品名称：<input type="text" placeholder="标题" name="goods_name" value="<?php echo @$data['goods_name'] ?>"/>
                <br />
                类型：<select class="span2" name="goods_type" id="goods_type">
                    <?php if ($goodsTypeKV) : ?>
                        <?php foreach ($goodsTypeKV as $key => $val): ?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <script>
                    $('#goods_type').val('<?php echo @$data['goods_type'] ?>');</script>
                <div id="queue"></div>
                物品图片:<input id="file_upload" name="file_upload" type="file" multiple="true">
                <span><img  id="goods_img_src" src="<?php if (isset($data['goods_img'])) echo $data['goods_img']; ?>" height="50px" width="50px" /></span>
                <input type="hidden" name="goods_img" id="goods_img" value="<?php if (isset($data['goods_img'])) echo $data['goods_img']; ?>" />
                <script type="text/javascript">
<?php $timestamp = time(); ?>
                    $(function() {
                        $('#file_upload').uploadify({
                            'formData': {
                                'timestamp': '<?php echo $timestamp; ?>',
                                'token': '<?php echo md5('unique_salt' . $timestamp); ?>'
                            },
                            'swf': '/uploadify/uploadify.swf',
                            'uploader': '/uploadify/uploadify.php',
                            'buttonText': '选择文件',
                            'onUploadSuccess': function(file, data, response) {
                                if ('err' == data) {
                                    alert('上传失败');
                                } else {
                                    alert('上传成功');
                                    $('#goods_img_src').attr('src', data);
                                    $('#goods_img').val(data);
                                }
                            }
                        });
                    });
                </script>
                <div>
                    内容：
                    <textarea name="goods_content" style="width:800px;height:400px;visibility:hidden;"><?php echo @$data['goods_content'] ?></textarea>
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

