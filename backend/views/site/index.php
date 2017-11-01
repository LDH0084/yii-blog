<?php
    use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <meta http-equiv="Content-Language" content="zh-CN" />
    <meta content="all" name="robots" />
    <meta http-equiv="imagetoolbar" content="no" />
    <meta name="Generator" content="amgo官方博客,amgo官方网站,amgo个人博客,amgo个人网站">
    <meta name="author" content="amgo官方博客,amgo官方网站,amgo个人博客,amgo个人网站" />
    <meta name="Copyright" content="powered by www.amggoo.com" />
    <Meta name="classification" content="amgo官方博客,amgo官方网站,amgo个人博客,amgo个人网站">
    <title>后台</title>
    <meta name="Keywords" content=amgo官方博客,amgo官方网站,amgo个人博客,amgo个人网站" />
    <meta name="Description" content="amgo官方博客,amgo官方网站,amgo个人博客,amgo个人网站" />
    <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css" />
</head>
<style>
    .gl-logo {color: #fff;font-weight: bold;float:left;line-height: 30px;font-size: 18px;padding-left: 50px;}
    .gl-menu {color: #fff;font-weight: bold;float:right;line-height: 35px;margin-right: 50px;}
    .gl-menu a {color: #fff;font-weight: bold;margin-right: 10px;}
</style>
<body class="easyui-layout">
    <div data-options="region:'north',title:'North Title',split:true,noheader:true" style="height:40px;background:#41A4C1;overflow: hidden;">
        <div class="gl-logo">amgo官方博客后台管理</div>
        <div class="gl-menu">
            <a href="<?=Yii::$app->request->getHostInfo()?>" target="_blank">网站首页</a>
            <a href="<?=Url::to(['system/notice'])?>" target="_blank">网站通知</a>
            <a href="<?=Url::to(['system/websetting'])?>" target="_blank">网站设置</a>
            欢迎您，<a href="javascript:;"><?=Yii::$app->session->get(\common\models\Manager::MANAGER_ACCOUNT);?></a>
            <a href="<?=Url::to(['site/logout'])?>" onclick="javascript:return confirm('确定要退出吗？');">退出</a>
        </div>
    </div>
    <div data-options="region:'south',title:'South Title',split:true,noheader:true" style="height:35px;line-height:30px;text-align:center;">
        ©2009-2014 xx. 技术支持：amgo.
    </div>
    <div data-options="region:'west',title:'导航',split:true,iconCls:'icon-world'" style="width:180px;">
        <ul id="nav"></ul>
    </div>
    <div data-options="region:'center'" style="overflow:hidden;">
        <div id="tabs">
            <div title="起始页" iconCls="icon-house" style="padding:0 10px;">
                <p>欢迎来到amgo博客后台管理系统！</p>
            </div>
        </div>
    </div>










</body>
<script type="text/javascript" src="easyui/jquery.min.js"></script>
<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="easyui/locale/easyui-lang-zh_CN.js" ></script>
<script type="text/javascript" src="js/index.js"></script>
<script>
    var baseUrl = "<?=Url::base()?>";
</script>
</html> 