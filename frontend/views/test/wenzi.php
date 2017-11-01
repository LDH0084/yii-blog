<?php
header('content-type:text/html;charset=utf-8;');
//引入核心库文件
include "phpqrcode/phpqrcode.php";
QRcode::png('http://www.smister.com');
//示例代码下载地址：http://pan.baidu.com/s/1kTyruRl
exit();