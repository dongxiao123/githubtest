<?php
ini_set('display_errors', '0'); 
session_start();
//输出供展示的订单信息
require_once('include/mysql.php');
require_once('include/function.php');
//后台用
LYG::checklogin();
$action = "";
if(!empty($_GET['act']) && trim($_GET['act'])!=''){$action = trim($_GET['act']);}
if($action =="getgoods"){
	//根据分类获取商品列表
	$class_id = intval($_GET['class_id']);
	$data = $con->select("select * from #__goods where class_id=$class_id");
	$res = array();
	foreach($data as $k=>$v){
		$res[] = array(
			'id'	=>$v['id'],
			'data'	=>$v['goods'],
		);
	}
	echo json_encode($res);
	die();
}else if($action=="setpagesize"){
	$pagesize = empty($_GET['pagesize'])?10:intval($_GET['pagesize']);
	$pagesize = $pagesize>0?$pagesize:10;
	
	$data = array('pagesize'=>$pagesize,);
	$res = array('flag'=>'0',);
	if(lyg::setjson('data_pagesize',$data)){
		$res['flag']='1';
	}
	echo json_encode($res);
	die();
}else{
	die('none');
}
?>






