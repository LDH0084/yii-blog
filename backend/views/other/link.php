<?php
    use yii\helpers\Url;
?>
<style>
</style>
<div id="link_tool" style="padding:5px;">
    <div style="margin-bottom:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-text" onclick="link_tool.all();">全部</a>
        <a href="<?=Url::to(['other/addlink'])?>" target="_blank" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new">添加</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new" onclick="link_tool.edit();">编辑</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="link_tool.remove();">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="link_tool.reload();">刷新</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-redo" onclick="link_tool.redo();">取消选定</a>
    </div>
</div>
<table id="link"></table>
<script type="text/javascript" src="js/link.js"></script>

<script type="text/javascript">
    var editUrl = "<?=Url::to(['other/editlink'])?>";
</script>
