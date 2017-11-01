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
    <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'addForm']);?>
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
        <?=Html::label('网站名称：' , 'title' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'title', ['class'=>'form-control']);?>
            <?=Html::error($model, 'title' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('关键字：', 'keyword', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'keyword', ['class'=>'form-control']);?>
            <?=Html::error($model, 'keyword', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('网站描述：' , 'description' , ['class' =>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeTextarea($model, 'description', ['class'=>'form-control'])?>
            <?=Html::error($model , 'description')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('版权：', 'copyright', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'copyright', ['class'=>'form-control']);?>
            <?=Html::error($model, 'copyright', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('网站作者：', 'author', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'author', ['class'=>'form-control']);?>
            <?=Html::error($model, 'author', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('网站制作工具：', 'generator', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'generator', ['class'=>'form-control']);?>
            <?=Html::error($model, 'generator', ['class' => 'error'])?>
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


