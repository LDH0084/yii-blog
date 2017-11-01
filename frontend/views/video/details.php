<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/4 0004
 * Time: 11:45
 */
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\models\User;
$this->title = '视频详情';
$this->registerCssFile('@web/css/videodetails.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/videodetails.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<?=Breadcrumbs::widget([
    'homeLink'=>[
        'label'=>'首页',
        'url' => ['site/index'],
    ],
    'links' => [
        ['label'=> '视频教程', 'url'=> ['video/course']],
        $detailsData['typescopy']
    ]
])?>
<div class="row" >
    <div class="col-xs-12 col-sm-12">
        <div class="thumbnail video-header">
            <div class="media">
                <div class="col-sm-4">
                    <a class="" href="#">
                        <img class="media-object video-img" src="http://root.amgogo.com<?=$detailsData['thumbnail']?>" alt="媒体对象" />
                    </a>
                </div>
                <div class="col-sm-8 video-details">
                    <h2 class="media-heading video-title"><span class="video-types"><?=$detailsData['typescopy']?></span><?=$detailsData['title']?></h2>
                    <p class="video-intro"><?=$detailsData['describe']?></p>
                    <p class="video-download"><strong>百度网盘：</strong><?=$detailsData['dlaccount']?>&nbsp;&nbsp;&nbsp;&nbsp;<strong>密码：</strong><?=$detailsData['dlpassword']?></p>
                    <p class="video-communicate"><strong>技术交流群：</strong><?=$detailsData['group']?></p>
                    <p class="video-private"><strong>私人QQ：</strong><?=$detailsData['private']?></p>
                </div>
            </div>
        </div>
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
<script>
    var ajaxCommentAddress = "<?=Url::to(['video/comment'])?>";
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