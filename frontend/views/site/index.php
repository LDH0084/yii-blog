<?php
$this->title = '首页';
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
$this->registerCssFile('@web/css/index.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/index.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<?php if($notice['status'] == '1') {?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">网站通知：<?=$notice['contentone']?><em><?=date('Y/m/d', $notice['create_time'])?></em></h3>
        </div>
    </div>
<?php } else if($notice['status'] == '2') {?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>注意 </strong><?=$notice['contentone']?><em><?=date('Y/m/d', $notice['create_time'])?></em></h3>
        </div>
        <div class="panel-body">
            <?=$notice['contenttwo']?>
        </div>
    </div>
<?php }?>
<div class="row" >
    <div class="col-xs-12 col-sm-9">
        <?=Breadcrumbs::widget([
            'homeLink'=>[
                'label'=>'首页',
                'url' => ['site/index'],
            ],
            'links' => [
                '网站概述'
            ]
        ])?>
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
                        <span>分类：<a href="<?=Url::to(['site/index', 'id'=>$value['types']])?>"><?=$value['typescopy']?></a></span>
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
    <div class="col-xs-12 col-sm-3">
        <div class="webs-right webs-owner">
            <?php if(!empty($userData)) {?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?=$userData['face'] == ''? Url::to('@web/images/default-face.png', true) : Url::to(base64_decode($userData['face']), true)?>" alt="媒体对象">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?=$userData['account']?></h4>
                        <p><?=$userData['signature']?></p>
                    </div>
                </div>
            <?php } else {?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?=Url::to('@web/images/face.png', true)?>" alt="媒体对象">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">amgo先生</h4>
                        <p>编程改变世界，代码书写人生！</p>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="webs-right webs-types">
            <h3>网站分类</h3>
            <div class="types-box">
                <ul>
                    <li>
                        <h5><a href="<?=Url::to(['site/index'])?>">默认全部</a></h5>
                    </li>
                    <?php foreach($techTypesData as $key => $value) {?>
                    <li>
                        <h5><a href="<?=Url::to(['site/index', 'id'=>$value['id']])?>"><?=$value['title']?></a></h5>
                        <?php foreach($value['child'] as $key2 => $value2) {?>
                        <p><em><a href="<?=Url::to(['site/index', 'id'=>$value2['id']])?>"><?=$value2['title']?></em></a></p>
                        <?php }?>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="webs-right webs-hots">
            <h3>热门文章</h3>
            <div class="hots-article">
                <ul>
                    <?php foreach($hotsData as $key => $value) {?>
                    <li><a href="<?=Url::to(['article/technologydetails', 'id'=> $value['id']])?>" target="_blank"><?=$value['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="webs-right webs-adv">
            <h3>友情链接</h3>
            <?php foreach($linkData as $key => $value) {?>
                <a href="http://<?=$value['link']?>" target="_blank" class="site-link"><?=$value['title']?></a>
            <?php }?>
            <p class="text-center" style="margin-top: 10px;"><a href="<?=Url::to(['complex/applylink'])?>" class="btn btn-info btn-block site-apply-link" target="_blank">友情链接申请入口</a></p>
        </div>
        <div class="webs-right webs-adv">
            <h3>直通车</h3>
            <?php foreach($linkCarData as $key => $value) {?>
                <p class="text-center">
                    <a href="http://<?=$value['link']?>" target="_blank">
                        <img src="http://root.amgogo.com<?=$value['thumbnail']?>" />
                    </a>
                </p>
            <?php }?>
        </div>
    </div>
</div>