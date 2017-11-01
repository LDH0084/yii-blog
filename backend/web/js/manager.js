$(function () {
    //解析所有的easyui
    $.parser.parse();

    $('#manager').datagrid({
        url : baseUrl + '/index.php?r=system/managerlist',
        fit : true,
        fitColumns : true,
        rownumbers : true,
        border : false,
        striped : true,
        toolbar : '#manager_tool',
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
                title : '管理员帐号',
                width : 100,
            },
            {
                field : 'email',
                title : '邮箱',
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
        ]],
    });

    //新增管理员
    $('#manager_add').dialog({
        width : 320,
        height : 280,
        title : '新增管理员',
        iconCls : 'icon-user-add',
        modal : true,
        closed : true,
        buttons : [
            {
                text : '提交',
                iconCls : 'icon-add-new',
                handler : function () {
                    var rank = $('#manager_rank').combobox('getValue');
                    if ($('#manager_add').form('validate')) {
                        $.ajax({
                            url : baseUrl + '/index.php?r=system/addmanager',
                            type : 'POST',
                            data : {
                                account : $.trim($('input[name="add_account"]').val()),
                                password : $('input[name="add_password"]').val(),
                                email : $.trim($('input[name="add_email"]').val()),
                                rank : rank
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
                                        msg : '新增管理员成功！',
                                    });
                                    $('#manager_add').dialog('close');
                                    $('#manager').datagrid('load');
                                } else if (data == -1) {
                                    $.messager.alert('警告操作', '管理员帐号被占用！', 'warning', function () {
                                        $('input[name="add_account"]').select();
                                    });
                                } else if (data == -2) {
                                    $.messager.alert('警告操作', '管理员邮箱被占用！', 'warning', function () {
                                        $('input[name="add_email"]').select();
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
                    $('#manager_add').dialog('close');
                }
            }
        ],
        onClose : function () {
            $('#manager_add').form('reset');
        },
    });

    //修改管理员
    $('#manager_edit').dialog({
        width : 320,
        height : 280,
        title : '修改管理员',
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
                            missingMessage : '请再次输入管理员密码',
                        });
                    }
                    if ($('#manager_edit').form('validate')) {
                        $.ajax({
                            url : baseUrl + '/index.php?r=system/editmanager',
                            type : 'POST',
                            data : {
                                id : $('#mid').val(),
                                account : $('input[name="edit_account"]').val(),
                                password : $('input[name="edit_password"]').val(),
                                email : $('input[name="edit_email"]').val(),
                                rank : $('#manager_rank2').combobox('getValue')
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
                                        msg : '修改管理员成功！',
                                    });
                                    $('#manager_edit').dialog('close');
                                    $('#manager').datagrid('load');
                                } else if(data == 0) {
                                    $.messager.alert('警告操作', '没有任何资料被修改！', 'warning', function () {
                                        $('input[name="edit_account"]').select();
                                    });
                                } else if (data == -1) {
                                    $.messager.alert('警告操作', '管理员名称被占用！', 'warning', function () {
                                        $('input[name="edit_account"]').select();
                                    });
                                } else if (data == -5) {
                                    $.messager.alert('警告操作', '管理员邮箱被占用！', 'warning', function () {});
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
                    $('#manager_edit').dialog('close');
                }
            }
        ],
        onClose : function () {
            $('#manager_edit').form('reset');
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
        missingMessage : '请输入管理员帐号',
        invalidMessage : '管理员帐号必须在2-20位之间',
    });

    $('input[name="add_password"]').validatebox({
        required : true,
        validType : 'length[6,30]',
        missingMessage : '请输入管理员密码',
        invalidMessage : '管理员密码在6-30位之间',
    });

    $('input[name="add_rpassword"]').validatebox({
        required : true,
        missingMessage : '请再次输入管理员密码',
    });

    $('input[name="add_email"], input[name="edit_email"]').validatebox({
        required : true,
        validType : 'email',
        missingMessage : '请输入电子邮件',
        invalidMessage : '电子邮件格式不正确',
    });
    $('input[name="edit_password"]').validatebox({
        validType : 'length[6,30]',
        missingMessage : '请输入管理员密码',
        invalidMessage : '管理员密码在6-30位之间',
    });
    $('input[name="edit_rpassword"]').validatebox({
        equalTo: $('input[name="edit_password"]').val()
    });

    //调用工具
    manager_tool = {
        all: function() {
            $('#manager').datagrid('load', {
                account : '',
                date_from : '',
                date_to : '',
            });
            $('.textbox-text, .textbox').val('');   //清空搜索标签文字
        },
        search : function () {
            $('#manager').datagrid('load', {
                account : $.trim($('input[name="search_account"]').val()),
                date_from : $('input[name="date_from"]').val(),
                date_to : $('input[name="date_to"]').val(),
            });
        },
        remove : function () {
            var rows = $('#manager').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要删除所选的<strong>' + rows.length + '</strong>条记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=system/deletemanager',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#manager').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#manager').datagrid('loaded');
                                    $('#manager').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功删除！',
                                    });
                                } else if (data == -1) {
                                    $('#manager').datagrid('loaded');
                                    $('#manager').datagrid('reload');
                                    $.messager.alert('警告操作', '管理员不存在或未知错误！', 'warning', function () {});
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
            $('#manager_add').dialog('open');
            $('input[name="account"]').focus();
        },
        edit : function () {
            var rows = $('#manager').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $('#manager_edit').dialog('open');
                $.ajax({
                    url : baseUrl + '/index.php?r=system/onemanager',
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
                            $('#manager_rank2').combobox('setValue', obj.rank);
                            $('#manager_edit').form('load', {
                                id : obj.id,
                                edit_account : obj.account,
                                edit_email : obj.email,
                        });
                        }
                    },
                });
            } else if (rows.length == 0) {
                $.messager.alert('警告操作', '编辑记录必须选定一条数据！', 'warning');
            }
        },
        redo : function () {
            $('#manager').datagrid('unselectAll');
        },
        reload : function () {
            $('#manager').datagrid('reload');
        },
    };

















})