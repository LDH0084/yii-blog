<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/4
 * Time: 19:02
 */

namespace frontend\components;


use common\models\LinkCar;

class LinkCarQry extends BaseQry
{
    /*
     * 获取直通车列表
     * */
    public function getLinkCarList()
    {
        return LinkCar::find()->where(['status'=> 1])->select('thumbnail, link')->orderBy('sort_order ASC')->asArray()->all();
    }
}