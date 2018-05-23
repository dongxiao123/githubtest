<?php
session_start();//启动session
$Arr="0123456789abcdefghijklmnopqrstuvwxyz";
$fontfile = "include/fonts/AvenirNextCondensed.ttf";
$fontsize = 20;
$angle = 0;
$rand = '';

//建一个图片
$im=imagecreatetruecolor(100,40);//宽度,高度
//设置验证码背景色
$bg=imagecolorallocate($im,255,255,255);
imagefill($im,0,0,$bg);//使用背景色

for($i=1; $i<=4;$i++){
	$r = $Arr[rand(0,35)];//得到验证码字符串
    $rand.=$r;
	$r = rand(0,10)%2===0?strtoupper($r):$r;
	$tc=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
	$x = ($i-1)*$fontsize+rand(3,20);
	$y = rand(20,40);
	//画字符串
	/*
	imagestring($im,5,$x,$y,$r,$tc);
            //图片，随机字体（系统默认的六种）,x坐标,y坐标,验证字符,前景色
	*/
	imagefttext($im,$fontsize,$angle,$x,$y,$tc,$fontfile,$r);
}

//画线条
for($j=0;$j<4;$j++){
    $tg=imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
    imageline($im,rand(2,100),rand(2,40),rand(8,100),rand(2,40),$tg);
}

$_SESSION["ztorder_yzm_addorder"]=$rand;

header("Content-type:image/png");
imagejpeg($im);
?>