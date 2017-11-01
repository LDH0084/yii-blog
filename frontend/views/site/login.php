<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '登录页面';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/login.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/login.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="content">
    <div class="inner-container">
        <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal']);?>
        <div class="form-group">
            <div class="text-center">
                <img src="<?=Url::to('@web/images/default-face.png', true)?>" class="img-circle face-default img-face">
            </div>
        </div>
        <div class="form-group">
            <?=Html::label('帐号：' , 'account')?>
            <?=Html::activeTextInput($model, 'account', ['class'=>'form-control check-face']);?>
        </div>
        <div class="form-group">
            <?=Html::label('密码：' , 'password')?>
            <?=Html::activePasswordInput($model, 'password', ['class' => 'form-control'])?>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <?=Html::activeCheckboxList($model,'keep',['1'=>'保存登录信息'])?>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block" type="submit">登录</button>
            <a href="<?=Url::to(['site/register'])?>" class="btn btn-success btn-block" type="submit">注册新用户</a>
        </div>
        <?=Html::endForm();?>
    </div>
</div>
<script>
    //因为页面重定向所以获取重定向地址
    var ajaxCheckFaceAddress = "<?=Url::to(['site/checkface'])?>";
</script>
