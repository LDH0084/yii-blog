$(function () {
    //解析所有的easyui
    $.parser.parse();

    $('#advice').datagrid({
        url : baseUrl + '/index.php?r=other/advicelist',
        fit : true,
        fitColumns : true,
        rownumbers : true,
        border : false,
        striped : true,
        toolbar : '#advice_tool',
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
                checkbox : true
            },
            {
                field : 'name',
                title : '反馈人',
                width : 100
            },
            {
                field : 'contact',
                title : '反馈人联系方式',
                width : 100
            },
            {
                field : 'mail',
                title : '反馈人邮箱',
                width : 100
            },
            {
                field : 'content',
                title : '反馈内容',
                width : 100
            },
            {
                field : 'create_time',
                title : '反馈时间',
                width : 100,
                sortable : true
            },
            {
                field : 'statuscopy',
                title : '状态',
                width : 100,
                styler : function(value, rowData, rowIndex) {   //表示样式
                    if(value == '未回复') {
                        return 'color:red';
                    } else {
                        return 'color:green';
                    }
                }
            },
        ]],
    });

    //调用工具
    advice_tool = {
        all: function() {
            $('#advice').datagrid('load', {
                account : '',
                date_from : '',
                date_to : '',
            });
            $('.textbox-text, .textbox').val('');   //清空搜索标签文字
        },
        search : function () {
            $('#advice').datagrid('load', {
                account : $.trim($('input[name="search_account"]').val()),
                date_from : $('input[name="date_from"]').val(),
                date_to : $('input[name="date_to"]').val(),
            });
        },
        remove : function () {
            var rows = $('#advice').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要删除所选的<strong>' + rows.length + '</strong>条记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=other/deleteadvice',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#advice').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#advice').datagrid('loaded');
                                    $('#advice').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功删除！',
                                    });
                                } else if (data == -1) {
                                    $('#advice').datagrid('loaded');
                                    $('#advice').datagrid('reload');
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
        response : function () {
            var rows = $('#advice').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要已经回复所选的<strong>' + rows.length + '</strong>条记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            if(rows[i].status == -1) {
                                $.messager.alert('警告操作', '必须是未回复的数据才可勾选！', 'warning');
                                return fasle;
                            }
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=other/responseadvice',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#advice').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#advice').datagrid('loaded');
                                    $('#advice').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '条数据被成功操作！',
                                    });
                                } else if (data == -1) {
                                    $('#advice').datagrid('loaded');
                                    $('#advice').datagrid('reload');
                                    $.messager.alert('警告操作', '数据不存在或未知错误！', 'warning', function () {});
                                }
                            },
                        });
                    }
                });

            } else {
                $.messager.alert('警告操作', '删除操作必须至少指定一个记录！', 'warning');
            }
        },
        details: function() {
            var rows = $('#advice').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                window.open(editUrl + '&id='+rows[0].id);
            } else if (rows.length == 0) {
                $.messager.alert('警告操作', '编辑记录必须选定一条数据！', 'warning');
            }
        },
        redo : function () {
            $('#advice').datagrid('unselectAll');
        },
        reload : function () {
            $('#advice').datagrid('reload');
        },
    };

















})