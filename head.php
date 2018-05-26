<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头部</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css">
*{margin:0;padding:0;}
body{background-color:#333366;background: -webkit-gradient(linear, 0 0, 0 bottom, from(#333366), to(#626288));height:50px;overflow:hidden;}
p{display:inline-block; font-size:16px;}
p a{ color:#CA36B1;}
p a.topnotice{position:relative;}
p a.topnotice:before{
	content:'';display:block;position:absolute;width:8px;height:8px;top:0px;right:-5px;
	background:#00FF08;border-radius:4px;z-index:-1;
}


.sevcheckbox{
	overflow: hidden; display: inline-block; width: 60px; height: 20px; border: 1px solid #efefef;
	background: #fff;
	box-sizing: border-box; position: relative; font-family: "Microsoft yahei"; border-radius: 3px;
}
.sevcheckbox input[type=checkbox]{
	visibility: hidden;
}
.sevcheckbox:before{
	content:'ON'; z-index: 1; display: block; position: absolute; width: 50%; height: 100%; 
	color:#4BD865; visibility: visible; left:0; font-weight: bold; font-size:12px;
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
	display: inline-flex;
	-webkit-box-align: center;
	-moz-box-align: center;
	justify-content: center;
	align-items: center;
}
.sevcheckbox:after{
	content:'OFF';z-index: 1; display: block; position: absolute; width: 50%; height: 100%;  
	color:#90201F; visibility: visible; right:0; font-weight: bold;font-size:12px;
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
	display: inline-flex;
	-webkit-box-align: center;
	-moz-box-align: center;
	justify-content: center;
	align-items: center;
}
.sevcheckbox label{
	width: 50%; z-index:2;position: absolute; display: block;  height: 100%; top: 0; left: 50%; 
	box-sizing: border-box; 
	-webkit-transition:all ease .4s;
	-moz-transition:all ease .4s;
	-o-transition:all ease .4s;
	-ms-transition:all ease .4s;
	transition:all ease .4s;
	margin-left:-50%; 
	background: #90201F;
}
.sevcheckbox label:before{ 
	display: block; content: ""; position: absolute;width: 100%; height: 100%; left: -100%;  top: 0 ; 
	z-index:-1;
}
.sevcheckbox label:after{ 
	display: block; content: ""; position: absolute;width: 100%; height: 100%; right: -100%;  top: 0 ; 
	z-index:-1;
}
.sevcheckbox input[type=checkbox]:checked + label{
	margin-left:0%;
	background:#4BD865;
}

.kaiguan{
	display:inline-block;font-weight:normal;color:#fff;padding:0 0 0 20px;display: inline-flex;
	-webkit-box-align: center;
	-moz-box-align: center;
	justify-content: center;
	align-items: center;
}
.kaiguan>label{padding-left:10px;}
</style>
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type='text/javascript'>
//新订单提醒
var player;
var lastid = 0;
var isgeting = false;
var neednotice = true
$(function(){
	player	= document.getElementById("noticeplayer");
	setInterval(function(){
		if(!neednotice || isgeting){return;}
		isgeting=true;
		jQuery.ajax({
			url:'notice.php?r='+Math.random(),
			dataType:"json",
			success:function(data){
				if(data.flag=='1'){
					if(lastid!=0 && data.data>lastid){
						player.play();
					}
					lastid = data.data;
				}				
			},
			error:function(XMLHttpRequest, textStatus, errorThrown){},
			complete: function(XMLHttpRequest, textStatus) {isgeting=false;}
		});

	},3000);
});
function setnotice(){
	neednotice = document.getElementById("notice").checked;
}
</script>
<body>
<p style=" font-size:24px; font-weight:bold; line-height:1em; padding:10px 0 0 10px; color:#fff;">管理后台<p>

<p style='color:#fff;padding:0px 0 0 20px;'><?php echo $_SESSION['username'];?></p>

<p style='padding:0 0 0 20px;'><a href='demo.php' class='topnotice' target='_blank'>前台演示</a></p>
<p style='padding:0 0 0 20px;'><a href='test.php' class='topnotice' target='_blank'>定做下单</a></p>

<div class="kaiguan">
	<section class="sevcheckbox">
		<input type="checkbox" id="notice" checked="checked">
		<label for="notice" onclick="setnotice();"></label>
	</section>	
	<label for="notice" style="color:#fff">开启新订单提示音通知</label>
</div>

<p style="float:right;margin-right:20px;font-size:14px;padding-top:12px;">
	<a href="exit.php" style="color:red;" target="_top" onclick="return confirm('确定退出吗？');">退出登录</a>
</p>
<audio src="source/1.mp3" id="noticeplayer">
Your browser does not support the audio element.
</audio>

</body>
</html>