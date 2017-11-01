$(function () {

    $('#nav').tree({
        url : baseUrl + '/index.php?r=site/nav',
        lines : true,
        onLoadSuccess : function (node, data) {
            var _this = this;
            if (data) {
                $(data).each(function () {
                    if (this.state == 'closed') {
                        $(_this).tree('expandAll');
                    }
                })
            } else {
                $('#nav').tree('remove', node.target);
            }
        },
        onClick : function (node) {
            if (node.url) {
                if ($('#tabs').tabs('exists', node.text)) {
                    $('#tabs').tabs('select', node.text)
                } else {
                    $('#tabs').tabs('add', {
                        title : node.text,
                        closable : true,
                        iconCls : node.iconCls,
                        href : baseUrl + '/index.php?r=' + node.url,
                    });

                }
            }
        },
    });

    $('#tabs').tabs({
        fit : true,
        border : false,
        onAdd: function(title,index){
           if(title == '网站设置') {
               $.ajax({
                   url: baseUrl + '/index.php?r=system/webscontent',
                   type: 'post',
                   data:{

                   },
                   success: function(responseText) {
                       var obj = jQuery.parseJSON(responseText);
                       setTimeout(function() {
                           $('input[name="interest"]').val(obj.interest);
                           $('input[name="reward"]').val(obj.reward);
                           $('input[name="imoney"]').val(obj.imoney);
                           $('input[name="irecommend"]').val(obj.irecommend);
                           $('input[name="mtime"]').val(obj.mtime);
                           $('input[name="sure_time"]').val(obj.sure_time);
                           $('input[name="freeze"]').val(obj.freeze);
                           $('input[name="cycle"]').val(obj.cycle);
                       },1000)
                   }
               })
           }
        }
    });


    //停机维护
    $('.stopserver').click(function() {
        $('#stop-box').slideDown();
    })



    $('.cancel').click(function() {
        $('#stop-box').hide();
    })

    $('.sure').click(function() {
        if(confirm('确定停机维护吗？')) {
            $.ajax({
                url: baseUrl + '/index.php?r=system/stopserver',
                type: 'post',
                data: {
                    intro: $('.intro').val()
                },
                beforeSend: function() {},
                success: function(responseText) {
                    if(responseText == '1') {
                        alert('网站已经关闭维修');
                        $('#stop-box').hide();
                    } else {
                        alert('未知错误');

                    }
                }
            })
        }
    })


    //网站开启
    $('.startserver').click(function() {
        if(confirm('确定要开启网站吗？')) {
            $.ajax({
                url: baseUrl + '/index.php?r=system/startserver',
                type: 'post',
                data: {},
                beforeSend : function() {

                },
                success: function(responseText) {
                    if(responseText == 1) {
                        alert('网站已经开启');
                    } else {
                        alert('未知错误');
                    }
                }
            })
        }
    })


























});