<?php
session_start();
require_once('include/mysql.php');
require_once('include/function.php');

LYG::checklogin();
$_SESSION['uid'];
//超管
if ($_SESSION['uid'] == 1)
{
    $store_id = ' and  1=1 ';
}
else
{
    $sql = "select #__user.* from #__user where id=" . $_SESSION['uid'];
    $thisUser = $con->select($sql);
    $store_id = $thisUser[0]['shop_name'];
}
$_k = array();
$_v = array();

$_c = array();//分页条件
$_s = array();//搜索条件

if(!empty($_GET['class_id']) && intval($_GET['class_id'])>0){
    $_k[]="#__order.fenlei_id=?";
    $_v[]=intval($_GET['class_id']);
    $_c[]="class_id=".intval($_GET['class_id']);
    $_s['class_id'] = intval($_GET['class_id']);
}
if(!empty($_GET['goods_id']) && intval($_GET['goods_id'])>0){
    $_k[]="#__order.shangpin_id=?";
    $_v[]=intval($_GET['goods_id']);
    $_c[]="goods_id=".intval($_GET['goods_id']);
    $_s['goods_id'] = intval($_GET['goods_id']);
}
if(!empty($_GET['kehu']) && trim($_GET['kehu'])!=''){
    $kehu = trim($_GET['kehu']);
    $_k[]="#__order.kehu=?";
    $_v[]=$kehu;
    $_c[]="kehu=$kehu";
    $_s['kehu'] = $kehu;
}
if(!empty($_GET['dianhua']) && trim($_GET['dianhua'])!=''){
    $dianhua = trim($_GET['dianhua']);
    $_k[]="#__order.dianhua=?";
    $_v[]=$dianhua;
    $_c[]="dianhua=$dianhua";
    $_s['dianhua'] = $dianhua;
}
if(!empty($_GET['faxing']) && trim($_GET['faxing'])!=''){
    $faxing = trim($_GET['faxing']);
    $_k[]="#__order.faxing=?";
    $_v[]=$faxing;
    $_c[]="faxing=$faxing";
    $_s['faxing'] = $faxing;
}
if(!empty($_GET['time0']) && !empty($_GET['time1']) && 
    preg_match("/^\d{4}\-\d{2}\-\d{2}$/",$_GET['time0']) && preg_match("/^\d{4}\-\d{2}\-\d{2}$/",$_GET['time1'])
){
    $time0 = $_GET['time0'];
    $time1 = $_GET['time1'];
    $t0 = strtotime($time0." 00:00:00");
    $t1 = strtotime($time1." 23:59:59");
    if($t0!==false && $t1!==false && $t1>$t0){

        $_k[]="#__order.addtime>=?";
        $_v[]=$t0;
        $_c[]="time0=$t0";
        $_s['time0'] = $time0;

        $_k[]="#__order.addtime<=?";
        $_v[]=$t1;
        $_c[]="time1=$t1";
        $_s['time1'] = $time1;
    }
}


$_k = implode(' and ',$_k);
if($_k!=''){
    $_k = " where ".$_k;
}

//
$action="search";
if(!empty($_GET['action']) && $_GET['action']=='导出数据'){
	//执行导出
	require_once("include/PHPExcel/PHPExcel.php");
	$sql="select #__order.*,#__class.classname,#__goods.goods,#__goods.price from #__order left join #__class on #__class.id=#__order.fenlei_id left join #__goods on #__goods.id=#__order.shangpin_id $_k order by #__order.status asc, #__order.id desc";
	$data	=$con->select($sql,$_v);
	require_once("output.php");
	die();
}


$pagesize = lyg::getjson("data_pagesize");//每页显示数量
$pagesize = $pagesize['pagesize'];


//总记录数
$datacount=$con->RowsCount("select count(*) from #__order $_k",$_v);
//总页数
$totalpages=LYG::getTotalPage($datacount,$pagesize);
$page=1;
if(isset($_GET['p']) && is_numeric($_GET['p']) && intval($_GET['p'])>0){
	$page=intval($_GET['p']);
	$page=$page>$totalpages?$totalpages:$page;
	if($page+1<=1){$page=1;}
}
$start_id=($page-1)*$pagesize;
//查询数据
$sql="select #__order.*,#__class.classname,#__goods.goods from #__order left join #__class on #__class.id=#__order.fenlei_id left join #__goods on #__goods.id=#__order.shangpin_id $_k order by #__order.status asc, #__order.id desc limit $start_id,$pagesize";
$data	=$con->select($sql,$_v);
//得到分页HTML
$fenye=LYG::getPageHtml($page,$datacount,$pagesize,$_c);

//统计
$count_status0=$con->RowsCount("select count(*) from #__order where status=0");;
$count_status1=$con->RowsCount("select count(*) from #__order where status=1");;
$count_status2=$con->RowsCount("select count(*) from #__order where status=2");;

$_status = array(
    '0' =>array('未处理',"未处理"),
    '1' =>array('处理中',"<span style='color:blue'>处理中</span>"),
    '2' =>array('完成',"<span style='color:#228810'>完成</span>"),
);
function get_status($status=0){
    global $_status;
    return $_status["{$status}"];
}
$_isshow = array(
    '0' =>array('否',"否"),
    '1' =>array('是',"<span style='color:blue'>是</span>"),
);
function get_show($isshow=0){
    global $_isshow;
    $isshow = intval($isshow)%2;
    return $_isshow["{$isshow}"];
}

$classinfo  = $con->select("select * from #__class");

$goodsinfo = array();
if(array_key_exists('class_id',$_s)){
    $goodsinfo = $con->select("select * from #__goods where class_id = ?",array($_s['class_id']));
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单列表</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
$(function(){
    $("#class_id").change(function(){
        var id = parseInt($(this).val());
        if(id==0){
            $("#goods").html("<option value='0'>不限</option>");
        }else{
            $.ajax({
                type:'get',
                url:'json.php?act=getgoods&class_id='+id,
                dataType:'json',
                success:function(data){
                    var html="<option value='0'>不限</option>";
                    for(var i=0;i<data.length;i++){
                        html+="<option value='"+data[i].id+"'>"+data[i].data+"</option>";
                    }
                    $("#goods").html(html);
                },
                complete:function(XMLHttpRequest,textStatus){},
                error:function(){}
            });
        }
    });
});
function settarget(tag){
	$("#searchform").attr("target",tag);
}
</script>
</head>

<body class="content">

<div class="searchform">
    <form method="get" id="searchform" target="_self">
        <table>
            <tr>
                <td width="30" align="left">分类</td>
                <td width="120"><select name="class_id" class="select bai" id="class_id"><option value='0'>不限</option><?php
                foreach ($classinfo as $k => $v) {
                    if(array_key_exists('class_id', $_s) && intval($_s['class_id'])===intval($v['id'])){
                        echo "<option value='{$v['id']}' selected='selected'>{$v['classname']}</option>";
                    }else{
                        echo "<option value='{$v['id']}'>{$v['classname']}</option>";    
                    }                    
                }
                ?></select></td>
                <td width="30" align="left">商品</td>
                <td width="250">
                    <select name="goods_id" class="select bai" id="goods">
                        <option value='0'>不限</option><?php
                        foreach($goodsinfo as $k=>$v){
                            if(array_key_exists('goods_id', $_s) && intval($_s['goods_id'])===intval($v['id'])){
                                echo "<option value='{$v['id']}' selected='selected'>{$v['goods']}</option>";
                            }else{
                                echo "<option value='{$v['id']}'>{$v['goods']}</option>";    
                            }
                        }
                        ?>
                    </select>
                </td>
                <td width="30" align="left">姓名</td>
                <td width="60">
                    <input type="text" name="kehu" class="text" value="<?php 
                        if(array_key_exists("kehu",$_s)){
                            echo $_s['kehu'];
                        }
                    ?>">
                </td>
                <td width="30" align="left">电话</td>
                <td width="100">
                    <input type="text" name="dianhua" class="text" value="<?php 
                        if(array_key_exists("dianhua",$_s)){
                            echo $_s['dianhua'];
                        }
                    ?>">
                </td>
              <td width="30" align="left">发型</td>
                <td width="100">
                    <input type="text" name="faxing" class="text" value="<?php 
                        if(array_key_exists("faxing",$_s)){
                            echo $_s['faxing'];
                        }
                    ?>">
                </td>
                <td width="50" align="left">订单日期</td>
                <td width="80">
                    <input type="text" name="time0" class="text" onclick="WdatePicker();" value="<?php 
                        if(array_key_exists("time0",$_s)){
                            echo $_s['time0'];
                        }
                    ?>">
                </td>
                <td width="15" align="left">至</td>
                <td width="80">
                    <input type="text" name="time1" class="text" onclick="WdatePicker();" value="<?php 
                        if(array_key_exists("time1",$_s)){
                            echo $_s['time1'];
                        }
                    ?>">
                </td>
                <td width="*" align="left">
                    <input type="submit" name="action" onclick="settarget('_self');" value="搜索" class="sub">　　
                    <input type="submit" name="action" onclick="settarget('_blank');" value="导出数据" class="reset">
                </td>
            </tr>
        </table>
    </form>
</div>

<table cellpadding="3" cellspacing="0">
	<thead>
    	<tr>
            <th width="70">#</th>
            <th width="120">姓名</th>
            <th width="120">电话</th>
            <th width="120">发型</th>
            <th width="200">商品</th>
            <th width="120">分类</th>
            <th width="60">数量</th>
            <th width="110">订单时间</th>
            <th width="130">客户IP</th>
            <th width="70">状态</th>
            <th width="70">显示</th>
            <th width="*">打印</th>
            <th width="*">收货地址</th>
            <th width="100">-</th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($data as $k=>$v){?>
    	<?php
        if (is_numeric($store_id) && ($v['store_id'] != $store_id))
        {
            continue;
        }
        ?>
        <tr class='list'>
        	<td align="center">
			<?php 
			echo "<a class='edit' href='order_edit.php?id={$v['id']}' title='点击进入修改'>{$v['id']}</a>　";
			?>
			</td>
        	<td align="center"><?php echo $v['kehu'];?></td>
            <td align="center"><?php echo $v['dianhua'];?></td>
            <td align="center"><?php echo $v['faxing'];?></td>
            <td align="center"><?php echo $v['goods'];?></td>
            <td align="center"><?php echo $v['classname'];?></td>
            <td align="center"><?php echo $v['shuliang'];?></td>
            <td align="center"><?php echo $v['addtime']==0?'无': date('Y-m-d',$v['addtime']);?></td>
			<td align="center"><?php echo $v['ip'];?></td>
			<td align="center"><?php $s= get_status($v['status']);  echo $s[1];?></td>
			<td align="center"><?php $s = get_show($v['isshow']); echo $s[1];?></td>
			<td align="center"><a href="/print.php?id=<?php echo $v['id'];?>">打印</a></td>
            <td align="left"><?php echo $v['dizhi'];?></td>
            <td align="center">
				<a onclick="return confirm('删除后不可恢复，确定删除吗？');" class="del" href="order_del.php?<?php echo 'id='.$v['id'];?>">删除</a>
			</td>
        </tr>
	<?php }?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="12" style="padding-left:30px;">
			<?php echo '[未处理:'.$count_status0.'　处理中:'.$count_status1.'　完成:'.$count_status2.']　　'.$fenye ;?>
			</td>
        </tr>
    </tfoot>
    
</table>


</body>
</html>