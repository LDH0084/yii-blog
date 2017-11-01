<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = '反馈建议';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .error {
        color: red;
    }
    .content {
        background: #fff;
        padding: 35px;
    }
</style>
<div class="content">
    <div class="inner-container">
        <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'addForm']);?>
        <div class="form-group">
            <?=Html::label('您的称呼：' , 'name')?>
            <?=Html::activeTextInput($model, 'name', ['class'=>'form-control check-name', 'placeholder'=> '留下您的称呼吧', 'onblur'=> 'javascript:checkName($(this));']);?>
            <?=Html::error($model, 'name', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('您的联系方式：', 'contact')?>
            <?=Html::activeTextInput($model, 'contact', ['class'=>'form-control check-contact', 'placeholder'=> '留下联系方式便于博主与您联系', 'onblur'=> 'javascript:checkContact($(this));']);?>
            <?=Html::error($model, 'contact', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('您的电子邮箱：', 'mail')?>
            <?=Html::activeTextInput($model, 'mail', ['class'=>'form-control check-mail', 'placeholder'=> '务必留下真实邮箱，博主是以发邮件的形式给您回复', 'onblur'=> 'javascript:checkMail($(this));']);?>
            <?=Html::error($model, 'mail', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <?=Html::label('反馈内容：', 'content')?>
            <?= \cliff363825\kindeditor\KindEditorWidget::widget([
                'model' => $model,
                'attribute' => 'content',
                'options' => [
                    'class'=> 'check-content'
                ],
                'clientOptions' => [
                    'width' => '100%',
                    'height' => '500px',
                    'font' => '20px',
                    'themeType' => 'simple', // optional: default, simple, qq
                    'langType' => \cliff363825\kindeditor\KindEditorWidget::LANG_TYPE_ZH_CN, // optional: ar, en, ko, ru, zh-CN, zh-TW
                    //这里是配置上传链接
                    'uploadJson' => urldecode(Url::to(['complex/upload'])),
                ],
            ]); ?>
            <?=Html::error($model , 'content', ['class'=> 'error help-block'])?>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block" type="submit" onclick="javascript:return checkAllData($(this));">确定提交</button>
        </div>
        <?=Html::endForm();?>
    </div>
</div>
<script type="text/javascript">

    /*
     * 检测称呼
     * */
    function checkName(obj)
    {
        var oname = obj.val();
        if(oname.length == 0) {
            obj.parent().addClass('has-error');
            return false;
        }
        obj.parent().removeClass('has-error');
    }

    /*
     * 检测联系方式
     * */
    function checkContact(obj)
    {
        var ocontact = obj.val();
        if(ocontact.length == 0) {
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
     * 提交表单验证
     * */
    function checkAllData(obj)
    {
        obj.button('loading').dequeue();
        var oname = $('.check-name');
        var omail = $('.check-mail');
        var ocontact = $('.check-contact');
        var contentLen = $('.check-content').val().length;
        checkName(oname);
        checkContact(ocontact);
        checkMail(omail);
        if(contentLen < 10) {
            obj.button('reset');
            alert('反馈内容不得少于10个字符');
            return false;
        }

        var flag = true;
        if($('.has-error').length > 0) {
            flag = false;
            obj.button('reset');
        }
        return flag;
    }
















</script>