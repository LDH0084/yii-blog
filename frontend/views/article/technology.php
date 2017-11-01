<?php
use yii\helpers\Url;
$this->title = '技术博文';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/technology.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/technology.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="row" >
    <div class="col-xs-12 col-sm-12">
        <?php if(empty($technologyData)) {?>
            <p class="text-center help-block" style="padding: 50px 0;background: #fff;">很遗憾，暂时没有文章</p>
        <?php }?>
        <?php foreach($technologyData as $key => $value) {?>
            <div class="article-box">
                <div class="time-label">
                    <span class="year"><?=date('Y', $value['create_time'])?></span>
                    <span style="display:block"><?=date('m', $value['create_time'])?></span>
                    <span style="display:block"><?=date('d', $value['create_time'])?></span>
                </div>
                <div class="article-header">
                    <h3><a href="<?=Url::to(['article/technologydetails','id'=>$value['id']])?>" target="_blank"><?=$value['title']?></a></h3>
                    <p class="article-record">
                        <span>作者：<?=$value['source']?></span>
                        <span>点赞：<a href="javascript:;"><?=$value['likecount']?></a> 次</span>
                        <span>评论：<a href="javascript:;"><?=$value['commentcount']?></a> 次</span>
                        <span>分类：<a href="javascript:;"><?=$value['typescopy']?></a></span>
                        <span>发表时间：<?=date('Y-m-d H:i:s', $value['create_time'])?></span>
                        <span>浏览次数：<?=$value['readcount']?></span>
                    </p>
                </div>
                <p class="article-intro"><?=\common\components\Helper::truncate_utf8_string($value['content'],170)?> <a href="<?=Url::to(['article/technologydetails','id'=>$value['id']])?>" class="read-details">阅读原文</a></p>
            </div>
        <?php }?>
        <div class="article-page text-center">
            <?=\yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
            ])?>
        </div>
    </div>
</div>
