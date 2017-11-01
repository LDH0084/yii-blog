/**
 * Created by Administrator on 2016/11/28.
 */
$(function() {

    //解析所有的easyui
    $.parser.parse();

    $('#link').datagrid({
        url : baseUrl + '/index.php?r=complex/linklist',
        fit : true,
        fitColumns : true,
        rownumbers : true,
        border : false,
        striped : true,
        toolbar : '#link_tool',
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
                field : 'title',
                title : '网站名称',
                width : 100
            },
            {
                field : 'webmaster',
                title : '站长',
                width : 100
            },
            {
                field : 'mail',
                title : '电子邮件',
                width : 100
            },
            {
                field : 'link',
                title : '链接地址',
                width : 100
            },
            {
                field : 'sort_order',
                title : '排序',
                width : 100,
                sortable : true
            },
            {
                field : 'statuscopy',
                title : '状态',
                width : 100,
                styler : function(value, rowData, rowIndex) {   //表示样式
                    if(value == '显示') {
                        return 'color:green';
                    } else if(value == '未处理') {
                        return 'color:blue';
                    } else {
                        return 'color:red';
                    }
                }
            },
        ]],
    });

    //调用工具
    link_tool = {
        all: function() {
            $('#link').datagrid('load', {
                account : '',
                date_from : '',
                date_to : ''
            });
            $('.textbox-text, .textbox').val('');   //清空搜索标签文字
        },
        remove : function () {
            var rows = $('#link').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确认操作', '您真的要删除所选的<strong>' + rows.length + '</strong>条记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            url : baseUrl + '/index.php?r=complex/deletelink',
                            type : 'POST',
                            data : {
                                ids : ids.join(','),
                            },
                            beforeSend : function () {
                                $('#link').datagrid('loading');
                            },
                            success : function(data, response, status) {
                                if (data > 0) {
                                    $('#link').datagrid('loaded');
                                    $('#link').datagrid('reload');
                                    $.messager.show({
                                        title : '操作提醒',
                                        msg : rows.length + '个用户被成功删除！',
                                    });
                                } else if (data == -1) {
                                    $('#link').datagrid('loaded');
                                    $('#link').datagrid('reload');
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
        edit: function() {
            var rows = $('#link').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                window.open(editUrl + '&id='+rows[0].id);
            } else if (rows.length == 0) {
                $.messager.alert('警告操作', '编辑记录必须选定一条数据！', 'warning');
            }
        },
        redo : function () {
            $('#link').datagrid('unselectAll');
        },
        reload : function () {
            $('#link').datagrid('reload');
        },
    };
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
})