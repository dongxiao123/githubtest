<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>打印订单-尚新假发定做</title>
    <!--<link type="text/css" href="style/bootstrap-3.3.7-dist/css/bootstrap.css"/>-->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<style type="text/css">
    *{ margin: 0; padding: 0; }
    body{ text-align: center; }
    .box{ width: 100%; max-width: 640px; margin: 0 auto; }
    iframe{width: 100%; border: 0 }




    .header-box{
        border-bottom: 1px solid #ccc;
    }
    .main-box{
        padding-top: 15px;
    }
    .main-box-l{
        border-right: 1px solid #ccc;
    }
    .main-box-l .img-box{
        min-height: 300px;
        padding: 5px 0 15px 0;
    }
    .main-box-l .img-box img{
        max-width: 100%;
        height: auto;
    }
    .container .col-sm-6{
        width: 50%;
        float: left;
    }
    .container .col-sm-3{
        width: 30%;
        float: left;
        padding-left: 0;
        padding-right: 0;
    }
    .container .col-sm-9{
        width: 70%;
        float: left;
    }
</style>
<body>
<br />
<br />
<br />
<br />
<br />
<?php
error_reporting(0);
require_once('./include/mysql.php');
$id = empty($_GET['id']) ? 0 :$_GET['id'];

$order = $con->find("select * from sev_order where id = ".$id);
if (empty($order))
{
    echo '订单不存在';exit;
}

$store = $con->find("select * from sev_store where id = ".$order['store_id']);
?>
<section class="container ">
    <div class="header-box">
        <form>
            <div class="form-horizontal row">

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">店铺名：</label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-left"><?php echo $store['storename'] ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">地址：</label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-left"><?php echo $store['address'] ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">电话：</label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-left"><?php echo $order['dianhua'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">交货期：</label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-left"><?php echo $order['delivery'] ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">订单期：</label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-left"><?php echo date('Y-m-d',$order['addtime']) ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">客户姓名：</label>
                        <div class="col-sm-9">
                            <p class="form-control-static text-left"><?php echo $order['nickname'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="main-box row form-horizontal">
        <div class="col-sm-6 main-box-l">
            <p>客户本人照片</p>
            <div class="img-box">
                <img class="img-rounded" width="200" height="300" src="<?php echo $order['i_img'] ?>" />

            </div>
            <p>客户要求效果</p>
            <div class="img-box">
                <img class="img-rounded"  width="200" height="300"  src="<?php echo $order['claim_img'] ?>" />
            </div>
        </div>
        <div class="col-sm-6 main-box-r">
            <div class="form-group">
                <label class="col-sm-3 control-label">性别：</label>
                <div class="col-sm-9 text-left">
                    <p class="form-control-static text-left"><?php if ($order['sex']) {echo "男";}else {echo "女";}?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">发型款式：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['style'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">发型颜色：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['colour'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">发量：</label>
                <div class="col-sm-9 text-left">
                    <p class="form-control-static text-left"><?php echo $order['yield'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">挑染：</label>
                <div class="col-sm-9 text-left">
                    <p class="form-control-static text-left"><?php echo $order['pick'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">修剪：</label>
                <div class="col-sm-9 text-left">
                    <p class="form-control-static text-left"><?php echo $order['prune'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">发长：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['length'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">头旋用料：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['dosage'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">自定义发型：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['customize'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">头旋位置：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['style'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-3 control-label">备注信息：</label>
                <div class="col-sm-9">
                    <p class="form-control-static text-left"><?php echo $order['liuyan'] ?></p>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" onclick="javascript:window.print();" class="btn btn-default">打印订单</button>

            </div>
        </div>
    </div>
</section>
</body>
</html>


