<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 22:54
 */
$this->title = '我要留言';
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
$this->registerCssFile('@web/css/leave.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/leave.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="row" >
    <div class="col-xs-12 col-sm-9">
        <?=Breadcrumbs::widget([
            'homeLink'=>[
                'label'=>'首页',
                'url' => ['site/index'],
            ],
            'links' => [
                '我要留言'
            ]
        ])?>
        <div class="form-group leave-content">
            <div class="thumbnail">
                <input type="hidden" class="tid" value="<?=Yii::$app->request->get('id')?>" />
                <textarea class="form-control leave-textarea" rows="3" placeholder="请输入您的留言内容："></textarea>
                <section style="height:40px;padding:5px;">
                    <section class="btn-group pull-right">
                        <?php if(Yii::$app->session->has(User::USER_ID) && Yii::$app->session->has(User::USER_ACCOUNT)) {?>
                            <button href="javascript:;" class="btn btn-info btn-login-leave"><i class="icon-share-alt icon-white"></i> 发表留言</button>
                        <?php } else {?>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">匿名留言</button>
                        <?php }?>
                    </section>
                </section>
            </div>
            <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">最近留言</a></li>
                <li><a href="#ios" data-toggle="tab">回复最多</a></li>
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
                    <?php if(empty($leaveData)) {?>
                        <p class="help-block text-center comment-never" style="padding: 20px 0;">暂时没有任何评论</p>
                    <?php }?>
                    <?php foreach($leaveData as $key => $value) {?>
                        <div class="comment-details">
                            <div class="media">
                                <a class="pull-left comment-face">
                                    <?php if(isset($value['uidcopy']['face'])) {?>
                                        <img class="media-object" src="<?=$value['uidcopy']['face'] == ''? Url::to('@web/images/default-face.png', true) : Url::to(base64_decode($value['uidcopy']['face']), true)?>" alt="用户头像" />
                                    <?php } else {?>
                                        <img class="media-object" src="<?=Url::to('@web/images/default-face.png', true)?>" alt="用户头像" />
                                    <?php }?>
                                </a>
                                <div class="media-body">
                                    <input type="hidden" class="pid" value="<?=$value['id']?>" />
                                    <h5 class="media-heading text-primary comment-account">
                                        <?php if(isset($value['uidcopy']['account'])) {?>
                                            <?=$value['uidcopy']['account']?>
                                        <?php } else {?>
                                            <?=$value['name']?>
                                        <span class="comment-user-other">[ <?=$value['mail']?> ]</span>

                                        <?php }?>
                                        <?php if($value['address']) {?>
                                            <span class="comment-user-other">[ <?=$value['address']?> ]</span>
                                        <?php }?>
                                        <?php if($value['equipment']) {?>
                                            <span class="comment-user-other">[ <?=$value['equipment'] == '1' ? '移动端用户' : 'PC端用户';?> ]</span>
                                        <?php }?>
                                        <?php if(isset($value['uidcopy']['signature'])) {?>
                                            <?php if($value['uidcopy']['signature']) {?>
                                                <span class="comment-signature">[ <?=$value['uidcopy']['signature']?> ]</span>
                                            <?php }?>
                                        <?php }?>
                                    </h5>
                                    <p class="comment-content"><?=$value['content']?></p>
                                    <p class="comment-other">
                                        <span><?=date('Y-m-d H:i:s', $value['create_time'])?></span>
                                        <a href="javascript:;" class="leave-response"><i class="glyphicon glyphicon-share-alt"></i>回复</a>
                                    </p>
                                    <div class="comment-response-box"></div>
                                    <div class="response-now-box"></div>
                                    <?php foreach($value['childleave'] as $key2 => $value2) {?>
                                        <div class="media">
                                            <div class="pull-left comment-face">
                                                <?php if(isset($value2['uidcopy']['face'])) {?>
                                                    <img class="media-object" src="<?=$value2['uidcopy']['face'] == ''? Url::to('@web/images/default-face.png', true) : Url::to(base64_decode($value2['uidcopy']['face']), true)?>" alt="媒体对象">
                                                <?php } else {?>
                                                    <img class="media-object" src="<?=Url::to('@web/images/default-face.png', true)?>" alt="用户头像" />
                                                <?php }?>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="media-heading text-primary comment-account">
                                                    <?php if(isset($value2['uidcopy']['account'])) {?>
                                                        <?=$value2['uidcopy']['account']?>
                                                    <?php } else {?>
                                                        <?=$value2['uidcopy']?>
                                                    <?php }?>
                                                    <?php if($value2['address']) {?>
                                                        <span class="comment-user-other">[ <?=$value2['address']?> ]</span>
                                                    <?php }?>
                                                    <?php if($value2['equipment']) {?>
                                                        <span class="comment-user-other">[ <?=$value2['equipment'] == '1' ? '移动端用户' : 'PC端用户';?> ]</span>
                                                    <?php }?>
                                                    <?php if(isset($value2['uidcopy']['signature'])) {?>
                                                        <?php if($value2['uidcopy']['signature']) {?>
                                                            <span class="comment-signature">[ <?=$value2['uidcopy']['signature']?> ]</span>
                                                        <?php }?>
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
    <div class="col-xs-12 col-sm-3">
        <div class="webs-right webs-owner">
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="<?=Url::to('@web/images/face.png', true)?>" alt="媒体对象">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">amgo先生</h4>
                    <p>编程改变世界，代码书写人生！</p>
                </div>
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
            <p class="text-center" style="margin-top: 10px;"><a href="<?=Url::to(['complex/applylink'])?>" class="btn btn-info btn-block site-apply-link">友情链接申请入口</a></p>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">匿名留言</h4>
            </div>
            <div class="modal-body">
                <h4 class="help-block">需填写您的基本资料，以便站长与您联系！</h4>
                <input type="hidden" value="" class="modal-submit-content" />
                <div class="form-group form-name-box">
                    <div class="modal-box">
                        <label for="name">你的称呼</label>
                        <?=Html::textInput('name', '', ['class'=> 'form-control modal-submit-name', 'id'=> 'name', 'placeholder'=> '请输入您的称呼'])?>
                    </div>
                </div>
                <div class="form-group form-mail-box">
                    <div class="modal-box">
                        <label for="mail">邮箱地址</label>
                        <?=Html::textInput('mail', '', ['class'=> 'form-control modal-submit-mail', 'id'=> 'mail', 'placeholder'=> '请输入您的真实邮箱'])?>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-block btn-nologin-leave">确定留言</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
<div class="leave-box-hide" style="display: none;">
    <div class="comment-details">
        <div class="media">
            <a class="pull-left comment-face">
                <img class="media-object" src="<?=Yii::$app->session->get(User::USER_FACE) == ''? Url::to('@web/images/default-face.png', true) : Url::to(Yii::$app->session->get(User::USER_FACE), true)?>" alt="媒体对象">
            </a>
            <div class="media-body">
                <input type="hidden" class="pid" value="#pid#" />
                <h5 class="media-heading text-primary comment-account">
                    <?=Yii::$app->session->get(User::USER_ACCOUNT) == '' ? '匿名用户' : Yii::$app->session->get(User::USER_ACCOUNT)?>
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
                    <a href="javascript:;" class="leave-response"><i class="glyphicon glyphicon-share-alt"></i>回复</a>
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
                <?=Yii::$app->session->get(User::USER_ACCOUNT) == '' ? '匿名用户' : Yii::$app->session->get(User::USER_ACCOUNT)?>
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
    var ajaxNologinLeaveAddress = "<?=Url::to(['leave/nologinadd'])?>";
    var ajaxLoginLeaveAddress = "<?=Url::to(['leave/loginadd'])?>";
    var ajaxResponseAddress = "<?=Url::to(['leave/response'])?>";
    window.onload= function() {

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // 获取已激活选项卡的名称
            var activeTab = $(e.target).text();
            // 获取先前选项卡的名称
            var previousTab = $(e.relatedTarget).text();
            $(".active-tab span").html(activeTab);
            $(".previous-tab span").html(previousTab);
        });

        $('#myModal').on('show.bs.modal',
            function() {
                //留言字数不得少于5位
                var ocontent = $('.leave-textarea').val();
                if(ocontent.length < 5) {
                    $('.leave-content').addClass('has-error');
                    alert('留言内容至少5个字符');
                    return false;
                }
                $('.modal-submit-content').val(ocontent);
            }
        );

    }
</script>