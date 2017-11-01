/**
 * Created by Administrator on 2016/10/31 0031.
 */
$(function() {


    /*
    * 用户输入用户名之后加载头像
    *
    * */
    $('.check-face').blur(function() {
        var account = $(this).val();
        $.ajax({
            url: ajaxCheckFaceAddress,
            type: 'post',
            data: {
                account: account
            },
            beforeSend: function() {},
            success: function(responseText) {
                if(responseText != -1) {
                    $('.img-face').attr('src', responseText);
                } else {

                }
            }
        })
    })













})