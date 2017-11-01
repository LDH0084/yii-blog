$(function () {
    //解析所有的easyui
    $.parser.parse();

    $('#user').datagrid({
        url : baseUrl + '/index.php?r=user/userlist',
        fit : true,
        fitColumns : true,
        rownumbers : true,
        border : false,
        striped : true,
        toolbar : '#user_tool',
        pagination : true,
        pageList : [50, 100, 200, 300, 400],
        pageNumber : 1,
        pageSize : 100,
        sortName : 'create_time',
        sortOrder : 'DESC',
        columns : [[
            {
                field : 'id',
                title : '编号',
                width : 100,
                checkbox : true,
            },
            {
                field : 'account',
                title : '用户帐号',
                width : 100,
            },
            {
                field : 'mail',
                title : '电子邮箱',
                width : 100,
            },
            {
                field : 'create_time',
                title : '注册时间',
                width : 100,
                sortable : true,
            },
            {
                field : 'login_time',
                title : '最后登录时间',
                width : 100,
                sortable : true,
            },
            {
                field : 'login_ip',
                title : '最后登录IP',
                width : 100,
            },
            {
                field : 'statuscopy',
                title : '状态',
                width : 100,
                styler : function(value, rowData, rowIndex) {   //表示样式
                    if(value == '正常') {
                        return 'color:green';
                    } else {
                        return 'color:red';
                    }
                }
            },
        ]],
    });

    //新增用户
    $('#user_add').dialog({
        width : 320,
        height : 280,
        title : '新增用户',
        iconCls : 'icon-user-add',
        modal : true,
        closed : true,
        buttons : [
            {
                text : '提交',
                iconCls : 'icon-add-new',
                handler : function () {
                    if ($('#user_add').form('validate')) {
                        $.ajax({
                            url : baseUrl + '/index.php?r=user/adduser',
                            type : 'POST',
                            data : {
                                account : $.trim($('input[name="add_account"]').val()),
                                password : $('input[name="add_password"]').val(),
                                mail : $.trim($('input[name="add_mail"]').val()),
                            },
                            beforeSend : function () {
                                $.messager.progress({
                                    text : '正在尝试提交...',
                                });
                            },
                            success : function(data, response, status) {
                                $.messager.progress('close');
                                if (data > 0) {
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : '新增用户成功！',
                                    });
                                    $('#user_add').dialog('close');
                                    $('#user').datagrid('load');
                                } else if (data == -1) {
                                    $.messager.alert('警告操作', '用户帐号被占用！', 'warning', function () {
                                        $('input[name="add_account"]').select();
                                    });
                                } else {
                                    $.messager.alert('警告操作', '未知错误！请刷新后重新提交！', 'warning');
                                }
                            },
                        });
                    }
                }
            },
            {
                text : '取消',
                iconCls : 'icon-redo',
                handler : function () {
                    $('#user_add').dialog('close');
                }
            }
        ],
        onClose : function () {
            $('#user_add').form('reset');
        },
    });

    //修改用户
    $('#user_edit').dialog({
        width : 320,
        height : 280,
        title : '修改用户',
        iconCls : 'icon-user',
        modal : true,
        closed : true,
        buttons : [
            {
                text : '提交',
                iconCls : 'icon-edit-new',
                handler : function () {
                    if($('input[name="edit_password"]').val().length != 0 && $('input[name="edit_rpassword"]').val().length == 0) {
                        $('input[name="edit_rpassword"]').validatebox({
                            required : true,
                            missingMessage : '请再次输入用户密码',
                        });
                    }
                    if ($('#user_edit').form('validate')) {
                        $.ajax({
                            url : baseUrl + '/index.php?r=user/edituser',
                            type : 'POST',
                            data : {
                                id : $('#mid').val(),
                                account : $('input[name="edit_account"]').val(),
                                password : $('input[name="edit_password"]').val(),
                                mail : $('input[name="edit_mail"]').val(),
                            },
                            beforeSend : function () {
                                $.messager.progress({
                                    text : '正在提交数据...',
                                });
                            },
                            success : function(data, response, status) {
                                $.messager.progress('close');
                                if (data > 0) {
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : '修改用户成功！',
                                    });
                                    $('#user_edit').dialog('close');
                                    $('#user').datagrid('load');
                                } else if(data == 0) {
                                    $.messager.alert('警告操作', '没有任何资料被修改！', 'warning', function () {
                                        $('input[name="edit_account"]').select();
                                    });
                                } else if (data == -1) {
                                    $.messager.alert('警告操作', '用户名称被占用！', 'warning', function () {
                                        $('input[name="edit_account"]').select();
                                    });
                                } else {
                                    $.messager.alert('警告操作', '未知错误！', 'warning');
                                }
                            },
                        });
                    }
                }
            },
            {
                text : '取消',
                iconCls : 'icon-redo',
                handler : function () {
                    $('#user_edit').dialog('close');
                }
            }
        ],
        onClose : function () {
            $('#user_edit').form('reset');
        },
    });

    //添加自定义验证规则
    $.extend($.fn.validatebox.defaults.rules, {
        equalTo : {
            validator : function(value, param) {
                return value == $(param[0]).val();
            },
            message : '密码不一致！'
        }
    });

    $('input[name="add_account"], input[name="edit_account"]').validatebox({
        required : true,
        validType : 'length[2,20]',
        missingMessage : '请输入用户帐号',
        invalidMessage : '用户帐号必须在2-20位之间',
    });

    $('input[name="add_password"]').validatebox({
        required : true,
        validType : 'length[6,30]',
        missingMessage : '请输入用户密码',
        invalidMessage : '用户密码在6-30位之间',
    });

    $('input[name="add_rpassword"]').validatebox({
        required : true,
        missingMessage : '请再次输入用户密码',
    });

    $('input[name="add_email"], input[name="edit_email"]').validatebox({
        required : true,
        validType : 'email',
        missingMessage : '请输入电子邮件',
        invalidMessage : '电子邮件格式不正确',
    });
    $('input[name="edit_password"]').validatebox({
        validType : 'length[6,30]',
        missingMessage : '请输入用户密码',
        invalidMessage : '用户密码在6-30位之间',
    });
    $('input[name="edit_rpassword"]').validatebox({
        equalTo: $('input[name="edit_password"]').val()
    });

    //调用工具
    user_tool = {
        all: function() {
            $('#user').datagrid('load', {
                account : '',
                date_from : '',
                date_to : '',
            });
            $('.textbox-text, .textbox').val('');   //清空搜索标签文字
        },
        search : function () {
            $('#user').datagrid('load', {
                account : $.trim($('input[name="search_account"]').val()),
                date_from : $('input[name="date_from"]').val(),
                date_to : $('input[name="date_to"]').val(),
            });
        },
        remove : function () {
            var rows = $('#user').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要删除所选的<strong>' + rows.length + '</strong>个用户吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=user/deleteuser',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#user').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#user').datagrid('loaded');
                                    $('#user').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功删除！',
                                    });
                                } else if (data == -1) {
                                    $('#user').datagrid('loaded');
                                    $('#user').datagrid('reload');
                                    $.messager.alert('警告操作', '用户不存在或未知错误！', 'warning', function () {});
                                }
                            },
                        });
                    }
                });

            } else {
                $.messager.alert('警告操作', '删除操作必须至少指定一个记录！', 'warning');
            }
        },
        unfreeze : function () {
            var rows = $('#user').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要解封所选的<strong>' + rows.length + '</strong>个用户吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=user/unfreezeuser',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#user').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#user').datagrid('loaded');
                                    $('#user').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功解封！',
                                    });
                                } else if (data == -1) {
                                    $('#user').datagrid('loaded');
                                    $('#user').datagrid('reload');
                                    $.messager.alert('警告操作', '用户不存在或未知错误！', 'warning', function () {});
                                }
                            },
                        });
                    }
                });

            } else {
                $.messager.alert('警告操作', '删除操作必须至少指定一个记录！', 'warning');
            }
        },
        freeze : function () {
            var rows = $('#user').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要冻结所选的<strong>' + rows.length + '</strong>个用户吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=user/freezeuser',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#user').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#user').datagrid('loaded');
                                    $('#user').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功冻结！',
                                    });
                                } else if (data == -1) {
                                    $('#user').datagrid('loaded');
                                    $('#user').datagrid('reload');
                                    $.messager.alert('警告操作', '用户不存在或未知错误！', 'warning', function () {});
                                }
                            },
                        });
                    }
                });

            } else {
                $.messager.alert('警告操作', '删除操作必须至少指定一个记录！', 'warning');
            }
        },
        add : function () {
            $('#user_add').dialog('open');
            $('input[name="account"]').focus();
        },
        edit : function () {
            var rows = $('#user').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $('#user_edit').dialog('open');
                $.ajax({
                    url : baseUrl + '/index.php?r=user/oneuser',
                    type : 'POST',
                    data : {
                        id : rows[0].id,
                    },
                    beforeSend : function () {
                        $.messager.progress({
                            text : '正在获取信息...',
                        });
                    },
                    success : function(data) {
                        $.messager.progress('close');
                        var obj = jQuery.parseJSON(data);
                        if (data) {
                            $('#user_edit').form('load', {
                                id : obj.id,
                                edit_account : obj.account,
                                edit_mail : obj.mail,
                        });
                        }
                    },
                });
            } else if (rows.length == 0) {
                $.messager.alert('警告操作', '编辑记录必须选定一条数据！', 'warning');
            }
        },
        redo : function () {
            $('#user').datagrid('unselectAll');
        },
        reload : function () {
            $('#user').datagrid('reload');
        },
    };

















})