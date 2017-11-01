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
    <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal']);?>
    <div class="form-group">
        <?=Html::label('反馈人：' , 'name' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model , 'name' , \common\models\Technologytypes::getSelectTechnologytypes() , ['class' => 'form-control width_auto'])?>
            <?=Html::error($model , 'name' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('反馈人联系方式：' , 'contact' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeInput('text',$model,'contact',['class'=>'form-control']);?>
            <?=Html::error($model , 'contact' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('反馈人电子邮箱：' , 'mail' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeInput('text',$model,'mail',['class'=>'form-control']);?>
            <?=Html::error($model , 'mail' , ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('反馈信息*：' , 'content' , ['class' =>'control-label col-sm-2 col-md-1'])?>
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
                    'uploadJson' => urldecode(Url::to(['other/upload'])),
                ],
            ]); ?>
            <?=Html::error($model , 'content')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('状态：' , 'status' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeDropDownList($model , 'status' , ['1'=> '未回复' , '-1'=> '已回复'] , ['class' => 'form-control'])?>
            <?=Html::error($model , 'status' , ['class' => 'error'])?>
        </div>
    </div>
    <?=Html::endForm();?>
</div>

<script>
    var baseUrl = "<?=\yii\helpers\Url::base()?>";
</script>


