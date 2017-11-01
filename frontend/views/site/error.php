<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Url;
$this->title = '页面发生错误';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-error">
    <div class="alert alert-danger">
        <p>页面发生错误，不存在此页面或页面已丢失！<a href="<?=Url::to(['site/advice'])?>" target="_blank">反馈建议 &gt;&gt;</a></p>
    </div>
</div>
