$(function(){
	shuliang(0);
	$("#goods_id").change(function(){
		shuliang(0);
	});
	$("#submit").click(function(){
		var gid = parseInt($("#goods_id").val());
		var amount = parseInt($("#shuliang").val());
		if(isNaN(amount)){amount=1;}
		var data = {
			'gid':gid,
			'xingming':encodeURIComponent($("#xingming").val()),
			'dianhua':encodeURIComponent($("#dianhua").val()),
			'dizhi':encodeURIComponent($("#dizhi").val()),
			'shuliang':amount,
			'liuyan':encodeURIComponent($("#liuyan").val()),
			'referer':encodeURIComponent(_ref),
		};
		showLoading(true);
		jQuery.ajax({
			url:'../../api.php?data='+JSON.stringify(data),
			dataType:"jsonp",
			jsonpCallback:"callback_submit",
			success:function(data){},
			error:function(XMLHttpRequest, textStatus, errorThrown){alert('提交失败，请重试');},
			complete: function(XMLHttpRequest, textStatus) {showLoading(false);}
		});
	});
});
function callback_submit(res){
	alert(res.msg);
}
function shuliang(c){
	var a = parseInt($("#shuliang").val());
	if(isNaN(a)){a=1;}else{a+=c;}
	a=a<1?1:a;	
	$("#shuliang").val(a);
	gettotal();
}
//获取总价信息
function gettotal(){
	var gid = parseInt($("#goods_id").val());
	var amount = parseInt($("#shuliang").val());
	if(isNaN(amount)){amount=1;}
	jQuery.ajax({
		url:'../../buy.php?act=total&gid='+gid+'&amount='+amount,
		dataType:"jsonp",
		jsonp:"callback",
		jsonpCallback:"callback_total",
		success:function(data){},
		error:function(XMLHttpRequest, textStatus, errorThrown){alert('获取信息失败，请重试');},
		complete: function(XMLHttpRequest, textStatus) {}
	});
}
//计算价格回调函数
function callback_total(res){
	$("#shuliang").val(res.amount);
	$("#total").html(res.total);
	$("#goods_id").val(res.gid);
	if(res.flag=='0'){
		alert(res.info);
	}
}
//显示正在载入、操作
function showLoading(isshow){
	$("#loading").remove();
	if(isshow){
		var loadigHtml = '<div id="loading"><span></span></div>';
		$('body').append(loadigHtml);
	}
}