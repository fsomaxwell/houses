  $(function() {
	$( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
	// Для создания домов
	$("#sel_street_list").on("change",function(){
		$("#street_input").val($(this).children("option").filter(":selected").text());
	});
  });

$(document).ready(function() {

$('[name=lat]').bind("change keyup input click", function() {if (this.value.match(/[^0-9\.]/g)) {this.value = this.value.replace(/[^0-9\.]/g, '');}});
$('[name=lng]').bind("change keyup input click", function() {if (this.value.match(/[^0-9\.]/g)) {this.value = this.value.replace(/[^0-9\.]/g, '');}});

});


