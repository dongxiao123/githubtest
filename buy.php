<?php
ini_set('display_errors', '0'); 
require_once('include/mysql.php');

$action = "";
if(!empty($_GET['act']) && trim($_GET['act'])!=''){$action = trim($_GET['act']);}
if($action =="total"){
	//根据商品ID、购买数量获取总价信息
	
	$goods_id 	= intval($_GET['gid']);
	$amount 	= intval($_GET['amount']);
	
	$res = array(
		'flag'	=>'0',
		'gid'	=>$goods_id,
		'amount'=>'0',
		'total'	=>'0',
		'info'	=>'',
	);
	
	$data = $con->find("select * from #__goods where id=$goods_id");
	if(empty($data)){
		$res['info']='系统错误';
		_return($res);
	}
	if(intval($data['stock'])<$amount){
		$res['amount']=$data['stock'];
		$res['total']=_total($data['price'],$res['amount']);
		$res['info']='库存限制';
		_return($res);
	}
	$total = _total($data['price'],$amount);
	$res['flag']='1';
	$res['amount']=$amount;
	$res['total']=$total;
	
	_return($res);
	
}else{
	
}

function _return($arr){
	$json = json_encode($arr);
	echo "callback_total({$json})";
	die();
}
function _total($price,$amount){
	return floatval(floatval($price) * $amount);
}
?>






