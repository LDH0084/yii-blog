<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '找回密码';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/login.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/login.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="content">
    <div class="inner-container">
        <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal']);?>
        <div class="form-group">
            <?=Html::label('找回帐号：' , 'account')?>
            <?=Html::textInput('account','', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <?=Html::label('电子邮箱：' , 'mail')?>
            <?=Html::textInput('mail','', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block" type="submit">确定提交</button>
        </div>
        <?=Html::endForm();?>
        <div class="tip-box">
            <h4 class="help-block">温馨提示：</h4>
            <p class="help-block">1.密码是以邮箱验证的方式找回。</p>
            <p class="help-block">2.如果您的邮箱地址也忘记，请直接联系博主。</p>
            <p class="help-block">3.amgo官方博客，期待您的加入。 <a href="<?=Url::to(['site/advice'])?>" target="_blank">意见反馈 &gt;&gt;</a></p>
        </div>
    </div>
</div>
<style>
    .tip-box {
        margin-top: 50px;
    }
</style>
<script>
    //因为页面重定向所以获取重定向地址
    var ajaxCheckFaceAddress = "<?=Url::to(['site/checkface'])?>";
</script>
