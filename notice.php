<?php
//获取最新订单编号，用于新订单提醒
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

function showMsg($arr){
	echo json_encode($arr);
	die();
}

$re=array(
	'flag'=>'0',
	'data'=>'0'
);


$sql='select id from #__order order by id desc limit 0,1';
$data=$con->find($sql);
if($data){
	$re['flag']='1';
	$re['data']=$data['id'];
}
showMsg($re);

?>
