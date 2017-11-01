/**
 * Created by Administrator on 2016/12/11.
 */
$(function() {


    $('.btn-nologin-leave').click(function(){
        var _this = this;
        var ocontent = $('.modal-submit-content').val();
        var oname = $('.modal-submit-name').val();
        var omail = $('.modal-submit-mail').val();
        if(ocontent.length < 0) {
            alert('留言不得少于5位字符');
            return false;
        }
        if(oname.length == 0) {
            $('.form-name-box').addClass('has-error');
            alert('请输入您的称呼');
            return false;
        }
        var pattern=/^([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if(!pattern.test(omail)){
            $('.form-mail-box').addClass('has-error');
            alert('请输入您的真实邮箱');
            return false;
        }
        $(_this).button('loading').queue(function() {
            $(_this).dequeue();
            $.ajax({
                url: ajaxNologinLeaveAddress,
                type: 'post',
                data: {
                    content: ocontent,
                    name: oname,
                    mail: omail
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
                        var ahtml = $('.leave-box-hide').html();
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

    $('.btn-login-leave').click(function(){
        var _this = this;
        var ocontent = $('.leave-textarea').val();
        if(ocontent.length < 5) {
            alert('留言不得少于5位字符');
            return false;
        }
        $(_this).button('loading').queue(function() {
            $(_this).dequeue();
            $.ajax({
                url: ajaxLoginLeaveAddress,
                type: 'post',
                data: {
                    content: ocontent
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
                        var ahtml = $('.leave-box-hide').html();
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
    $(document).on('click','.leave-response',function() {
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
                url: ajaxResponseAddress,
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