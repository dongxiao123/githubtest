<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>提交订单-尚新假发定做</title>
    <!--<link type="text/css" href="style/bootstrap-3.3.7-dist/css/bootstrap.css"/>-->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>

<body>
<?php
require_once('./include/mysql.php');
$storeinfo = $con->select("select * from sev_store order by id desc");
// 发型款式2 发型颜色3 发量4 挑染5 修剪6 发长7 头旋用量8
$tag2 = $con->select("select * from sev_attribute where type=2");
$tag3 = $con->select("select * from sev_attribute where type=3");
$tag4 = $con->select("select * from sev_attribute where type=4");
$tag5 = $con->select("select * from sev_attribute where type=5");
$tag6 = $con->select("select * from sev_attribute where type=6");
$tag7 = $con->select("select * from sev_attribute where type=7");
$tag8 = $con->select("select * from sev_attribute where type=8");
?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<form class="form-horizontal" action="/newApi.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">电话</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputEmail3" name="tel" placeholder="手机号码">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">交货日期</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputEmail3" placeholder="2018-05-20">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">客户名称</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputEmail3" name="name"  placeholder="客户名称">
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">选择门店</label>
        <div class="col-sm-6">
            <select class="form-control" name="store_id">
               <?php
               foreach ($storeinfo as $v)
               {
                 echo "<option value=\"".$v['id']."\">".$v['storename']."</option></option>";
               }
               ?>


            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">性别：</label>
        <div class="col-sm-6">
            <div class="radio">
                <label>
                    <input type="radio" name="gender" value="1"> 男
                </label>
                <label>
                    <input type="radio" name="gender" value="0"> 女
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发型颜色</label>
        <div class="col-sm-6">
            <select class="form-control" name="colour">
                <?php
                foreach ($tag3 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发型款式</label>
        <div class="col-sm-6">
            <select class="form-control" name="style">
                <?php
                foreach ($tag2 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发量</label>
        <div class="col-sm-6">
            <select class="form-control" name="yield">
                <?php
                foreach ($tag4 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">挑染</label>
        <div class="col-sm-6">
                <select class="form-control" name="pick">
                <?php
                foreach ($tag5 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">修剪</label>
        <div class="col-sm-6">
            <select class="form-control" name="prune">
                <?php
                foreach ($tag6 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发长</label>
        <div class="col-sm-6">
            <select class="form-control" name="length">
                <?php
                foreach ($tag7 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">头旋用料</label>
        <div class="col-sm-6">
            <select class="form-control" name="dosage">
                <?php
                foreach ($tag8 as $v)
                {
                    echo "<option value=\"".$v['id']."\">".$v['name']."</option></option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">自定义发型</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputEmail3" name="customize" placeholder="自选">
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputFile" class="col-sm-2 control-label" >本人图片</label>
        <div class="col-sm-6">
            <input type="file" id="exampleInputFile" name="i_img">
        </div>
    </div>


    <div class="form-group">
        <label for="exampleInputFile" class="col-sm-2 control-label" ">要求效果</label>
        <div class="col-sm-6">
            <input type="file" id="exampleInputFile" name="claim_img">
        </div>
    </div>

     <div class="form-group">
        <label for="exampleInputFile" class="col-sm-2 control-label" name="remark">备注</label>
        <div class="col-sm-6">
            <textarea class="form-control" rows="3"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">提交订单</button>
        </div>
    </div>
</form>
</body>
</html>