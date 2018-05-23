<?php
session_start();
require_once('include/mysql.php');
require_once('include/function.php');
require_once('del_open.php');
LYG::checklogin();

if(empty($_GET['id']) || intval($_GET['id'])<1){
	LYG::ShowMsg('参数错误');
}
$id=intval($_GET['id']);

//判断商品下是否有订单

$ddcount = $con->rowscount("select count(*) from #__order where shangpin_id=$id");
if($ddcount>0){
	LYG::ShowMsg('该商品有订单数据，暂不能删除');
}

$sql="delete from #__goods where id=$id limit 1";
$data =$con->Excute($sql);
if($data){
	header('Location:goods_list.php');
}else{
	LYG::ShowMsg('删除失败');
}	
?>