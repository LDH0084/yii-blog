<?php
use yii\helpers\Url;
use common\components\Helper;
$this->title = '视频教程';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/course.css', ['depends'=>['frontend\assets\AppAsset']]);
$this->registerJsFile('@web/js/course.js', ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="content">
    <?php foreach($videoData as $key => $value) {?>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="thumbnail">
            <a href="javascript:;"><img src="http://root.amgogo.com<?=$value['thumbnail']?>" /></a>
            <p class="course-intro"><?=Helper::truncate_utf8_string($value['describe'],40)?></p>
            <section style="height:35px;padding:0 5px 0 0;">
                <section class="btn-group pull-right">
                    <a href="<?=Url::to(['video/details', 'id'=> $value['id']])?>" class="btn btn-info"><i class="icon-share-alt icon-white"></i> 进入课堂</a>
                </section>
            </section>
        </div>
    </div>
    <?php }?>
    <p class="clearfix"></p>
</div>
