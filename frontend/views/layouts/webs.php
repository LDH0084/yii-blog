<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="zh-CN">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta name="Generator" content="<?=$this->params['websetting']['generator']?>">
    <meta name="author" content="<?=$this->params['websetting']['author']?>" />
    <meta name="Copyright" content="<?=$this->params['websetting']['copyright']?>" />
	<link rel="shortcut icon" href="http://www.amgogo.com/images/amgo.ico">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="Keywords" content="<?=$this->params['websetting']['keyword']?>" />
    <meta name="Description" content="<?=$this->params['websetting']['description']?>" />
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => $this->params['websetting']['title'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    ?>
    <?=Html::beginForm(['site/search'], 'get', ['class'=>'am-search-form'])?>
        <input type="text" name="keyword" class="form-control search-text" placeholder="请输入关键字" />
        <button class="btn btn-primary search-btn" type="submit">搜索</button>
    <?=Html::endForm()?>
    <?php
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        ['label' => '技术博文', 'url' => ['/article/technology']],
        ['label' => '视频教程', 'url' => ['/video/course']],
        ['label' => '我要留言', 'url' => ['/leave/index']],
        ['label' => '关于我们', 'url' => ['/webs/introduce']],
    ];
    if (Yii::$app->session->has(User::USER_ID) && Yii::$app->session->has(User::USER_ACCOUNT)) {
        $menuItems[] = '<li class="dropdown"><a href="#"class="dropdown-toggle" data-toggle="dropdown">'.
            Yii::$app->session->get(User::USER_ACCOUNT).'<b class="caret"></b></a><ul class="dropdown-menu"><li><a href="'.
            Url::to(['user/member']).'">个人信息</a></li><li><a href="'.
            Url::to(['user/logout']).'">退出</a></li></ul></li>';
    } else {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
        <?= Breadcrumbs::widget([
            'homeLink' => [
                'label' => '<i class="fa fa-home m-r-xs"></i>' . Yii::t('yii','首页'),
                'url' => Yii::$app->homeUrl, 'encode'=> false ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= date('Y') ?> amgo官方博客</p>
        <p class="pull-right">联系邮箱：jobs@amgogo.com</p>
    </div>
</footer>
<script>
    var baseUrl = "<?=Url::base()?>";
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
