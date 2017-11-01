<?php
use yii\helpers\Url;
$this->registerCssFile('@web/css/introduce.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/introduce.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div id="myCarousel" class="carousel slide">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- 轮播（Carousel）项目 -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="images/slide1.jpg" alt="First slide">
        </div>
        <div class="item">
            <img src="images/slide3.jpg" alt="Second slide">
        </div>
        <div class="item">
            <img src="images/slide2.jpg" alt="Third slide">
        </div>
    </div>
    <!-- 轮播（Carousel）导航 -->
    <a class="carousel-control left" href="#myCarousel"
       data-slide="prev">&lsaquo;
    </a>
    <a class="carousel-control right" href="#myCarousel"
       data-slide="next">&rsaquo;
    </a>
</div>
<div class="container">
    <div class="row" >
        <div class="col-xs-12">
            <div class="introduce-box">
                <div class="introduce-box-n">
                    <h2 class="text-center"><a href="javscript:;">关于我们</a></h2>
                    <p class="text-center help-block">amgo官方博客为amgogo与2016年搭建，目的在于记录生活，不具有任何商业行为,amgo官方博客可能转载较好的内容，但都会注明，如果侵权，可联系管理员第一时间删除，感谢您的支持。</p>
                </div>
                <div class="introduce-box-n">
                    <h2 class="text-center"><a href="javscript:;">免责声明</a></h2>
                    <div class="text-center help-block word-box">
                        <p>本站致力于推广各种编程语言技术，所有资源是完全免费的，并且会根据当前互联网的变化实时更新本站内容。</p>
                        <p>同时本站内容如果有不足的地方，也欢迎广大编程爱好者在本站留言提供意见，意见反馈：<a href="<?=\yii\helpers\Url::to(['site/advice'])?>" target="_blank">意见反馈 &gt;&gt;</a>。</p>
                        <p>本站包括了HTML、CSS、Javascript、PHP、C、Python等各种基础编程教程。</p>
                        <p>同时本站主要集中了一些问题的总结，以便您的查询与更好解决问题。</p>
                        <p>amgo官方博客：学的不仅是技术，更是梦想！</p>
                        <p>本站域名为： amgogo.com</p>
                        <p>记住：分享与快乐！</p>


                    </div>
                    <p class="clearfix"></p>
                </div>
                <div class="introduce-box-n">
                    <h2 class="text-center"><a href="javscript:;">amgo旗下网站</a></h2>
                    <p class="text-link text-center">
                        <a href="javascript:;">IT门户</a>
                        <a href="javascript:;">amgo官方网站</a>
                        <a href="javascript:;">amgo企业招聘网站</a>
                        <a href="javascript:;">IT门户</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload= function() {
        $('.carousel').carousel({
            interval: 5000
        })
    }
</script>