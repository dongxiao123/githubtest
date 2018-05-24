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

//判断门店下是否有订单
/*$ddcount = $con->rowscount("select count(*) from #__order where attribute_id=$id");
if($ddcount>0){
	LYG::ShowMsg('该门店下有订单数据，暂不能删除');
}*/

/*//判断门店下是否有商品
$ddcount = $con->rowscount("select count(*) from #__goods where class_id=$id");
if($ddcount>0){
	LYG::ShowMsg('该门店下有商品数据，暂不能删除');
}*/


$sql="delete from #__attribute where id=$id limit 1";
$data =$con->Excute($sql);
if($data){
	header('Location:attribute_list.php');
}else{
	LYG::ShowMsg('删除失败');
}	
?>