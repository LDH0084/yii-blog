<?php

?>
<style>
</style>
<div id="manager_tool" style="padding:5px;">
    <div style="margin-bottom:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-text" onclick="manager_tool.all();">全部</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add-new" onclick="manager_tool.add();">新增</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new" onclick="manager_tool.edit();">修改</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="manager_tool.remove();">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="manager_tool.reload();">刷新</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-redo" onclick="manager_tool.redo();">取消选定</a>
    </div>
    <div style="padding:0 0 0 7px;color:#333;">
        查询帐号：<input type="text" class="textbox" name="search_account" style="width:110px;">
        创建时间从：<input type="text" name="date_from" editable="false" class="easyui-datebox"  style="width:110px;">
        到：<input type="text" name="date_to" editable="false" class="easyui-datebox"  style="width:110px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="manager_tool.search();">查询</a>
    </div>
</div>
<table id="manager"></table>


<form id="manager_add" style="margin:0;padding:10px 0 0 20px;color:#333;">
    <p class="textbox-p">管理帐号：<input type="text" name="add_account" class="textbox"></p>
    <p class="textbox-p">设置密码：<input type="password" name="add_password" class="textbox"></p>
    <p class="textbox-p">再次输入：<input type="password" name="add_rpassword" validType="equalTo['input[name=add_password]']" class="textbox"></p>
    <p class="textbox-p">管理邮箱：<input type="text" name="add_email" class="textbox"></p>
    <p class="textbox-p">管理权限：<select id="manager_rank" class="easyui-combobox" name="dept" style="width:150px;">
            <option value="1">一级权限</option>
            <option value="2">二级权限</option>
            <option value="3">三级权限</option>
            <option value="4">四级权限</option>
            <option value="5">五级权限</option>
        </select>
    </p>
</form>

<form id="manager_edit" style="margin:0;padding:10px 0 0 25px;color:#333;">
    <input type="hidden" name="id" id="mid">
    <p class="textbox-p">管理名称：<input type="text" name="edit_account" class="textbox"></p>
    <p class="textbox-p">输入密码：<input type="password" name="edit_password" class="textbox" placeholder="密码为空则不修改"></p>
    <p class="textbox-p">再次输入：<input type="password" name="edit_rpassword" validType="equalTo['input[name=edit_password]']" class="textbox"></p>
    <p class="textbox-p">管理邮箱：<input type="text" name="edit_email" class="textbox"></p>
    <p class="textbox-p">管理权限：<select id="manager_rank2" class="easyui-combobox" name="dept" style="width:150px;">
            <option value="1">一级权限</option>
            <option value="2">二级权限</option>
            <option value="3">三级权限</option>
            <option value="4">四级权限</option>
            <option value="5">五级权限</option>
        </select>
    </p>
</form>

<script type="text/javascript" src="js/manager.js"></script>


