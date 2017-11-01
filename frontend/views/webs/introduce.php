<?php
use yii\helpers\Url;
$this->registerCssFile('@web/css/introduce.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/introduce.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="introduce-header-img">
    <img src="images/slide1.jpg" class="img-responsive" alt="First slide">
</div>
<div class="container">
    <div class="row visible-on" >
        <div class="col-xs-12 col-sm-3">
            <div class="menu-box visible-md visible-lg">
                <ul>
                    <li><a href="javscript:;" class="active">关于我们</a></li>
                    <li><a href="javscript:;">网站统计</i></a></li>
                    <li><a href="javscript:;">加入我们</a></li>
                    <li><a href="javscript:;">合作伙伴</a></li>
                    <li><a href="javscript:;">免责声明</a></li>
                    <li><a href="javscript:;">站长介绍</a></li>
                </ul>
            </div>
                <form role="form" class="visible-xs visible-sm">
                    <div class="form-group">
                        <select class="form-control menu-box-select">
                            <option value="0">关于我们</option>
                            <option value="1">网站统计</option>
                            <option value="2">加入我们</option>
                            <option value="3">合作伙伴</option>
                            <option value="4">免责声明</option>
                            <option value="5">站长介绍</option>
                        </select>
                    </div>
                </form>
        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="introduce-box">
                <div class="introduce-box-n introduce-box-1 introduce-box-active">
                    <p>1、本站包括了HTML、CSS、Javascript、PHP、C、Python等各种基础编程教程。</p>
                    <p>2、同时本站主要集中了一些问题的总结，以便您的查询与更好解决问题。</p>
                    <p>3、本站致力于推广各种编程语言技术，所有资源是完全免费的，并且会根据当前互联网的变化实时更新本站内容。</p>
                    <p>4、同时本站内容如果有不足的地方，也欢迎广大编程爱好者在本站留言提供意见，意见反馈：<a href="<?=\yii\helpers\Url::to(['site/advice'])?>" target="_blank">意见反馈 &gt;&gt;</a>。</p>
                    <p>5、本站域名为： amgogo.com</p>
                    <p>6、amgo官方博客：学的不仅是技术，更是梦想！</p>
                    <p>7、amgo官方博客为amgogo与2016年搭建，目的在于记录生活，不具有任何商业行为,amgo官方博客可能转载较好的内容，但都会注明，如果侵权，可联系管理员第一时间删除，感谢您的支持。</p>
                </div>
                <div class="introduce-box-n introduce-box-2">
                    <p>技术博文累积发表：<a href="javascript:;">15 篇</a></p>
                    <p>技术博文累积评论数：<a href="javascript:;">251 条</a></p>
                    <p>技术博文累积点赞数：<a href="javascript:;">541 条</a></p>
                    <p>视频分享：<a href="javascript:;">15 个</a></p>
                    <p>留言数量：<a href="javascript:;">3604 条</a></p>
                    <p>网站累计访问数量：<a href="javascript:;">135443045 人次</a></p>
                    <p>网站注册用户：<a href="javascript:;">581 个</a></p>
                    <p>网站更新次数：<a href="javascript:;">36 次</a></p>
                    <p>网站运营天数：<a href="javascript:;">510 天</a></p>
                </div>
                <div class="introduce-box-n introduce-box-3">
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="/wp-content/uploads/2014/06/64.jpg"
                                 alt="媒体对象">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">媒体标题</h4>
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                        </div>
                    </div>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="/wp-content/uploads/2014/06/64.jpg"
                                 alt="媒体对象">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">媒体标题</h4>
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                        </div>
                    </div>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="/wp-content/uploads/2014/06/64.jpg"
                                 alt="媒体对象">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">媒体标题</h4>
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                        </div>
                    </div>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="/wp-content/uploads/2014/06/64.jpg" alt="媒体对象" />
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">媒体标题</h4>
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                        </div>
                    </div>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="/wp-content/uploads/2014/06/64.jpg"
                                 alt="媒体对象">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">媒体标题</h4>
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                            这是一些示例文本。这是一些示例文本。
                        </div>
                    </div>
                </div>
                <div class="introduce-box-n introduce-box-4">
                    <p>4</p>
                </div>
                <div class="introduce-box-n introduce-box-5">
                    <p>5</p>
                </div>
                <div class="introduce-box-n introduce-box-5">
                    <p>6</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        $('.menu-box ul li a').click(function() {
            var inum = $(this).parent().index();
            $('.menu-box-select option').eq(inum).attr('selected', true);
            $('.menu-box ul li a').removeClass('active');
            $(this).addClass('active');
            $('.introduce-box-n').hide();
            $('.introduce-box-n').eq(inum).show();
        });
        $('.menu-box-select').change(function() {
            var oval = $('.menu-box-select option:selected').val();
            $('.menu-box ul li a').removeClass('active');
            $('.menu-box ul li a').eq(oval).addClass('active');
            $('.introduce-box-n').hide();
            $('.introduce-box-n').eq(oval).show();
        })
    }
</script>
<style>
    .introduce-header-img {

    }
    .introduce-header-img img {
        min-height: 250px;
    }
    .menu-box {
        background: #fff;
        margin-bottom: 15px;
    }
    .menu-box ul {

    }
    .menu-box ul li {
        text-align: center;
    }
    .menu-box ul li a {
        display: block;
        padding: 10px 0;
        color: #999;
        border-bottom: 1px solid #fff;
        position: relative;
    }
    .menu-box ul li a.active {
        background: #4d4d4d;
        color: #fff;
        border-radius: 2px;
    }
    .menu-box ul li a:hover {
        color: #fff;
        text-decoration: none;
        background: #4d4d4d;
        border-radius: 2px;
    }
    .menu-box ul li a:active, .menu-box ul li a:focus {
        text-decoration: none;
    }
    .introduce-box {
        background: #fff;
        margin-bottom: 50px;
        min-height: 550px;
    }
    .introduce-box-n {
        padding: 5px 15px;
        display: none;
    }
    .introduce-box-n p {
        line-height: 200%;
    }
    .introduce-box-active {
        display: block;
    }
</style>