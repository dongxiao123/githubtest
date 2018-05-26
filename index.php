<?php
if(!empty($_POST)){
	session_start();
	require('include/mysql.php');
	require('include/function.php');
	$post=$_POST;
	if(!isset($post['username']) || !isset($post['userpwd'])){
		LYG::ShowMsg('参数错误');
	}

	$username	=$post['username'];
	$userpwd	=md5($post['userpwd']);
	$data	=$con->find('select * from #__user where username=? and userpwd=?',array($username,$userpwd));


	if(!empty($data)){
		$info = lyg::getip();
		lyg::writeLog("后台登陆 | {$info}");
		$_SESSION['uid']=$data['id'];
		$_SESSION['username']=$data['username'];
        $_SESSION['store_id']=$data['shop_name'];
		header("Location:admin.php"); 
	}else{
		LYG::ShowMsg('账号密码错误');
	}
	die();
}



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理登陆</title>
<link href="style_login/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<style type="text/css">
*{ 
	margin:0; padding:0; outline:0; font-weight:normal; font-style: normal;
	-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
body{ 
	width:100%;
	text-align: center;
	background: url(http://img.gaolb.com/project_demo/maodouu_order/<?php echo mt_rand(1,15)?>.jpg) no-repeat;
	background-size: cover;
}
.loginbox{
	position: fixed;
    width: 300px;
    margin-top: -100px;
    margin-left: -150px;
    left: 50%;
    top: 40%;
    background-color: rgba(255,255,255,0.8);
    animation: in_am .8s both;
    margin-bottom: 20px;
    border: 1px solid #073642;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.05);
    box-shadow: 0 1px 1px rgba(0,0,0,0.05);
}
.logintitle{
	text-align: center;
	color: #ffffff;
    background-color: #073642;
    border-color: #073642;
	padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}
.loginbody{
	padding: 15px;
}
.oneline{
    border-collapse: separate;
    padding-bottom:15px;
    text-align:left;
}
.oneline span{
	display: inline-block;
	width: 39px 34px;
	padding:10px 12px;
	font-size: 14px;
	line-height: 1;
	text-align: center;
    background-color: #073642;
    border: 1px solid rgba(0,0,0,0.15);
    border-radius: 4px;
}
.oneline span i{
	color:#839496;
}
.oneline input{
	font: inherit;
	font-family: inherit;
	height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #073642;
    background-color: #a9bdbd;
    background-image: none;
    border: 1px solid rgba(0,0,0,0.15);
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    width: 224px;
}
.loginbtn{
	overflow: hidden;
}
.loginbtn input{
	display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    color: #ffffff;
    background-color: #586e75;
    border-color: #586e75;
    float: right;
}
.loginbtn input:hover{
	background-color:#415358;border-color:#586e75
}
input::-webkit-input-placeholder {
　　color: #073642 !important; 
}
input::-webkit-input-placeholder{
    color:    #073642;
}
input:-moz-placeholder{
    color:    #073642;
}
input::-moz-placeholder{
    color:    #073642;
}
input:-ms-input-placeholder{
    color:    #073642;
}
<?php
$left	= mt_rand(-300,2000);
$top	= mt_rand(0,1000);
$rotate	= mt_rand(30,360);
echo <<<EOT
@keyframes in_am {
	0% {left: {$left}px;top: {$top}px;transform: rotate({$rotate}deg);}
	50% {opacity: 0;}
	100% {opacity: 1;}
}
@-moz-keyframes in_am {
	0% {left: {$left}px;top: {$top}px;transform: rotate({$rotate}deg);}
	50% {opacity: 0;}
	100% {opacity: 1;}
}
@-webkit-keyframes in_am {
	0% {left: {$left}px;top: {$top}px;transform: rotate({$rotate}deg);}
	50% {opacity: 0;}
	100% {opacity: 1;}
}
@-o-keyframes in_am {
	0% {left: {$left}px;top: {$top}px;transform: rotate({$rotate}deg);}
	50% {opacity: 0;}
	100% {opacity: 1;}
}
EOT;
?>

</style>
</head>

<body>

	<p>&nbsp;</p>

	<div class="loginbox">
		<div class="logintitle">管理登陆</div>
		<div class="loginbody">
			<form method="post">
				<div class="oneline">
					<span><i class="fa fa-user"></i></span>
					<input type="text" name="username" placeholder="登录名">
				</div>
				<div class="oneline">
					<span><i class="fa fa-lock"></i></span>
					<input type="password" name="userpwd" placeholder="请输入密码">
				</div>
				<div class="loginbtn">
					<input type="submit" value="登陆">
				</div>
			</form>
		</div>
	</div>

</body>
</html>
