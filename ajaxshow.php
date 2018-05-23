<?php
ini_set('display_errors', '0'); 
//输出供展示的订单信息
require('include/mysql.php');
require('include/function.php');

$resdata = array();

if(!isset($_GET['pid']) || !is_numeric($_GET['pid'])){
	showMsg($resdata);
}
$pid = $_GET['pid'];
//得到表名
$con	=new mySQLHelper;
$tableinfo = $con->ChaXun('select * from tb_product where id='.$pid,'');
if(!is_array($tableinfo) || count($tableinfo)<1){
	showMsg($resdata);
}
$tableName = 'tb_'.$tableinfo[0]['tbname'];
//判断表是否存在
$tableinfo = $con->ChaXun("show tables like '".$tableName."'",'');
if(!$tableinfo){
	showMsg($resdata);
}

$sql	="select nickname,dianhua,chanpin from ".$tableName." where isdeleted=0 and isshow=1 and nickname<>'' order by id desc limit 0,10";
$data	=$con->ChaXun($sql,'');

for($i=0;$i<count($data);$i++){
	$resdata[] = array(
		'kehu'		=>$data[$i]['nickname'],
		'dianhua'	=>getMinTel($data[$i]['dianhua']),
		'chanpin'	=>$data[$i]['chanpin']
	);
}

showMsg($resdata);

function showMsg($arr){
	echo 'neworderlist('.json_encode($arr).')';
	exit;
}
function getMinTel($str){
	if(strlen($str)!=11){
		return '136****5623';
	}
	$a=substr($str,0,3);
	$b=substr($str,7,4);
	return $a.'****'.$b;
}

?>






