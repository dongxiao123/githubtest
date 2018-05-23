<?php
//API 客户提交订单过来
ini_set('display_errors', '0'); 
session_start();
require('include/mysql.php');
require('include/function.php');
require_once('include/PHPMailer/PHPMailerAutoload.php');


//参数校验
/*
商品    gid
姓名	xingming
电话	dianhua
发型  faxing
地址	dizhi
数量	shuliang
留言	liuyan
*/



if(!empty($_POST)){
	extract($_POST);
}else{
	extract($_GET);
}

if(empty($data)){ajaxreturn('非法操作');}
$data = stripslashes($data);

//php>=5.4
//extract(json_decode($data,true));

//php<5.4
$info = array();
$obj = json_decode($data);
foreach($obj as $k=>$v){
	$info[$k]=$v;
}
extract($info);


//商品校验
if(empty($gid) || intval($gid)<1){ajaxreturn('请选择商品');}
$gid = intval($gid);
$goodsinfo = $con->find("select * from #__goods where id=$gid");
if(empty($goodsinfo)){ajaxreturn('请选择商品');}
//姓名校验
if(empty($xingming) || trim($xingming)==''){ajaxreturn('请输入姓名');}
$xingming = trim($xingming);
//电话校验
if(empty($dianhua) || !preg_match('/^1[0-9]{10}$/',$dianhua)){ajaxreturn('电话格式错误');}

//地址校验
if(empty($dizhi) || trim($dizhi)==''){ajaxreturn('地址不能为空');}
$dizhi = trim($dizhi);
//数量校验
if(empty($shuliang) || intval($shuliang)<1){ajaxreturn('数量选择错误');}
$shuliang = intval($shuliang);
if($shuliang>intval($goodsinfo['stock'])){ajaxreturn('商品库存超出');}
//留言校验
$liuyan = trim($liuyan);
//来路
//$referer	=isset($_SERVER["HTTP_REFERER"])?($_SERVER["HTTP_REFERER"]===''?'未知':$_SERVER["HTTP_REFERER"]):'未知';
$referer = empty($referer)?'未知':urldecode($referer);

//间隔限制
if(isset($_SESSION['last'])){
	if(time()-intval($_SESSION['last'])<10){
		//10秒内不允许重复提交
		ajaxreturn('提交过于频繁，请稍后再试');
	}
}

$data = array(
	'fenlei_id'		=>$goodsinfo['class_id'],
	'shangpin_id'	=>$gid,
	'kehu'			=>$xingming,
	'dianhua'		=>$dianhua,
    'faxing'		=>$faxing,
	'dizhi'			=>$dizhi,
	'shuliang'		=>$shuliang,
	'liuyan'		=>$liuyan,
	'referer'		=>$referer,
	'addtime'		=>time(),
	'ip'			=>lyg::getIP()
);
$con->begin();
$result	= $con->add("order",$data);
if($result){
	$_SESSION['last']=time();
	$jiankucun = $con->update("update #__goods set stock=stock-? where id=? limit 1",array(
		$shuliang,$gid
	));
	if($jiankucun){
		$con->done();
	}else{
		$con->back();
		ajaxreturn('订单提交失败');
	}
	
	//$emailinfo = $con->find("select * from #__json where flag='email'");
	
	$emailinfo = lyg::readConfig("json_mail.php");
	if(intval($emailinfo['isopen'])===1){
		$xz = date('Y年m月d日 H时i分s秒',time());
		$post_data = array(
			"user"		=> $emailinfo['gid'],
			"pass"		=> $emailinfo['ukey'],
			"smtp"		=> "smtp.126.com",
			"port"		=> "465",
			"sender"	=> "wsx95162@126.com",
			"pwd"		=> "客户端授权码",
			"receiver"	=> $emailinfo['receive_email'],
			"title"		=> "您有新的订单，请登录后台查看",
			"body"		=> "<p>客户：<b>{$xingming}</b><br/>电话：<b>{$dianhua}</b><br/>商品：{$goodsinfo['goods']}<br/>购买数量：<span style='color:green'>{$shuliang}</span><br/>提交时间：{$xz}</p>",
		);
		senddata($post_data);
	}
	ajaxreturn('订单提交成功，我们会第一时间处理！',1);
}else{
	$con->back();
	ajaxreturn('订单提交失败');
}

$callback=empty($callback)|| trim($callback)==''?'addorder':trim($callback);
//输出函数
function ajaxreturn($msg,$flag=0){
	global $callback;
	$data['flag']	=$flag;
	$data['msg']	=$msg;
	echo $callback.'('.json_encode($data).')';
	die();
}
//发邮件
function sendMail($anmail=array()){
	$mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=$anmail['host']; //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = $anmail['smtpauth']; //启用smtp认证
    $mail->Username = $anmail['username']; //你的邮箱名
    $mail->Password = $anmail['password']; //邮箱密码
    $mail->From = $anmail['from']; //发件人地址（也就是你的邮箱地址）
    $mail->FromName = $anmail['fromname']; //发件人姓名
    $mail->AddAddress($anmail['addaddress']);
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML($anmail['ishtml']); // 是否HTML格式邮件
    $mail->CharSet=$anmail['charset']; //设置邮件编码
    $mail->Subject =$anmail['subject']; //邮件主题
    $mail->Body = $anmail['body']; //邮件内容
    $mail->AltBody = $anmail['altbody']; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}
function senddata($data){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://mailer.gaolb.com/callsend/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);// post数据
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);// post的变量
	$output = curl_exec($ch);
	curl_close($ch);
}
?>