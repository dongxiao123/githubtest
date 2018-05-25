<?php
//API 客户提交订单过来
ini_set('display_errors', '0');
session_start();
require('include/mysql.php');
require('include/function.php');



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

$extArray = ['gif','jpg','jpeg','png','bmp'];

//var_export($_FILES);var_export($_POST);
if (!is_dir('./Upload'))
{
    mkdir('./Upload');
}
//要求效果图片
if (!empty($_FILES['claim_img']))
{
    $ext =  substr(strrchr($_FILES["claim_img"]["tmp_name"], '.'), 1);
    $path = './Upload/'.time().rand(1000,9999).'.'.$ext;
    move_uploaded_file($_FILES["claim_img"]["tmp_name"],$path);
    $data['claim_img'] = $path;
}
if (!empty($_FILES['i_img']))
{
    //本人图片
    $ext =  substr(strrchr($_FILES["i_img"]["tmp_name"], '.'), 1);
    $path = './Upload/'.time().rand(1000,9999).'.'.$ext;
    move_uploaded_file($_FILES["i_img"]["tmp_name"],$path);
    $data['i_img'] = $path;
}

//性别 默认女
$data['sex'] = isset($_POST['sex']) ? $_POST['sex'] : 0;
$data['colour'] = isset($_POST['colour']) ? $_POST['colour'] : "";
$data['style'] = isset($_POST['style']) ? $_POST['style'] : "";
$data['yield'] = isset($_POST['yield']) ? $_POST['yield'] : "";
$data['pick'] = isset($_POST['pick']) ? $_POST['pick'] : "";
$data['prune'] = isset($_POST['prune']) ? $_POST['prune'] : "";
$data['length'] = isset($_POST['length']) ? $_POST['length'] : "";
$data['dosage'] = isset($_POST['dosage']) ? $_POST['dosage'] : "";
$data['customize'] = isset($_POST['customize']) ? $_POST['customize'] : "";
$data['dianhua'] = isset($_POST['tel']) ? $_POST['tel'] : "";
$data['store_id'] = isset($_POST['store_id']) ? $_POST['store_id'] : 0;
$data['delivery'] = isset($_POST['delivery']) ? $_POST['delivery'] : date('Y-m-d',time());
$data['nickname'] = isset($_POST['name']) ? trim($_POST['name']) : "";
$data['liuyan'] = isset($_POST['remark']) ? trim($_POST['remark']) : "";
$data['addtime'] = time();
if(empty($data['nickname']) ){echo ('请输入姓名'); exit;}
$data['kehu'] = $data['nickname'];
//电话校验
if(empty($data['dianhua']) || !preg_match('/^1[0-9]{10}$/',$data['dianhua'])){echo ('电话格式错误'); exit;}

$ret = $con->add('order',$data);
if ($ret)
{
    echo ("保存成功");
}
exit;