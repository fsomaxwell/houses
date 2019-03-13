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
		var url = "http://" + location.host + "/version2/site/houses/houses/detailStreet.php?id_street=" + $(this).attr('id');
		$(location).attr('href',url);
	});
	

  });
