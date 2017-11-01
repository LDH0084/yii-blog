<?php
    use yii\helpers\Url;
?>
<style>
</style>
<div id="linkcar_tool" style="padding:5px;">
    <div style="margin-bottom:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-text" onclick="linkcar_tool.all();">全部</a>
        <a href="<?=Url::to(['complex/addlinkcar'])?>" target="_blank" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new">添加</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new" onclick="linkcar_tool.edit();">编辑</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="linkcar_tool.remove();">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="linkcar_tool.reload();">刷新</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-redo" onclick="linkcar_tool.redo();">取消选定</a>
    </div>
</div>
<table id="linkcar"></table>
<script type="text/javascript" src="js/linkcar.js"></script>

<script type="text/javascript">
    var editUrl = "<?=Url::to(['complex/editlinkcar'])?>";
</script>
