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
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<form class="form-horizontal" action="/api.php" method="post" enctype="multipart/form-data">
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
            <select class="form-control" name="dianpu">
                <option value="1">门店1</option>
                <option>门店2</option>
                <option>门店3</option>
                <option>门店4</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">性别：</label>
        <div class="col-sm-6">
            <div class="radio">
                <label>
                    <input type="radio" name="sex" value="1"> 男
                </label>
                <label>
                    <input type="radio" name="sex" value="0"> 女
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">颜色</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>蓝色</option>
                <option>红</option>
                <option>绿</option>
                <option>紫</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发型款式</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发量</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>多</option>
                <option>少</option>
                <option>普通</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">挑染</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>多</option>
                <option>少</option>
                <option>普通</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">修剪</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>多</option>
                <option>少</option>
                <option>普通</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">发长</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>长</option>
                <option>短</option>
                <option>普通</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">头旋用料</label>
        <div class="col-sm-6">
            <select class="form-control">
                <option>长</option>
                <option>短</option>
                <option>普通</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">自定义发型</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputEmail3" placeholder="自选">
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputFile" class="col-sm-2 control-label" >本人图片</label>
        <div class="col-sm-6">
            <input type="file" id="exampleInputFile" name="images">
        </div>
    </div>


    <div class="form-group">
        <label for="exampleInputFile" class="col-sm-2 control-label" ">要求效果</label>
        <div class="col-sm-6">
            <input type="file" id="exampleInputFile" name="img">
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