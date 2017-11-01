$(function() {


    $('#video').datagrid({
        url : baseUrl + '/index.php?r=video/videolist',
        fit : true,
        fitColumns : true,
        rownumbers : true,
        border : false,
        striped : true,
        toolbar : '#video_tool',
        pagination : true,
        pageList : [100, 200, 300, 400, 500],
        pageNumber : 1,
        pageSize : 200,
        sortName : 'create_time',
        sortOrder : 'DESC',
        columns : [[
            {
                field : 'id',
                title : '编号',
                width : 50,
                checkbox : true,
            },
            {
                field : 'title',
                title : '教程名称',
                width : 200,
            },
            {
                field : 'typescopy',
                title : '类别',
                width : 50,
            },
            {
                field : 'describe',
                title : '说明',
                width : 50,
            },
            {
                field : 'dlaccount',
                title : '链接地址',
                width : 50,
            },
            {
                field : 'dlpassword',
                title : '链接密码',
                width : 50,
            },
            {
                field : 'group',
                title : '交流群',
                width : 50,
            },
            {
                field : 'create_time',
                title : '发表时间',
                width : 100,
                sortable : true,
            },
            {
                field : 'status',
                title : '状态',
                width : 50,
                sortable : false,
                styler : function(value, rowData, rowIndex) {   //表示样式
                    if(value == '显示') {
                        return 'color:green';
                    } else {
                        return 'color:red';
                    }
                }
            },
        ]],
    });





    //调用工具
    video_tool = {
        all: function() {
            $('#video').datagrid('load', {
                title : '',
                date_from : '',
                date_to : '',
            });
            $('.textbox-text, .textbox').val('');   //清空搜索标签文字
        },
        search : function () {
            $('#video').datagrid('load', {
                title : $.trim($('input[name="search_title"]').val()),
                date_from : $('input[name="date_from"]').val(),
                date_to : $('input[name="date_to"]').val(),
            });
        },
        remove : function () {
            var rows = $('#video').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要删除所选的<strong>' + rows.length + '</strong>条记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=video/deletevideo',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#video').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data == 1) {
                                    $('#video').datagrid('loaded');
                                    $('#video').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '篇文章被成功删除！',
                                    });
                                } else if (data == -1) {
                                    $('#video').datagrid('loaded');
                                    $('#video').datagrid('reload');
                                    $.messager.alert('警告操作', '文章不存在或未知错误！', 'warning', function () {});
                                }
                            },
                        });
                    }
                });

            } else {
                $.messager.alert('警告操作', '删除操作必须至少指定一个记录！', 'warning');
            }
        },
        edit : function () {
            var rows = $('#video').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                window.open(editUrl + '&id='+rows[0].id);
            } else if (rows.length == 0) {
                $.messager.alert('警告操作', '编辑记录必须选定一条数据！', 'warning');
            }
        },
        redo : function () {
            $('#video').datagrid('unselectAll');
        },
        reload : function () {
            $('#video').datagrid('reload');
        },
    };










})