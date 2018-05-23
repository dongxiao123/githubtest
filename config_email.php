<?php
session_start();
require_once('include/mysql.php');
require_once('include/function.php');
require_once('include/PHPMailer/PHPMailerAutoload.php');
LYG::checklogin();

if(!empty($_POST)){
	
	extract($_POST);
	
	$isopen=intval($isopen)%2;
	$receive_email=trim($receive_email);
	$gid=trim($gid);
	$ukey=trim($ukey);
	
	$data = array(
		'isopen'=>$isopen,
		'receive_email'=>$receive_email,
		'gid'=>$gid,
		'ukey'=>$ukey,
	);
	lyg::saveConfig("json_mail.php",$data);
		
	lyg::showmsg('保存成功');
	die();
}

$email = lyg::readConfig("json_mail.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发件设置</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>


<script type='text/javascript'>

</script>
<body class="content">

<form action='' method='post'>
<table cellpadding="3" cellspacing="0" class="table-add">
    <tbody>
		<tr>
        	<td align="right" width='100'>　</td>
            <td align="left" width='*'>新订单邮件通知设置</td>
        </tr>
    	<tr>
        	<td align="right">状态：</td>
            <td align="left" width='*'>
				<input type="radio" name="isopen" value="0" id="isopen0" <?php if(intval($email['isopen'])===0){ echo "checked='checked'";}?>>
				<label for="isopen0">关闭通知</label>
				<input type="radio" name="isopen" value="1" id="isopen1" <?php if(intval($email['isopen'])===1){ echo "checked='checked'";}?>>
				<label for="isopen1">开启通知</label>
			</td>
        </tr>
		<tr>
        	<td align="right">收件邮箱：</td>
            <td align="left">
				<input class='inp' type='text' name='receive_email' placeholder="如：xxxxx@qq.com" value="<?php echo $email['receive_email'];?>"/>
			</td>
        </tr>
        <tr>
        	<td align="right">Gid：</td>
            <td align="left">
				<input class='inp' type='text' name='gid' placeholder="授权发信的账号" value="<?php echo $email['gid'];?>"/>请联系七歌工作室客服免费获取
			</td>
        </tr>
        <tr>
        	<td align="right">Ukey：</td>
            <td align="left">
				<input class='inp' type='text' name='ukey' placeholder="授权发信的密匙" value="<?php echo $email['ukey'];?>"/>
			</td>
        </tr>
		<tr>
        	<td align="right" height='50'>　</td>
            <td align="left">
				<input class='sub' type='submit' name='action' value='保存'/>
			</td>
        </tr>
    </tbody>

    
</table>
</form>

</body>
</html>