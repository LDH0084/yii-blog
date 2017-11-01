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
        <?=Html::label('直通车名称：', 'title', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'title', ['class'=>'form-control']);?>
            <?=Html::error($model, 'title', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('链接地址：', 'link', ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <?=Html::activeTextInput($model, 'link', ['class'=>'form-control']);?>
            <?=Html::error($model, 'link', ['class' => 'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('缩略图：' , 'thumbnail' , ['class' =>'control-label col-sm-3 col-md-1'])?>
        <div class="controls col-sm-9 col-md-11">
            <div class="show-img-box"><img src="" class="show-img-box" /></div>
            <input type="file" id="thumbnail" />
            <?=Uploadify::widget([
                'url' => Url::to(['s-upload']),
                'id' => 'thumbnail',
                'csrf' => true,
                'renderTag' => false,
                'jsOptions' => [
                    'width' => 100,
                    'height' => 25,
                    'buttonText' => '上传图片',
                    'buttonCursor' => 'pointer',
                    'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
                    ),
                    'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        $('.show-img-box').attr('src' , data.fileUrl)
        $('input[name="Link[thumbnail]"]').val(data.fileUrl);
    }
}
EOF
                    ),
                ]
            ]);?>
            <?=Html::activeHiddenInput($model, 'thumbnail')?>
            <?=Html::error($model , 'thumbnail' , ['class' => 'error'])?>
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


