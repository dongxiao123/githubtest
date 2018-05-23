<?php
session_start();
require('include/mysql.php');
require('include/function.php');
$post=$_POST;
if(!isset($post['username']) || !isset($post['userpwd'])){
	LYG::ShowMsg('参数错误');
}

$username	=$post['username'];
$userpwd	=md5($post['userpwd']);
$data	=$con->find('select * from #__user where username=? and userpwd=?',array($username,$userpwd));

if(!empty($data)){
	$info = lyg::getip();
	lyg::writeLog("后台登陆 | {$info}");
	
	$_SESSION['uid']=$data['id'];
	$_SESSION['username']=$data['username'];
	header("Location:admin.php"); 
}else{
	LYG::ShowMsg('账号密码错误');
}
?>