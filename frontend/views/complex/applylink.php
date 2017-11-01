<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '申请友情链接';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/applylink.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/applylink.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<style>
    .error {
        color: red;
    }
</style>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>注意 </strong>申请友情链接说明：</h3>
    </div>
    <div class="panel-body">
        <p class="help-block">1、申请amgo官方博客友情链接的网站必须合法，内容健康。</p>
        <p class="help-block">2、网站必须将amgo博客加入其网站的友情链接。</p>
        <p class="help-block">3、管理员每隔一段时间都会访问您的站点，请务必遵守约定。</p>
        <p class="help-block">4、任何合法的网站都可申请友情链接，并不限定为技术博客。</p>
        <p class="help-block">5、博主是一位码农，希望与您相互学习，共同进步。</p>
        <p class="help-block">6、感谢您的支持，谢谢。</p>
    </div>
</div>
<div class="content">
    <div class="inner-container">
        <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal']);?>
        <div class="form-group">
            <?=Html::label('您的称呼：' , 'webmaster')?>
            <?=Html::activeTextInput($model, 'webmaster', ['class'=>'form-control check-webmaster', 'placeholder'=> '留下您的称呼', 'onblur'=> 'javascript:checkWebmaster($(this));']);?>
            <?=Html::error($model, 'webmaster', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('您的电子邮箱：', 'mail')?>
            <?=Html::activeTextInput($model, 'mail', ['class'=>'form-control check-mail', 'placeholder'=> '务必留下真实邮箱，博主是以发邮件的形式给您回复', 'onblur'=> 'javascript:checkMail($(this));']);?>
            <?=Html::error($model, 'mail', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('网站名称：', 'title')?>
            <?=Html::activeTextInput($model, 'title', ['class'=>'form-control check-title', 'placeholder'=> '请输入您的网站名称', 'onblur'=> 'javascript:checkTitle($(this));']);?>
            <?=Html::error($model, 'title', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('网站链接：', 'link')?>
            <?=Html::activeTextInput($model, 'link', ['class'=>'form-control check-link', 'placeholder'=> '请输入您的网站链接，如：www.amgogo.com', 'onblur'=> 'javascript:checkLink($(this));']);?>
            <?=Html::error($model, 'link', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('网站介绍：', 'describe')?>
            <?=Html::activeTextarea($model, 'describe', ['class'=>'form-control check-describe', 'placeholder'=> '请输入您的网站基本简介', 'onblur'=> 'javascript:checkDescribe($(this));']);?>
            <?=Html::error($model, 'describe', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block" type="submit" onclick="javascript:return checkAllData($(this));">确定提交</button>
        </div>
        <?=Html::endForm();?>
    </div>
</div>
<script type="text/javascript">

    /*
    * 检测站长名称
    * */
    function checkWebmaster(obj)
    {
        var owebmaster = obj.val();
        if(owebmaster.length == 0) {
            obj.parent().addClass('has-error');
            return false;
        }
        obj.parent().removeClass('has-error');
    }

    /*
     * 检测邮箱
     * */
    function checkMail(obj)
    {
        var omail = obj.val();
        if(omail.length < 5 || omail.length > 35) {
            obj.parent().addClass('has-error');
            return false;
        }
        var pattern=/^([a-zA-Z0-9\._-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        if(!pattern.test(omail)){
            obj.parent().addClass('has-error');
            return false;
        }
        obj.parent().removeClass('has-error');
    }


    /*
     * 检测网站名称
     * */
    function checkTitle(obj)
    {
        var otitle = obj.val();
        if(otitle.length == 0) {
            obj.parent().addClass('has-error');
            return false;
        }
        obj.parent().removeClass('has-error');
    }

    /*
     * 检测网站链接
     * */
    function checkLink(obj)
    {
        var olink = obj.val();
        if(olink.length == 0) {
            obj.parent().addClass('has-error');
            return false;
        }
        obj.parent().removeClass('has-error');
    }

    /*
     * 检测网站介绍
     * */
    function checkDescribe(obj)
    {
        var odescribe = obj.val();
        if(odescribe.length < 5) {
            obj.parent().addClass('has-error');
            return false;
        }
        obj.parent().removeClass('has-error');
    }

    /*
     * 提交表单验证
     * */
    function checkAllData(obj)
    {
        obj.button('loading').dequeue();
        var owebmaster = $('.check-webmaster');
        var omail = $('.check-mail');
        var otitle = $('.check-title');
        var olink = $('.check-link');
        var odescribe = $('.check-describe');
        checkWebmaster(owebmaster);
        checkMail(omail);
        checkTitle(otitle);
        checkLink(olink);
        checkDescribe(odescribe);
        var flag = true;
        if($('.has-error').length > 0) {
            flag = false;
            obj.button('reset');
        }
        return flag;
    }





</script>