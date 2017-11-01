/**
 * Created by Administrator on 2016/10/31 0031.
 */
$(function() {


    /*
    * 切换头像
    * */
    $('.face-screen-box').hover(function() {
        $('.face-screen').stop().animate({
            top: 0
        }, 300);
    }, function() {
        $('.face-screen').stop().animate({
            top: -100
        }, 300);
    });

    /*
    * 用户名验证
    * */
/*    $('.check-account').blur(function() {
        var _this = this;
        var oaccount = $(_this).val();
        if(oaccount.length < 2 || oaccount.length > 15) {
            $(_this).parent().addClass('has-error');
            return false;
        }
        $.ajax({
            url: ajaxCheckAccount,
            type: 'post',
            data: {
                account: oaccount
            },
            beforeSend: function() {

            },
            success: function (responseText) {
                if(responseText > 0) {
                    $(_this).parent().removeClass('has-error');
                    $('.has-account-error').hide();
                } else {
                    $(_this).parent().addClass('has-error');
                    $('.has-account-error').show();
                }
            }
        });
    });*/

    /*
    * 电子邮箱验证
    * */
/*    $('.check-mail').blur(function() {
        var _this = this;
        var omail = $(_this).val();
        if(omail.length < 5 || omail.length > 35) {
            $(_this).parent().addClass('has-error');
            $('.has-mail-error').show();
            return false;
        }
        var pattern=/^([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if(!pattern.test(omail)){
            $(_this).parent().addClass('has-error');
            $('.has-mail-error').show();
            return false;
        }
        $(_this).parent().removeClass('has-error');
        $('.has-mail-error').hide();
    });*/

    /*
    * 密码验证
    * */
    $('.check-password').blur(function() {
        var _this = this;
        var opassword = $(_this).val();
        if(opassword.length < 6 || opassword.length > 30) {
            $(_this).parent().addClass('has-error');
            $('.has-password-error').show();
            return false;
        }
        $(_this).parent().removeClass('has-error');
        $('.has-password-error').hide();
    });

    /*
    * 密码一致验证
    * */
    $('.check-repassword').blur(function() {
        var _this = this;
        var orepassword = $(_this).val();
        var opassword = $('.check-password').val();
        if(orepassword != opassword) {
            $(_this).parent().addClass('has-error');
            $('.has-repassword-error').show();
            return false;
        }
        $(_this).parent().removeClass('has-error');
        $('.has-repassword-error').hide();
    });














})