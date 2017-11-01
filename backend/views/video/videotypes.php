<?php

?>
<style>
</style>
<div id="videotypes_tool" style="padding:5px;">
    <div style="margin-bottom:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-text" onclick="videotypes_tool.all();">全部</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add-new" onclick="videotypes_tool.add();">新增</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new" onclick="videotypes_tool.edit();">修改</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="videotypes_tool.remove();">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="videotypes_tool.reload();">刷新</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-redo" onclick="videotypes_tool.redo();">取消选定</a>
    </div>
    <div style="padding:0 0 0 7px;color:#333;">
        查询帐号：<input type="text" class="textbox" name="search_account" style="width:110px;">
        创建时间从：<input type="text" name="date_from" editable="false" class="easyui-datebox"  style="width:110px;">
        到：<input type="text" name="date_to" editable="false" class="easyui-datebox"  style="width:110px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="videotypes_tool.search();">查询</a>
    </div>
</div>
<table id="videotypes"></table>


<form id="videotypes_add" style="margin:0;padding:10px 0 0 20px;color:#333;">
    <p class="textbox-p">节点类型：<select id="videotypes_pid" class="easyui-combobox" name="dept" style="width:150px;">
            <option value="0">父类型</option>
            <?php foreach($pidData as $key => $value) {?>
            <option value="<?=$value['id']?>"><?=$value['title']?></option>
            <?php }?>
        </select>
    </p>
    <p class="textbox-p">节点名称：<input type="text" name="add_title" class="textbox"></p>
</form>

<form id="videotypes_edit" style="margin:0;padding:10px 0 0 25px;color:#333;">
    <input type="hidden" name="id" id="mid">
    <p class="textbox-p">管理权限：<select id="videotypes_pid2" class="easyui-combobox" name="dept" style="width:150px;">
            <option value="0">父类型</option>
            <?php foreach($pidData as $key => $value) {?>
                <option value="<?=$value['id']?>"><?=$value['title']?></option>
            <?php }?>
        </select>
    </p>
    <p class="textbox-p">节点名称：<input type="text" name="edit_title" class="textbox"></p>
</form>

<script type="text/javascript" src="js/videotypes.js"></script>


