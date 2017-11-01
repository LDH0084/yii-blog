<?php
use yii\helpers\Url;
?>
<style>
    .textbox-p {
        margin-bottom: 5px;
    }
</style>
<div id="video_tool" style="padding:5px;">
    <div style="margin-bottom:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-text" onclick="video_tool.all();">全部</a>
        <a href="<?=Url::to(['video/addvideo'])?>" class="easyui-linkbutton" plain="true" iconCls="icon-text" target="_blank" >添加</a>
        <a href="javascript:;" class="easyui-linkbutton" plain="true" iconCls="icon-text"  onclick="video_tool.edit();">编辑</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="video_tool.remove();">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="video_tool.reload();">刷新</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-redo" onclick="video_tool.redo();">取消选定</a>
    </div>
    <div style="padding:0 0 0 7px;color:#333;">
        查询帐号：<input type="text" class="textbox" name="search_account" style="width:110px;">
        创建时间从：<input type="text" name="date_from" editable="false" class="easyui-datebox"  style="width:110px;">
        到：<input type="text" name="date_to" editable="false" class="easyui-datebox"  style="width:110px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="video_tool.search();">查询</a>
    </div>
</div>
<table id="video"></table>
<script type="text/javascript" src="js/video.js"></script>
<script>
    var baseUrl = "<?=\yii\helpers\Url::base()?>";
    var editUrl = "<?=Url::to(['video/editvideo'])?>";
</script>

