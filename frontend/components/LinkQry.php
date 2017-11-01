<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/28
 * Time: 22:20
 */

namespace frontend\components;


use common\models\Link;

class LinkQry extends BaseQry
{

    /*
     * 获取直通车列表
     * */
    public function getLinkList()
    {
        return Link::find()->where(['status'=> 1])->select('title,link')->orderBy('sort_order ASC')->asArray()->all();
    }





























}