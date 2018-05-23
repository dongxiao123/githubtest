<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();

if(!empty($_POST)){		
	//修改
	$id	=$_SESSION['uid'];
		
	extract($_POST);
	
	if($pwd1!=''){
		if($pwd1 ==$pwd2){
			$result	= $con->Update("update #__user set userpwd=? where id=?",
			array(md5($pwd1),$id));
			if($result){
				LYG::ShowMsg('修改成功');
			}else{
				LYG::ShowMsg('没有更改');
			}
		}else{
			LYG::ShowMsg('两次密码输入不一致');
		}
	}else{
		LYG::ShowMsg('没有任何可修改项');
	}
	
	die();
}

	
$id	=$_SESSION['uid'];

//查询数据
$sql='select * from #__user where id='.$id;
$data	=$con->find($sql);
if(!$data || count($data)<1){
	LYG::ShowMsg('数据读取失败');
}
$one =$data;
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>


<script type='text/javascript'>
function ckf(){
	return confirm('确定修改吗？');
}
</script>
<body class="content">

<form action='' method='post' onsubmit='return ckf();'>
<table cellpadding="3" cellspacing="0" class="table-add">

    <tbody>
    	<tr>
        	<td align="right" width='100' height='36'>用户名：</td>
            <td align="left" width='*'><?php echo $one['username'];?></td>
        </tr>
		<tr>
        	<td align="right" height='36'>新密码：</td>
            <td align="left"><input class='inp' type='password' name='pwd1' placeholder=''/></td>
        </tr>
		<tr>
        	<td align="right" height='36'>确认密码：</td>
            <td align="left"><input class='inp' type='password' name='pwd2' /></td>
        </tr>
		<tr>
        	<td align="right" height='50'>　</td>
            <td align="left"><input class='sub' type='submit' value='修改'/>　<input class='reset' type='reset' value='重置'></td>
        </tr>
    </tbody>

    
</table>
</form>

</body>
</html>