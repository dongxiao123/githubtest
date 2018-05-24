<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(empty($_REQUEST['id']) || intval($_REQUEST['id'])<1){lyg::showmsg('参数错误');}
$id = intval($_REQUEST['id']);
$info=  $con->find("select * from #__store where id=$id");
if(empty($info)){lyg::showmsg('参数错误');}


if(!empty($_POST)){
	//参数校验
	extract($_POST);
	
	if(empty($storename) || trim($storename)==''){
		LYG::ShowMsg('门店名不能为空');
	}
	if(empty($address) || trim($address)==''){
		LYG::ShowMsg('地址名不能为空');
	}
	$storename= trim($storename);
	$address= trim($address);
	$data = array(
		'storename'	=>$storename,
		'address'	=> $address
	);
	$ex = $con->rowscount("select count(*) from #__store where storename=? and id<>$id",array($storename));
	if($ex>0){
		lyg::showmsg("同名门店已存在");
	}
	
	$eok = $con->update("update #__store set storename=? where id=$id limit 1",$data);

	if($eok){
		LYG::ShowMsg('操作成功');
	}else{
		LYG::ShowMsg('操作失败，请重试');
	}
	die();
}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>编辑门店</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
	<input type='hidden' name='id' value='<?php echo $info['id'];?>'>
	<table cellpadding="3" cellspacing="0" class="table-add">
		<tbody>
			<tr>
				<td align="right" width='100' height='36'>门店名：</td>
				<td align="left" width='*'>
					<input type='text' class='inp' name='storename' value='<?php echo $info['storename'];?>'/>
				</td>
			</tr>
			<tr>
			<td align="right" width='100' height='36'>门店地址：</td>
			<td align="left" width='*'>
				<input type='text' class='inp' name='address' placeholder=''/>
			</td>
			</tr>
			<tr>
				<td align="right" height='50'>　</td>
				<td align="left"><input class='sub' type='submit' value='修改'/></td>
			</tr>
		</tbody>
	</table>
</form>

</body>
</html>