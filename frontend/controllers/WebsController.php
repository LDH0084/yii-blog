<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/28 0028
 * Time: 10:15
 */

namespace frontend\controllers;


use yii\web\Controller;

class WebsController extends CommonController
{


    /*
     * 博主介绍主页面
     * */
    public function actionIntroduce()
    {
        $this->layout = 'webs';
        return $this->render('introduce');
    }




















}