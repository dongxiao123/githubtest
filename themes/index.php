<?php
session_start();
require_once('../include/mysql.php');
//主题ID
$theme_name = empty($_GET['t']) || trim($_GET['t'])==''?'default':trim($_GET['t']);
if(!is_dir(dirname(__FILE__)."/themes_{$theme_name}")){
	die('error 001');
}
//分类ID
$class_id = 0;
if(empty($_GET['c']) || intval($_GET['c'])<1){
	die('error 002');
}
$class_id = intval($_GET['c']);
//商品信息
$goodsinfo = $con->select("select * from #__goods where class_id=$class_id");
//门店信息
$storeinfo = $con->select("select * from #__store order by id desc");
//宽度
$_width = "100%";
if(!empty($_GET['w'])){
	$_width = trim($_GET['w']);
}
//高度
$_height = "100px";
if(!empty($_GET['h'])){
	$_height = trim($_GET['h']);
}
//来路
$referer =isset($_SERVER["HTTP_REFERER"])?($_SERVER["HTTP_REFERER"]===''?'未知':$_SERVER["HTTP_REFERER"]):'未知';
$referer = urlencode($referer);


$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
$urlpath = $http_type . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$urlpath = substr($urlpath,0,strripos($urlpath,"/")+1);


$iframe = "<iframe src='{$urlpath}themes_{$theme_name}/?class={$class_id}&ref={$referer}' style='border:0;width:{$_width};height:{$_height}' scrolling='no'></iframe>";
echo 'document.write("'.$iframe.'");';
die();
?>