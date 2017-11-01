<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '注册新用户页面';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/register.js', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerCssFile('@web/css/register.css', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="content">
    <div class="inner-container">
        <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal']);?>
        <div class="form-group">
            <div class="text-center">
                <div class="face-screen-box">
                    <div class="face-screen">
                        上传头像
                        <input type="file" name="face" onchange="checkFile(this)" >
                    </div>
                    <img src="<?=Url::to('@web/images/default-face.png', true)?>" class="img-circle face-default">
                </div>

            </div>
        </div>
        <div class="form-group">
            <?=Html::label('帐号：', 'account')?>
            <?=Html::activeTextInput($model, 'account', ['class'=>'form-control check-account', 'placeholder'=> '用户名2-15个字符', 'onblur'=> 'javascript:checkAccount($(this));']);?>
            <div class="has-input-error has-account-error">帐号已经存在！</div>
            <?=Html::error($model, 'account', ['class'=> 'error'])?>
        </div>
        <div class="form-group">
            <?=Html::label('电子邮箱：', 'mail')?>
            <?=Html::activeTextInput($model, 'mail', ['class'=>'form-control check-mail', 'placeholder'=> '请输入正确电子邮箱', 'onblur'=> 'javascript:checkMail($(this));']);?>
            <div class="has-input-error has-mail-error">邮箱的格式不正确！</div>
            <?=Html::error($model, 'mail', ['class'=> 'error'])?>
        </div>
        <div class="form-group">
            <?=Html::label('密码：', 'password')?>
            <?=Html::activePasswordInput($model, 'password', ['class'=> 'form-control check-password', 'placeholder'=> '请输入密码6-30个字符', 'onblur'=> 'javascript:checkPassword($(this));'])?>
            <div class="has-input-error has-password-error">密码的长度不正确！</div>
            <?=Html::error($model, 'password', ['class'=> 'error'])?>
        </div>
        <div class="form-group">
            <?=Html::label('确认密码：', 'repassword')?>
            <?=Html::activePasswordInput($model, 'repassword', ['class'=> 'form-control check-repassword', 'placeholder'=> '再次输入密码', 'onblur'=> 'javascript:checkRepassword($(this));'])?>
            <div class="has-input-error has-repassword-error">密码输入不一致！</div>
            <?=Html::error($model, 'repassword', ['class'=> 'error'])?>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block" type="submit" onclick="javascript:return checkAllData();">注册</button>
            <a href="<?=Url::to(['site/login'])?>" class="btn btn-success btn-block">已有帐号，直接登录</a>
        </div>
        <?=Html::endForm();?>
    </div>
</div>
<script type="text/javascript">

    var ajaxCheckAccount = "<?=Url::to(['site/checkaccount'])?>";

    /*
    * 检测用户名
    * */
    function checkAccount(obj)
    {
        var oaccount = obj.val();
        if(oaccount.length < 2 || oaccount.length > 15) {
            obj.parent().addClass('has-error');
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
                    obj.parent().removeClass('has-error');
                    $('.has-account-error').hide();
                } else {
                    obj.parent().addClass('has-error');
                    $('.has-account-error').show();
                }
            }
        });
    }

    /*
    * 检测邮箱
    * */
    function checkMail(obj)
    {
        var omail = obj.val();
        if(omail.length < 5 || omail.length > 35) {
            obj.parent().addClass('has-error');
            $('.has-mail-error').show();
            return false;
        }
        var pattern=/^([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if(!pattern.test(omail)){
            obj.parent().addClass('has-error');
            $('.has-mail-error').show();
            return false;
        }
        obj.parent().removeClass('has-error');
        $('.has-mail-error').hide();
    }

    /*
    * 检测密码
    * */
    function checkPassword(obj)
    {
        var opassword = obj.val();
        if(opassword.length < 6 || opassword.length > 30) {
            obj.parent().addClass('has-error');
            $('.has-password-error').show();
            return false;
        }
        obj.parent().removeClass('has-error');
        $('.has-password-error').hide();
    }

    /*
    * 检测再次输入密码
    * */
    function checkRepassword(obj)
    {
        var orepassword = obj.val();
        var opassword = $('.check-password').val();
        if(orepassword != opassword) {
            obj.parent().addClass('has-error');
            $('.has-repassword-error').show();
            return false;
        }
        obj.parent().removeClass('has-error');
        $('.has-repassword-error').hide();
    }

    /*
    * 提交表单验证
    * */
    function checkAllData()
    {
        var oaccount = $('.check-account');
        var omail = $('.check-mail');
        var opassword = $('.check-password');
        var orepassword = $('.check-repassword');
        if(oaccount.val().length == 0) {
            checkAccount(oaccount);
        }
        checkMail(omail);
        checkPassword(opassword);
        checkRepassword(orepassword);
        var flag = true;
        if($('.has-error').length > 0) {
            flag = false;
        }
        return flag;
    }










    /*
     * 上传图片，仅允许jpg 、png 、jpeg
     * */
    function checkFile(obj)
    {
        var filename = obj.value;
        var mime = filename.toLowerCase().substr(filename.lastIndexOf("."));
        if(mime != ".jpg" && mime != ".png" && mime != ".jpeg")
        {
            alert("图片上传的格式不正确");
            return false;
        } else {
            var fileSize = obj.files[0].size/1024;  //上传的图片的大小k
            if(fileSize > 2024) {   //大于2024KB ，不允许上传超过2M
                alert('图片上传的大小不能超过2M');
                return false;
            }
            var fileObj = $(obj)[0];
            var windowURL = window.URL || window.webkitURL;
            if(fileObj && fileObj.files && fileObj.files[0]){
                var dataURL = windowURL.createObjectURL(fileObj.files[0]);
                $('.face-default').attr('src', dataURL);
                $('.face-upload').val(filename);
            }
        }
    }












</script>