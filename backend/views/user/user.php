<?php

?>
<style>
</style>
<div id="user_tool" style="padding:5px;">
    <div style="margin-bottom:5px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-text" onclick="user_tool.all();">全部</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-add-new" onclick="user_tool.add();">新增</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new" onclick="user_tool.edit();">修改</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-edit-new" onclick="user_tool.unfreeze();">解封</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="user_tool.freeze();">冻结</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-delete-new" onclick="user_tool.remove();">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-reload" onclick="user_tool.reload();">刷新</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" plain="true" iconCls="icon-redo" onclick="user_tool.redo();">取消选定</a>
    </div>
    <div style="padding:0 0 0 7px;color:#333;">
        查询帐号：<input type="text" class="textbox" name="search_account" style="width:110px;">
        创建时间从：<input type="text" name="date_from" editable="false" class="easyui-datebox"  style="width:110px;">
        到：<input type="text" name="date_to" editable="false" class="easyui-datebox"  style="width:110px;">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="user_tool.search();">查询</a>
    </div>
</div>
<table id="user"></table>


<form id="user_add" style="margin:0;padding:10px 0 0 20px;color:#333;">
    <p class="textbox-p">用户帐号：<input type="text" name="add_account" class="textbox"></p>
    <p class="textbox-p">设置密码：<input type="password" name="add_password" class="textbox"></p>
    <p class="textbox-p">再次输入：<input type="password" name="add_rpassword" validType="equalTo['input[name=add_password]']" class="textbox"></p>
    <p class="textbox-p">电子邮箱：<input type="text" name="add_mail" class="textbox"></p>
</form>

<form id="user_edit" style="margin:0;padding:10px 0 0 25px;color:#333;">
    <input type="hidden" name="id" id="mid">
    <p class="textbox-p">用户帐号：<input type="text" name="edit_account" class="textbox"></p>
    <p class="textbox-p">新的密码：<input type="password" name="edit_password" class="textbox" placeholder="密码为空则不修改"></p>
    <p class="textbox-p">再次输入：<input type="password" name="edit_rpassword" validType="equalTo['input[name=edit_password]']" class="textbox"></p>
    <p class="textbox-p">电子邮箱：<input type="text" name="edit_mail" class="textbox"></p>
</form>

<script type="text/javascript" src="js/user.js"></script>


