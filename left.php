<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>左侧</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type='text/javascript'>
$(function(){
	$('li a').click(function(){
		$(this).parent().addClass('active').siblings('li').removeClass('active');
	});
});
</script>
</head>
<style type="text/css">
ul{ padding:20px 10px;}
li{ text-align:center; line-height:28px;}
a{ font-size:14px; color:#333; text-decoration:none;background:url(style/list2.png) no-repeat left center; background-size:11px 13px; padding-left:15px;}
li.active{ background-color:#990033;position:relative;}
li.active:after{
	content: '';
    display: block;
    position: absolute;
    right: -3px;
    top: 50%;
    background: #990033;
    width: 6px;
    height: 6px;
    margin-top: -3px;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    -o-transform: rotate(45deg);
	transform: rotate(45deg);
}
li.active a{color:#fff}
</style>
<body>

<ul>
	<li class='active'><a href="default.php" target="right">后台首页</a></li>
    <?php
       if(LYG::isAdmin()){
          echo "
          <li><a href=\"user_list.php\" target=\"right\">用户列表</a></li>
	<li><a href=\"order_list.php\" target=\"right\">订单列表</a></li>
	<li><a href=\"class_list.php\" target=\"right\">分类管理</a></li>
	<li><a href=\"goods_list.php\" target=\"right\">商品管理</a></li>
	<li><a href=\"config_email.php\" target=\"right\">邮件通知</a></li>
	<li><a href=\"getcode.php\" target=\"right\">调用代码</a></li>
	<li><a href=\"payment.php\" target=\"right\">支付方式</a></li>
	<li><a href=\"user.php\" target=\"right\">修改密码</a></li>
	<li><a href=\"log_list.php\" target=\"right\">系统日志</a></li>";
       }else{
           echo "
	<li><a href=\"order_list.php\" target=\"right\">订单列表</a></li>
	<li><a href=\"user.php\" target=\"right\">修改密码</a></li>";
       }
    ?>

</ul>
</body>
</html>