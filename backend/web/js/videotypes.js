$(function () {
    //解析所有的easyui
    $.parser.parse();

    $('#videotypes').datagrid({
        url : baseUrl + '/index.php?r=video/videotypeslist',
        fit : true,
        fitColumns : true,
        rownumbers : true,
        border : false,
        striped : true,
        toolbar : '#videotypes_tool',
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
                field : 'title',
                title : '类型名称',
                width : 100,
            },
            {
                field : 'pidcopy',
                title : '所属父节点',
                width : 100,
                styler : function(value, rowData, rowIndex) {   //表示样式
                    if(value == '无') {
                        return 'color:green';
                    } else {
                        return 'color:#8B4513';
                    }
                }
            },
        ]],
    });

    //新增管理员
    $('#videotypes_add').dialog({
        width : 320,
        height : 200,
        title : '新增管理员',
        iconCls : 'icon-user-add',
        modal : true,
        closed : true,
        buttons : [
            {
                text : '提交',
                iconCls : 'icon-add-new',
                handler : function () {
                    var pid = $('#videotypes_pid').combobox('getValue');
                    if ($('#videotypes_add').form('validate')) {
                        $.ajax({
                            url : baseUrl + '/index.php?r=video/addvideotypes',
                            type : 'POST',
                            data : {
                                pid : pid,
                                title : $.trim($('input[name="add_title"]').val())
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
                                        msg : '新增技术博文分类成功！',
                                    });
                                    $('#videotypes_add').dialog('close');
                                    $('#videotypes').datagrid('load');
                                } else if (data == -1) {
                                    $.messager.alert('警告操作', '技术博文分类被占用！', 'warning', function () {
                                        $('input[name="add_title"]').select();
                                    });
                                }else {
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
                    $('#videotypes_add').dialog('close');
                }
            }
        ],
        onClose : function () {
            $('#videotypes_add').form('reset');
        },
    });

    //修改管理员
    $('#videotypes_edit').dialog({
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
                    $.ajax({
                        url : baseUrl + '/index.php?r=video/editvideotypes',
                        type : 'POST',
                        data : {
                            id : $('#mid').val(),
                            title : $('input[name="edit_title"]').val(),
                            pid : $('#videotypes_pid2').combobox('getValue')
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
                                    msg : '修改技术博文分类成功！',
                                });
                                $('#videotypes_edit').dialog('close');
                                $('#videotypes').datagrid('load');
                            } else if(data == 0) {
                                $.messager.alert('警告操作', '没有任何资料被修改！', 'warning', function () {
                                    $('input[name="edit_title"]').select();
                                });
                            } else if (data == -1) {
                                $.messager.alert('警告操作', '技术博文分类名称被占用！', 'warning', function () {
                                    $('input[name="edit_title"]').select();
                                });
                            } else {
                                $.messager.alert('警告操作', '未知错误！', 'warning');
                            }
                        },
                    });
                }
            },
            {
                text : '取消',
                iconCls : 'icon-redo',
                handler : function () {
                    $('#videotypes_edit').dialog('close');
                }
            }
        ],
        onClose : function () {
            $('#videotypes_edit').form('reset');
        },
    });


    //调用工具
    videotypes_tool = {
        all: function() {
            $('#videotypes').datagrid('load', {
                account : '',
                date_from : '',
                date_to : '',
            });
            $('.textbox-text, .textbox').val('');   //清空搜索标签文字
        },
        search : function () {
            $('#videotypes').datagrid('load', {
                account : $.trim($('input[name="search_account"]').val()),
                date_from : $('input[name="date_from"]').val(),
                date_to : $('input[name="date_to"]').val(),
            });
        },
        remove : function () {
            var rows = $('#videotypes').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要删除所选的<strong>' + rows.length + '</strong>条记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=video/deletevideotypes',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#videotypes').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#videotypes').datagrid('loaded');
                                    $('#videotypes').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功删除！',
                                    });
                                } else if (data == -1) {
                                    $('#videotypes').datagrid('loaded');
                                    $('#videotypes').datagrid('reload');
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
            $('#videotypes_add').dialog('open');
            $('input[name="account"]').focus();
        },
        edit : function () {
            var rows = $('#videotypes').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $('#videotypes_edit').dialog('open');
                $.ajax({
                    url : baseUrl + '/index.php?r=video/onevideotypes',
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
                            $('#videotypes_pid2').combobox('setValue', obj.pid);
                            $('#videotypes_edit').form('load', {
                                id : obj.id,
                                edit_title : obj.title
                            });
                        }
                    },
                });
            } else if (rows.length == 0) {
                $.messager.alert('警告操作', '编辑记录必须选定一条数据！', 'warning');
            }
        },
        redo : function () {
            $('#videotypes').datagrid('unselectAll');
        },
        reload : function () {
            $('#videotypes').datagrid('reload');
        },
    };

















})