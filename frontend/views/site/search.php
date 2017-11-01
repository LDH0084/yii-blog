<?php
$this->title = '首页';
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
$this->registerCssFile('@web/css/index.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/index.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="row" >
    <div class="col-xs-12 col-sm-9">
        <?=Breadcrumbs::widget([
            'homeLink'=>[
                'label'=>'首页',
                'url' => ['site/index'],
            ],
            'links' => [
                '关键字搜索：'. Yii::$app->request->get('keyword')
            ]
        ])?>
        <?php if(empty($searchData)) {?>
            <div class="search-tip">
                <p class="text-center help-block tip-result">很遗憾，搜索结果为空</p>
                <h4>搜索提示：</h4>
                <p>1.更少的关键字能够得到更多的结果。</p>
                <p>2.例如：搜索amgo博客，只需键入“amgo”即可获得。</p>
                <p>3.网站内容较少，博主正马不停蹄的赶工呢！</p>
                <p>4.感谢您使用本站，欢迎添加好友，一起学习成长，博主QQ：292304400。</p>
                <p>5.我要反馈信息：<a href="<?=Url::to(['complex/advice'])?>" target="_blank" style="text-decoration: underline; color: red;">反馈建议 &gt;&gt;</a></p>
            </div>
        <?php }?>
        <?php foreach($searchData as $key => $value) {?>
            <div class="article-box">
                <div class="time-label">
                    <span class="year"><?=date('Y', $value['create_time'])?></span>
                    <span style="display:block"><?=date('m', $value['create_time'])?></span>
                    <span style="display:block"><?=date('d', $value['create_time'])?></span>
                </div>
                <div class="article-header">
                    <h3><a href="<?=Url::to(['article/technologydetails','id'=>$value['id']])?>"><?=$value['title']?></a></h3>
                    <p class="article-record">
                        <span>作者：<?=$value['source']?></span>
                        <span>点赞：<a href="javascript:;"><?=$value['likecount']?></a> 次</span>
                        <span>评论：<a href="javascript:;"><?=$value['commentcount']?></a> 次</span>
                        <span>分类：<a href="javascript:;"><?=$value['typescopy']?></a></span>
                        <span>发表时间：<?=date('Y-m-d H:i:s', $value['create_time'])?></span>
                        <span>浏览次数：<?=$value['readcount']?></span>
                    </p>
                </div>
                <p class="article-intro"><?=\common\components\Helper::truncate_utf8_string($value['content'],170)?> <a href="javscript:;" class="read-details">阅读原文</a></p>
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
                        <img class="media-object" src="<?=$userData['face'] == ''? 'images/default-face.png' : base64_decode($userData['face'])?>" alt="媒体对象">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?=$userData['account']?></h4>
                        <p><?=$userData['signature']?></p>
                    </div>
                </div>
            <?php } else {?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="images/face.png" alt="媒体对象">
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
                    <li><a href="<?=Url::to(['article/technologydetails', 'id'=> $value['id']])?>"><?=$value['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="webs-right webs-adv">
            <h3>直通车</h3>
            <p class="text-center"><img src="images/advertising1.png" /></p>
            <p class="text-center"><img src="images/advertising2.png" /></p>
        </div>
    </div>
</div>
<style>
    .search-tip {
        background: #fff;
        padding: 15px;
    }
    .search-tip h4 {
        margin-bottom: 10px;
        color: #999;
        font-size: 14px;
    }
    .search-tip p {
        line-height: 180%;
        color: #999;
        font-size: 12px;
    }
    .search-tip .tip-result {
        padding: 50px 0 100px 0;
        color: #666;
        font-size: 14px;
    }
</style>