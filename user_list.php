<?php
session_start();
require('include/mysql.php');
require('include/function.php');
LYG::checklogin();
if (isset($_GET['act']) && $_GET['act'] == 'del')
{
    if(empty($_GET['id']) || intval($_GET['id'])<1){
        LYG::ShowMsg('参数错误');
    }
    $did=intval($_GET['id']);

    $sql="delete from #__user where id=$did limit 1";
    $data =$con->Excute($sql);
    if($data){
        header('Location:user_list.php');
    }else{
        LYG::ShowMsg('删除失败');
    }
}

$pagesize = lyg::getjson("data_pagesize");//每页显示数量
$pagesize = $pagesize['pagesize'];

//总记录数
$datacount=$con->RowsCount("select count(*) from #__user");
//总页数
$totalpages=LYG::getTotalPage($datacount,$pagesize);
$page=1;
if(isset($_GET['p']) && intval($_GET['p'])>0){
	$page=intval($_GET['p']);
	$page=$page>$totalpages?$totalpages:$page;
	if($page+1<=1){$page=1;}
}
$start_id=($page-1)*$pagesize;
//查询数据
$sql="select #__user.* from #__user  order by #__user.id desc limit $start_id,$pagesize";
$data	=$con->select($sql);

//得到分页HTML
$fenye=LYG::getPageHtml($page,$datacount,$pagesize);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户管理</title>
<link href="style/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>

<body class="content">


<table cellpadding="3" cellspacing="0">
	<thead>
    	<tr>
            <th width="100">#</th>
            <th width="*">用户名</th>
            <th width="300">店铺</th>
            <th width="200">操作</th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($data as $k=>$v){?>
    	<tr class='list'>
        	<td align="center">
			<?php 
				echo "<a class='edit' href='goods_edit.php?id={$v['id']}' title='点击进入修改'>{$v['id']}</a>";
			?>			
			</td>
        	<td align="center"><?php echo $v['username'];?></td>
        	<td align="center"><?php echo $v['shop_name'];?></td>
            <td align="center">
                <?php

                   $uid	=$_SESSION['uid'];
                   //超级管理员才能删除用户
                   if($uid==1){
                       echo "<a onclick=\"return confirm('确定删除吗？');\"  class=\"del\" href='user_list.php?act=del&id={$v['id']}' title=''>删除</a>";
                   }
               ?>
                <?php
                $uid	=$_SESSION['uid'];
                //超级管理员才能删除用户
                if($uid==1){
                    echo "<a class=\"edit\" href=\"user.php?id={$v['id']}\">修改密码</a>";
                }
                ?>

			</td>
        </tr>
	<?php }?>
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="6" style="padding-left:30px;">
			<?php echo $fenye ;?>
			</td>
        </tr>
    </tfoot>
</table>

<p class="toadd"><a href="user_add.php">添加用户</a></p>

</body>
</html>