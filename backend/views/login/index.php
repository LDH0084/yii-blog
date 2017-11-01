<?php
    use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>微博系统--后台登录</title>
    <?= Html::csrfMetaTags() ?>
    <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css" />
</head>
<style type="text/css">
    #login {
        padding:6px 0 0 0;
    }
    #login p {
        height:22px;
        line-height:22px;
        padding:4px 0 0 25px;
    }
    .textbox {
        height:22px;
        padding:0 2px;
        position:relative;
        top:-1px;
    }
    .easyui-linkbutton {
        padding:0 10px;
    }
    #btn {
        text-align:center;
    }
</style>
<body>
<div id="login">
    <p>管理员帐号：<input type="text" id="account" class="textbox"></p>
    <p>管理员密码：<input type="password" id="password" class="textbox"></p>
</div>
<div id="btn">
    <a href="javascript:void(0)" class="easyui-linkbutton">登录</a>
</div>
</body>
<script type="text/javascript" src="easyui/jquery.min.js"></script>
<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js" ></script>
<script type="text/javascript" src="js/login.js"></script>
<script>
    var baseUrl = '<?=\yii\helpers\Url::base()?>';
</script>
</html>