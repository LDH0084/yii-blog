<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '编辑用户资料';
use yii\widgets\Breadcrumbs;
$this->registerCssFile('@web/css/register.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/register.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<?=Breadcrumbs::widget([
    'homeLink'=>[
        'label'=>'首页',
        'url' => ['site/index'],
    ],
    'links' => [
        ['label'=> '个人中心', 'url'=> ['user/member']],
        '编辑用户资料'
    ]
])?>
<div class="content">
    <div class="inner-container">
        <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'addForm']);?>
        <div class="form-group">
            <div class="text-center">
                <div class="face-screen-box">
                    <div class="face-screen">
                        上传头像
                        <input type="file" name="face" onchange="checkFile(this)" >
                    </div>
                    <img src="<?=$model->face == ''? '../images/default-face.png' : base64_decode($model->face)?>" class="img-circle face-default">
                </div>

            </div>
        </div>
        <div class="form-group">
            <?=Html::label('帐号：', 'account')?>
            <?=Html::textInput('', $model->account, ['class'=>'form-control', 'disabled'=> 'true']);?>
        </div>
        <div class="form-group">
            <?=Html::label('个性签名：', 'signature')?>
            <?=Html::activeTextInput($model, 'signature', ['class'=>'form-control signature', 'placeholder'=> '长度不得超过15个字符']);?>
            <?=Html::error($model, 'signature', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('电子邮箱：', 'mail')?>
            <?=Html::activeTextInput($model, 'mail', ['class'=>'form-control mail']);?>
            <?=Html::error($model, 'mail', ['class'=> 'error help-block'])?>
        </div>
        <p class="pull-right help-block" style="margin-bottom: 20px;">
            <a href="javascript:;" onclick="editPassword(this);"><i class="glyphicon glyphicon-share-alt"></i> 修改密码</a>
        </p>
        <div class="edit-password">
            <div class="form-group">
                <?=Html::label('原密码：', 'oldpassword')?>
                <?=Html::activePasswordInput($model, 'oldpassword', ['class'=> 'form-control oldpassword', 'placeholder'=> '密码为空表示不修改'])?>
                <?=Html::error($model, 'oldpassword', ['class'=> 'error help-block'])?>
            </div>
            <div class="form-group">
                <?=Html::label('新密码：', 'password')?>
                <?=Html::activePasswordInput($model, 'password', ['class'=> 'form-control newpassword', 'placeholder'=> '密码最少为6个字符'])?>
                <?=Html::error($model, 'password', ['class'=> 'error help-block'])?>
            </div>
            <div class="form-group">
                <?=Html::label('确认密码：', 'repassword')?>
                <?=Html::activePasswordInput($model, 'repassword', ['class'=> 'form-control repassword', 'placeholder'=> '再次输入密码'])?>
                <?=Html::error($model, 'repassword', ['class'=> 'error help-block'])?>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block" type="submit" onclick="return checkUserData();">确定修改</button>
        </div>
        <?=Html::endForm();?>
    </div>
</div>
<script type="text/javascript">
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

    /*
    * 修改密码显示框
    * */
    function editPassword(obj)
    {
        var tobj = $('.edit-password');
        if(tobj.is(':hidden')) {
            tobj.show();
            $(obj).hide();
        } else {
            tobj.hide();
        }
    }

    /*
    * 检验数据
    * */
    function checkUserData () {
        var signature = $('.signature').val();
        var mail = $('.mail').val();
        var oldpassword = $('.oldpassword').val();
        var newpassword = $('.newpassword').val();
        var repassword = $('.repassword').val();
        var message = '';
        var flag = true;
        if(signature.length >= 15) {
            message = '个性签名长度不得超过15个字符';
            flag = false;
        }
        if(mail.length > 0) {
            var pattern=/^([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
            if(!pattern.test(mail)){
                message = '邮箱的格式不正确';
                flag = false;
            }
        }
        if($('.edit-password').is(':visible')) {
            if(oldpassword.length < 6) {
                message = '原密码不正确';
                flag = false;
            }
            if(newpassword.length < 6) {
                message = '密码长度不得小于6位';
                flag = false;
            }
            if(newpassword != repassword) {
                message = '两次密码输入不一致';
                flag = false;
            }
        }
        if(flag) {
            return true;
        } else {
            alert(message);
            return false;
        }
    }
</script>
<style>
    .edit-password {
        display: none;
    }
</style>