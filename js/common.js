$(function(){
	$("#pagesize").change(function(){
		var size = $(this).val();
		$.ajax({
			type:'get',
			url:'json.php?act=setpagesize&pagesize='+size,
			dataType:'json',
			success:function(data){
				if(data.flag=='1'){
					location.reload();
				}
			},
			complete:function(XMLHttpRequest,textStatus){},
			error:function(){}
		});

	});
});