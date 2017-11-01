<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use xj\uploadify\Uploadify;
?>
<style>
    .error {
        color: red;
    }
</style>
<div class="inner-container" style="margin-top: 50px;">
    <?php if(Yii::$app->session->hasFlash('success')){?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <?=Yii::$app->session->getFlash('success')?>
        </div>
    <?php }?>
    <?php if(Yii::$app->session->hasFlash('error')){?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <?=Yii::$app->session->getFlash('error')?>
        </div>
    <?php }?>
    <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal']);?>
    <div class="form-group">
        <?=Html::label('站长称呼：', 'webmaster', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'webmaster', ['class'=>'form-control']);?>
            <?=Html::error($model, 'webmaster', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('电子邮件：', 'mail', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'mail', ['class'=>'form-control']);?>
            <?=Html::error($model, 'mail', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('网站名称：', 'title', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'title', ['class'=>'form-control']);?>
            <?=Html::error($model, 'title', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('网站链接：', 'link', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'link', ['class'=>'form-control']);?>
            <?=Html::error($model, 'link', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('网站介绍：', 'describe', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextarea($model, 'describe', ['class'=>'form-control']);?>
            <?=Html::error($model, 'describe', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('排序：', 'sort_order', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'sort_order', ['class'=>'form-control']);?>
            <?=Html::error($model, 'sort_order', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('状态：' , 'status' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model , 'status' , ['1'=> '显示' , '0'=> '隐藏'] , ['class' => 'form-control'])?>
            <?=Html::error($model , 'status' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <div style="margin-top:10px" class="col-sm-9 col-sm-offset-3 col-md-11 col-md-offset-1">
            <button class="btn btn-primary" type="submit">提交</button>
        </div>
    </div>
    <?=Html::endForm();?>
</div>

<script>
    var baseUrl = "<?=\yii\helpers\Url::base()?>";
</script>


