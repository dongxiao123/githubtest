<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(!empty($_POST)){
	//参数校验
	extract($_POST);
	
	if(!isset( $_POST['username']) || trim($_POST['username'])==''){
		LYG::ShowMsg('用户名不能为空');
	}
    $required=array(
            'username'=>'用户名不能为空',
            'userpwd'=>'密码不能为空',
    );
	$ret=LYG::checkRequired($required);
    if ($ret !== true)
    {
        LYG::ShowMsg($ret);
    }

	
	$ex = $con->rowscount("select count(*) from #__user where username=?",array(
        $_POST['username']
	));
	if($ex>0){
		lyg::showmsg("用户名已存在");
	}

	$data = array(
		'username'		=>$_POST['username'],
		'userpwd'	=>md5($_POST['userpwd']),
		'level'		=>0,
		'shop_name'		=>$_POST['shop_name']
	);
	
	$aok = $con->add("user",$data);

	if($aok){
		LYG::ShowMsg('添加成功');
	}else{
		LYG::ShowMsg('添加失败，请重试');
	}
	
	die();
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加用户</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>

<body class="content">

<h5 class='back' onclick='history.go(-1);'><span>返回</span></h5>

<form action='' method='post'>
	<table cellpadding="3" cellspacing="0" class="table-add">
		<tbody>
			<tr>
				<td align="right" width='150' height='36'>用户名：</td>
				<td align="left" width='*'>
					<input type='text' class='inp' name='username' placeholder=''/>
				</td>
			</tr>
            <tr>
                <td align="right" height='36'>密码(默认123456)：</td>
                <td>
                    <input type="text" name="userpwd" class="inp" value="123456">
                </td>
            </tr>
			<tr>
				<td align="right" height='36'>店铺名：</td>
				<td>
					<input type="text" name="shop_name" class="inp">
				</td>
			</tr>
			<tr>
				<td align="right" height='50'>　</td>
				<td align="left"><input class='sub' type='submit' value='添加'/></td>
			</tr>
		</tbody>
	</table>
</form>

</body>
</html>