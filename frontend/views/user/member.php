<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/16 0016
 * Time: 16:39
 */
use yii\helpers\Url;
$this->title = '个人中心';
$this->registerCssFile('@web/css/user.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/user.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="row" >
    <div class="col-xs-12 col-sm-9">
        <?=\yii\widgets\Breadcrumbs::widget([
            'homeLink'=>[
                'label'=>'首页',
                'url' => Yii::$app->homeUrl,
            ],
            'links' => [
                '个人中心'
            ]
        ])?>
        <div class="member-box">
            <h3>回复我的：</h3>
            <div class="member-dynamic">
                <?php if(empty($responseData)) {?>
                    <p class="help-block text-center">暂时没有任何回复内容！</p>
                <?php }?>
                <?php foreach($responseData as $key => $value) {?>
                <p><em><?=date('Y/m/d H:i:s', $value['create_time'])?></em><span class="response-user"><?=$value['uidcopy']['account']?></span>在<a href="<?=Url::to(['article/technologydetails', 'id'=> $value['tidcopy']['id']])?>">《<?=$value['tidcopy']['title']?>》</a>中回复我：<?=$value['content']?></p>
                <?php }?>
                <?=\yii\widgets\LinkPager::widget([
                    'pagination' => $responsePagination,
                ])?>
            </div>
        </div>
        <div class="member-box">
            <h3>我赞过的内容：</h3>
            <div class="member-dynamic">
                <?php if(empty($likeData)) {?>
                    <p class="help-block text-center">暂时没有赞过任何内容！</p>
                <?php }?>
                <?php foreach($likeData as $key => $value) {?>
                <p><em><?=date('Y/m/d H:i:s', $value['create_time'])?></em>赞了<a href="<?=Url::to(['article/technologydetails', 'id'=> $value['tidcopy']['id']])?>">《<?=$value['tidcopy']['title']?>》</a></p>
                <?php }?>
                <?=\yii\widgets\LinkPager::widget([
                    'pagination' => $likePagination,
                ])?>
            </div>
        </div>
        <div class="member-box">
            <h3>我评论过的内容：</h3>
            <div class="member-dynamic">
                <?php if(empty($commentData)) {?>
                    <p class="help-block text-center">暂时没有评论任何内容！</p>
                <?php }?>
                <?php foreach($commentData as $key => $value) {?>
                <p><em><?=date('Y/m/d H:i:s', $value['create_time'])?></em>在<a href="<?=Url::to(['article/technologydetails', 'id'=> $value['tidcopy']['id']])?>">《<?=$value['tidcopy']['title']?>》</a>中评论：<?=$value['content']?></p>
                <?php }?>
                <?=\yii\widgets\LinkPager::widget([
                    'pagination' => $commentPagination,
                ])?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-3">
        <div class="member-box member-user">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="<?=$userData['face'] == ''? '../images/default-face.png' : base64_decode($userData['face'])?>" alt="我的头像">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?=$userData['account']?> <a href="<?=Url::to(['user/edit'])?>">[修改资料]</a></h4>
                    <p><?=$userData['signature']?></p>
                </div>
            </div>
        </div>
        <div class="member-box member-record">
            <h3>最近浏览</h3>
            <div class="record-article">
                <ul>
                    <?php foreach($readData as $key => $value) {?>
                    <li><a href="<?=Url::to(['article/technologydetails', 'id'=> $value['tidcopy']['id']])?>"><?=$value['tidcopy']['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
        <div class="member-box member-record">
            <h3>热门文章列表</h3>
            <div class="record-article">
                <ul>
                    <?php foreach($hotsData as $key => $value) {?>
                        <li><a href="<?=Url::to(['article/technologydetails', 'id'=> $value['id']])?>"><?=$value['title']?></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
</div>