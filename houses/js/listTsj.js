  $(function() {

	$('.hover_el').hover(
		function(){
			$(this).css("background-color","#ffe3e3");
			//alert($(this).children().html());
		},
		function(){
			$(this).css("background-color","#F0F0F0");
		});
	
	$(".hover_el").click(function(){
		var url = "http://" + location.host + "/version2/site/houses/houses/detailTsj.php?id_tsj=" + $(this).attr('id');
		$(location).attr('href',url);
	});
	

  });
