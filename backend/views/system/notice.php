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
        <?=Html::label('通知内容类型一：', 'contentone', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextarea($model, 'contentone', ['class'=>'form-control']);?>
            <?=Html::error($model, 'contentone', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('通知内容类型二：' , 'contenttwo' , ['class' =>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?= \cliff363825\kindeditor\KindEditorWidget::widget([
                'model' => $model,
                'attribute' => 'contenttwo',
                'options' => [
                ],
                'clientOptions' => [
                    'width' => '100%',
                    'height' => '500px',
                    'font' => '20px',
                    'themeType' => 'simple', // optional: default, simple, qq
                    'langType' => \cliff363825\kindeditor\KindEditorWidget::LANG_TYPE_ZH_CN, // optional: ar, en, ko, ru, zh-CN, zh-TW
                    //这里是配置上传链接
                    'uploadJson' => urldecode(Url::to(['system/upload'])),
                ],
            ]); ?>
            <?=Html::error($model , 'content')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('状态：' , 'status' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model , 'status' , ['1'=> '显示类型一', '2'=> '显示类型二' , '0'=> '隐藏'] , ['class' => 'form-control'])?>
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


