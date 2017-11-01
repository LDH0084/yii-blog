<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 15:34
 */
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;

$this->title = 'amgo官方博客--文章详情';
echo \yii\widgets\Breadcrumbs::widget([
    'homeLink'=>[
        'label'=>'首页',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => [
        ['label' => '技术博文' , 'url' => ['technology']],
        $detailsData['title']
    ]
]);
$this->registerCssFile('@web/css/details.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/details.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="content">
    <h3 class="article-title text-center"><?=$detailsData['title']?></h3>
    <div id="i-like" class="article-like">赞<span><?=$detailsData['likecount']?></span></div>
    <p class="article-record text-center">
        <span>作者：<?=$detailsData['source']?></span>
        <span>点赞：<a href="javascript:;"><?=$detailsData['likecount']?></a> 次</span>
        <span>评论：<a href="javascript:;"><?=$detailsData['commentcount']?></a> 次</span>
        <span>分类：<a href="<?=Url::to(['site/index', 'id'=>$detailsData['types']])?>"><?=$detailsData['typescopy']?></a></span>
        <span>发表时间：<?=date('Y-m-d H:i:s', $detailsData['create_time'])?></span>
        <span>浏览次数：<?=$detailsData['readcount']?></span>
    </p>
    <div class="article-content">
        <p><?=$detailsData['content']?></p>
        <?php if($detailsData['islink'] == '1') {?>
        <p class="article-source text-center">转载自：<a href="<?=$detailsData['link']?>" target="_blank"><?=$detailsData['link']?></a></p>
        <?php }?>
        <!--        <div class="article-reward text-center">-->
        <!--            <a href="javascript:;" data-toggle="tooltip" data-placement="left" title="支付宝打赏">支付宝打赏</a>-->
        <!--            <a href="javascript:;" data-toggle="tooltip" data-placement="right" title="微信打赏">微信打赏</a>-->
        <!--        </div>-->
    </div>

    <div class="row">
        <div class="col-md-9">
            <!--分享插件-->
            <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
        </div>
    </div>
</div>
<style>

</style>
<div class="content">
    <div class="form-group">
        <div class="thumbnail">
            <input type="hidden" class="tid" value="<?=Yii::$app->request->get('id')?>" />
            <textarea id="rl_exp_input" class="form-control comment-textarea" rows="3" placeholder="请输入您的评论："></textarea>
            <section style="height:40px;padding:5px;">
                <section class="btn-group pull-right">
                    <?php if(Yii::$app->session->has(User::USER_ID) && Yii::$app->session->has(User::USER_ACCOUNT)) {?>
                        <button href="javascript:;" class="btn btn-info btn-comment"><i class="icon-share-alt icon-white"></i> 发表评论</button>
                    <?php } else {?>
                        <button class="btn btn-danger disabled" data-toggle="tooltip" data-placement="top" title="需登录">发表评论</button>
                    <?php }?>
                </section>
            </section>
        </div>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">最新评论</a></li>
            <li><a href="#ios" data-toggle="tab">热门评论</a></li>
            <li class="dropdown">
                <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">排序 <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
                    <li><a href="#jmeter" tabindex="-1" data-toggle="tab">升序</a></li>
                    <li><a href="#ejb" tabindex="-1" data-toggle="tab">降序</a></li>
                </ul>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active comment-box-n1" id="home">
                <?php if(empty($commentData)) {?>
                    <p class="help-block text-center comment-never" style="padding: 20px 0;">暂时没有任何评论</p>
                <?php }?>
                <?php foreach($commentData as $key => $value) {?>
                    <div class="comment-details">
                        <div class="media">
                            <a class="pull-left comment-face">
                                <img class="media-object" src="<?=$value['uidcopy']['face'] == ''? Url::to('@web/images/default-face.png', true) : Url::to(base64_decode($value['uidcopy']['face']), true)?>" alt="用户头像">
                            </a>
                            <div class="media-body">
                                <input type="hidden" class="pid" value="<?=$value['id']?>" />
                                <h5 class="media-heading text-primary comment-account">
                                    <?=$value['uidcopy']['account']?>
                                    <?php if($value['address']) {?>
                                        <span class="comment-user-other">[ <?=$value['address']?> ]</span>
                                    <?php }?>
                                    <?php if($value['equipment']) {?>
                                        <span class="comment-user-other">[ <?=$value['equipment'] == '1' ? '移动端用户' : 'PC端用户';?> ]</span>
                                    <?php }?>
                                    <?php if($value['uidcopy']['signature']) {?>
                                        <span class="comment-signature">[ <?=$value['uidcopy']['signature']?> ]</span>
                                    <?php }?>
                                </h5>
                                <p class="comment-content"><?=$value['content']?></p>
                                <p class="comment-other">
                                    <span><?=date('Y-m-d H:i:s', $value['create_time'])?></span>
                                    <a href="javascript:;" class="comment-response"><i class="glyphicon glyphicon-share-alt"></i>回复</a>
                                </p>
                                <div class="comment-response-box"></div>
                                <div class="response-now-box"></div>
                                <?php foreach($value['childcomment'] as $key2 => $value2) {?>
                                    <div class="media">
                                        <div class="pull-left comment-face">
                                            <img class="media-object" src="<?=$value2['uidcopy']['face'] == ''? Url::to('@web/images/default-face.png', true) : Url::to(base64_decode($value2['uidcopy']['face']), true)?>" alt="媒体对象">
                                        </div>
                                        <div class="media-body">
                                            <h5 class="media-heading text-primary comment-account">
                                                <?=$value2['uidcopy']['account']?>
                                                <?php if($value2['address']) {?>
                                                    <span class="comment-user-other">[ <?=$value2['address']?> ]</span>
                                                <?php }?>
                                                <?php if($value2['equipment']) {?>
                                                    <span class="comment-user-other">[ <?=$value2['equipment'] == '1' ? '移动端用户' : 'PC端用户';?> ]</span>
                                                <?php }?>
                                                <?php if($value2['uidcopy']['signature']) {?>
                                                    <span class="comment-signature">[ <?=$value2['uidcopy']['signature']?> ]</span>
                                                <?php }?>
                                            </h5>
                                            <p class="comment-content"><?=$value2['content']?></p>
                                            <p class="comment-other">
                                                <span><?=date('Y-m-d H:i:s', $value2['create_time'])?></span>
                                            </p>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <div class="comment-page text-center">
                    <?=\yii\widgets\LinkPager::widget([
                        'pagination' => $pagination,
                    ])?>
                </div>
            </div>
            <div class="tab-pane fade" id="ios">
                <p>iOS is a mobile operating system developed and distributed by Apple
                    Inc. Originally released in 2007 for the iPhone, iPod Touch, and
                    Apple TV. iOS is derived from OS X, with which it shares the
                    Darwin foundation. iOS is Apple's mobile version of the
                    OS X operating system used on Apple computers.</p>
            </div>
            <div class="tab-pane fade" id="jmeter">
                <p>jMeter is an Open Source testing software. It is 100% pure
                    Java application for load and performance testing.</p>
            </div>
            <div class="tab-pane fade" id="ejb">
                <p>Enterprise Java Beans (EJB) is a development architecture
                    for building highly scalable and robust enterprise level
                    applications to be deployed on J2EE compliant
                    Application Server such as JBOSS, Web Logic etc.
                </p>
            </div>
        </div>
    </div>
</div>







<!--回复框-->
<div class="response-now-hide" style="display: none;">
    <div class="thumbnail">
        <textarea class="form-control response-textarea" rows="3" placeholder="回复：您的内容"></textarea>
        <section style="height:40px;padding:5px;">
            <section class="btn-group pull-right">
                <?php if(Yii::$app->session->has(User::USER_ID) && Yii::$app->session->has(User::USER_ACCOUNT)) {?>
                    <button href="javascript:;" class="btn btn-info btn-response"><i class="icon-share-alt icon-white"></i> 发表评论</button>
                <?php } else {?>
                    <button class="btn btn-danger disabled" data-toggle="tooltip" data-placement="top" title="需登录">发表评论</button>
                <?php }?>
            </section>
        </section>
    </div>
</div>
<!--评论ajax出现-->
<div class="comment-box-hide" style="display: none;">
    <div class="comment-details">
        <div class="media">
            <a class="pull-left comment-face">
                <img class="media-object" src="<?=Yii::$app->session->get(User::USER_FACE) == ''? Url::to('@web/images/default-face.png', true) : Url::to(Yii::$app->session->get(User::USER_FACE), true)?>" alt="媒体对象">
            </a>
            <div class="media-body">
                <input type="hidden" class="pid" value="#pid#" />
                <h5 class="media-heading text-primary comment-account">
                    <?=Yii::$app->session->get(User::USER_ACCOUNT)?>
                    <span class="comment-user-other">[ #address# ]</span>
                    <span class="comment-user-other">[ #equipment# ]</span>
                    <?php if($userData) {?>
                        <?php if($userData['signature'] != '') {?>
                            <span class="comment-signature">[ <?=$userData['signature']?> ]</span>
                        <?php }?>
                    <?php }?>
                </h5>
                <p class="comment-content">#content#</p>
                <p class="comment-other">
                    <span>#time#</span>
                    <a href="javascript:;" class="comment-response"><i class="glyphicon glyphicon-share-alt"></i>回复</a>
                </p>
                <div class="comment-response-box"></div>
                <div class="response-now-box"></div>
            </div>
        </div>
    </div>
</div>
<!--回复ajax出现-->
<div class="response-box-hide" style="display: none;">
    <div class="media">
        <div class="pull-left comment-face">
            <img class="media-object" src="<?=Yii::$app->session->get(User::USER_FACE) == ''? Url::to('@web/images/default-face.png', true) : Url::to(Yii::$app->session->get(User::USER_FACE), true)?>" alt="媒体对象">
        </div>
        <div class="media-body">
            <h5 class="media-heading text-primary comment-account">
                <?=Yii::$app->session->get(User::USER_ACCOUNT)?>
                <span class="comment-user-other">[ #address# ]</span>
                <span class="comment-user-other">[ #equipment# ]</span>
                <?php if($userData) {?>
                    <?php if($userData['signature'] != '') {?>
                        <span class="comment-signature">[ <?=$userData['signature']?> ]</span>
                    <?php }?>
                <?php }?>
            </h5>
            <p class="comment-content">#content#</p>
            <p class="comment-other">
                <span>#time#</span>
            </p>
        </div>
    </div>
</div>




<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script>
    var ajaxLikeAddress = "<?=Url::to(['article/like'])?>";
    var ajaxCommentAddress = "<?=Url::to(['article/comment'])?>";
    window.onload= function() {
        //顶部提示
        $("[data-toggle='tooltip']").tooltip();

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // 获取已激活选项卡的名称
            var activeTab = $(e.target).text();
            // 获取先前选项卡的名称
            var previousTab = $(e.relatedTarget).text();
            $(".active-tab span").html(activeTab);
            $(".previous-tab span").html(previousTab);
        });
    }
</script>






