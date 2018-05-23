<?php
session_start();
require_once('include/mysql.php');
require_once('include/function.php');
require_once('del_open.php');
LYG::checklogin();


if(empty($_REQUEST['id']) || intval($_REQUEST['id'])<1){lyg::showmsg('参数错误');}
$dataid = intval($_REQUEST['id']);
$info=  $con->find("select * from #__order where id=$dataid");
if(empty($info)){lyg::showmsg('参数错误');}

$data	=$con->Excute("delete from #__order where id=$dataid limit 1");
if($data){
	header('Location:order_list.php');
}else{
	LYG::ShowMsg('删除订单失败');
}	
?>