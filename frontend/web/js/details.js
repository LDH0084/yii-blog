/**
 * Created by Administrator on 2016/10/28 0028.
 */
$(function() {


    //用户点赞
    $('.article-like').click(function() {
        var tid = $('.tid').val();
        $.ajax({
            url: ajaxLikeAddress,
            type: 'post',
            data: {
                tid : tid
            },
            beforeSend: function() {},
            success: function(responseText) {
                if(responseText > 0) {
                    $likenum = parseInt($('.article-like span').html());
                    $('.article-like span').html($likenum+1);
                    alert('点赞成功');
                } else if (responseText == -1) {
                    alert('今天您已经点过赞了');
                } else if (responseText == -2) {
                    alert('请先登录才可点赞');
                }
            }
        })
    });

    //用户点击评论
    $(".btn-comment").click(function(){
        var _this = this;
        var tid = $('.tid').val();
        var content = $('.comment-textarea').val();
        if(content.length == 0) {
            alert('请输入评论内容');
            return false;
        }
        $(_this).button('loading').queue(function() {
            $(_this).dequeue();
            $.ajax({
                url: ajaxCommentAddress,
                type: 'post',
                data: {
                    tid: tid,
                    content: content
                },
                beforeSend: function() {

                },
                success: function(responseText) {
                    if(responseText == 0) {
                        alert('发生未知错误，刷新重试！');
                        return false;
                    }
                    var data = jQuery.parseJSON(responseText);
                    var myData=[];
                    $.each(data,function(key,value) {
                        myData.push(value);
                    });
                    for (var i = 0; i < myData.length; i++ ) {
                        //ajax插入
                        var ahtml = $('.comment-box-hide').html();
                        if(data['address']) {
                            ahtml= ahtml.replace(/#address#/g, data['address']);
                        } else {
                            ahtml= ahtml.replace(/\<em\ class=\"comment-address\">\[\ \#address\#\ \]\<\/em\>/g, '');
                        }
                        if(data['equipment'] == 1) {
                            ahtml= ahtml.replace(/#equipment#/g, '移动端用户');
                        } else {
                            ahtml= ahtml.replace(/#equipment#/g, 'PC端用户');
                        }
                        ahtml= ahtml.replace(/#content#/g, data['content']);
                        ahtml= ahtml.replace(/#pid#/g, data['id']);
                        ahtml= ahtml.replace(/#time#/g, data['create_time']);
                    }
                    $('.comment-box-n1').prepend(ahtml);
                    $('.comment-textarea').val('');
                    if($('.comment-never').length > 0) {    //如果是第一条评论
                        $('.comment-never').remove();
                    }
                    $(_this).button('reset');
                }
            })
        });
    });

    /*
    * 用户点击回复按钮出现加载框
    * */
    $(document).on('click','.comment-response',function() {
        if($(this).parent().parent().find('.thumbnail').length == 0) {
            var obj = $('.response-now-hide').html();
            $(this).parent().parent().find('.comment-response-box').append(obj);
        } else {
            $(this).parent().parent().find('.thumbnail').remove();
        }
    });

    /*
    * 用户点击回复按钮
    * */
    $(document).on('click','.btn-response',function(){
        var _this = this;
        var tid = $('.tid').val();  //文章id
        var pid = $(_this).parent().parent().parent().parent().parent().find('.pid').val();
        var content = $(_this).parent().parent().parent().parent().find('.response-textarea').val();
        if(content.length == 0) {
            alert('请输入回复内容');
            return false;
        }
        $(_this).button('loading').queue(function() {
            $(_this).dequeue();
            $.ajax({
                url: ajaxCommentAddress,
                type: 'post',
                data: {
                    tid: tid,
                    pid: pid,
                    content: content
                },
                beforeSend: function() {

                },
                success: function(responseText) {
                    if(responseText == 0) {
                        alert('发生未知错误，刷新重试！');
                        return false;
                    }
                    var data = jQuery.parseJSON(responseText);
                    var myData=[];
                    $.each(data,function(key,value) {
                        myData.push(value);
                    });
                    for (var i = 0; i < myData.length; i++ ) {
                        //ajax插入
                        var ahtml = $('.response-box-hide').html();
                        if(data['address']) {
                            ahtml= ahtml.replace(/#address#/g, data['address']);
                        } else {
                            ahtml= ahtml.replace(/\<em\ class=\"comment-address\">\[\ \#address\#\ \]\<\/em\>/g, '');
                        }
                        if(data['equipment'] == 1) {
                            ahtml= ahtml.replace(/#equipment#/g, '移动端用户');
                        } else {
                            ahtml= ahtml.replace(/#equipment#/g, 'PC端用户');
                        }
                        ahtml= ahtml.replace(/#content#/g, data['content']);
                        ahtml= ahtml.replace(/#time#/g, data['create_time']);
                    }
                    $(_this).parent().parent().parent().parent().parent().find('.response-now-box').prepend(ahtml);
                    $(_this).parent().parent().parent().parent().find('.response-textarea').val('');
                    $(_this).button('reset');
                }
            })
        });
    });


















})