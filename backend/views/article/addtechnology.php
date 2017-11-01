<?php
use yii\helpers\Html;
use yii\helpers\Url;
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
        <?=Html::label('类型：' , 'types' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model , 'types' , \common\models\TechnologyTypes::getSelectTechnologytypes() , ['class' => 'form-control'])?>
            <?=Html::error($model , 'types' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('标题：' , 'title' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model,'title',['class'=>'form-control']);?>
            <?=Html::error($model , 'title' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('内容*：' , 'content' , ['class' =>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?= \cliff363825\kindeditor\KindEditorWidget::widget([
                'model' => $model,
                'attribute' => 'content',
                'options' => [
                ],
                'clientOptions' => [
                    'width' => '100%',
                    'height' => '500px',
                    'font' => '20px',
                    'themeType' => 'simple', // optional: default, simple, qq
                    'langType' => \cliff363825\kindeditor\KindEditorWidget::LANG_TYPE_ZH_CN, // optional: ar, en, ko, ru, zh-CN, zh-TW
                    //这里是配置上传链接
                    'uploadJson' => urldecode(Url::to(['article/upload'])),
                ],
            ]); ?>
            <?=Html::error($model , 'content')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('作者：', 'source' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model,'source',['class'=>'form-control']);?>
            <?=Html::error($model, 'source' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('阅读量：', 'readcount' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'readcount',['class'=>'form-control']);?>
            <?=Html::error($model, 'readcount' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('是否转载：', 'islink' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model, 'islink' , ['1'=> '是' , '0'=> '否'] , ['class' => 'form-control'])?>
            <?=Html::error($model, 'islink' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('转载地址：', 'link' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'link',['class'=>'form-control']);?>
            <?=Html::error($model, 'link' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('状态：' , 'status' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model , 'status' , ['1'=> '显示' , '0'=> '下架'] , ['class' => 'form-control'])?>
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


