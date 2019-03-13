<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дома в управлении");
?> 
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script type="text/javascript" src="js/data.json"></script>
<script type="text/javascript" src="js/markerclusterer.js"></script>


<link rel="stylesheet" href="css/houses.css?<?php echo time(); ?>"></link>

<?
	CModule::IncludeModule("iblock");
	
	
?>
    <div id="main_div2"  class="main_div2">
	<table class="treatment_form"  border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 
	<?
//Список Городов
    $city_drop = "<tr id='city_list' ><td><b>Город:</b><td> <select required name ='sel_city_list' id='sel_city_list' ><option value=0000 selected>Все города</option>";
    $arFilter = Array('IBLOCK_ID'=>1624, 'ACTIVE'=>'Y');
    CModule::IncludeModule("iblock");
    $res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
		$city_drop .= "<option value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
    }
    $city_drop .= "</select></td></tr>";
    echo $city_drop;  
?>
</tbody>
</table> 

            <?
			$json_text = '{"gps":[';
			$json_text2 = '[';
            CModule::IncludeModule("iblock");
            $arFilter = Array("IBLOCK_ID"=>1459, "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME","PROPERTY_STREET.PROPERTY_CITY","PROPERTY_LAT","PROPERTY_LNG"));
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
				if ($arFields["PROPERTY_LAT_VALUE"]<>"")
				$json_text=$json_text.'{"name":"'.$arFields["NAME"].'","lat":"'.$arFields["PROPERTY_LAT_VALUE"].'","lng":"'.$arFields["PROPERTY_LNG_VALUE"].'"},';
				$json_text2=$json_text2.'{lat:'.$arFields["PROPERTY_LAT_VALUE"].',lng:'.$arFields["PROPERTY_LNG_VALUE"].'},';
	}
			$json_text = rtrim($json_text,",");
			$json_text =$json_text.']}';
			$json_text2 = rtrim($json_text2,",");
			$json_text2 =$json_text2.']';
            ?>            
          

<div id="map"></div>
<script>

var json_text = <?php echo "'".$json_text."'"; ?>;
var obj = JSON.parse( json_text );

function initMap2() {
	var flngnew = parseFloat('135.068800');
	var flatnew = parseFloat('48.478222');
	var uluru = {lat: flatnew,lng: flngnew};
var map = new google.maps.Map(document.getElementById('map'), {
				  zoom:14,
				  center:uluru
				});
var i=0,LatLng;
var bounds = new google.maps.LatLngBounds();
var markers = [];
	for (i=0;i<obj.gps.length;i++){
flngnew = parseFloat(obj.gps[i].lng);
flatnew = parseFloat(obj.gps[i].lat);
LatLng = {lat: flatnew,lng:flngnew };

var image = new google.maps.MarkerImage('marker_dom4.png',
 new google.maps.Size(39, 56),
 new google.maps.Point(0,0),
 new google.maps.Point(20, 50)
);

    var marker = new google.maps.Marker({
		position: LatLng,              // Координаты расположения маркера. В данном случае координаты нашего маркера совпадают с центром карты, но разумеется нам никто не мешает создать отдельную переменную и туда поместить другие координаты.
		map: map,  
		icon: image,                          // Карта на которую нужно добавить маркер
		title: obj.gps[i].name
		 // (Необязательно) Текст выводимый в момент наведения на маркер
	});


		//var infowindow = new google.maps.InfoWindow({
		// content: marker.title
		//});

		//google.maps.event.addListener(marker, 'click', function() {
		//infowindow.open(map, this);
		//});
		//markers.push(marker);

bounds.extend(LatLng);
	}
	//markerClusterer = new MarkerClusterer(map, markers, 
	//{ 
	//maxZoom: 13,
	//gridSize: 50,
	//styles: null 
	//});
map.setCenter(bounds.getCenter(), map.fitBounds(bounds)); 
}
</script>

<script>

var json_text = <?php echo "'".$json_text."'"; ?>;
var obj = JSON.parse( json_text );
      function initMap() {

        	var flngnew = parseFloat('135.068800');
	var flatnew = parseFloat('48.478222');
	var uluru = {lat: flatnew,lng: flngnew};
var map = new google.maps.Map(document.getElementById('map'), {
				  zoom:14,
				  center:uluru
				});

 var image = new google.maps.MarkerImage('marker_dom5.png',
 new google.maps.Size(30, 43),
 new google.maps.Point(0,0),
 new google.maps.Point(15, 40)
);

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
          var marker= new google.maps.Marker({
            position: location,
			icon: image,                         
			  title: obj.gps[i].name
			  //,label: labels[i % labels.length]
          });



 google.maps.event.addListener(marker, 'click', function(evt) {
    infoWin.setContent(obj.gps[i].name);
    infoWin.open(map, marker);
  })
  return marker;
        });

var bounds = new google.maps.LatLngBounds();
var i=0,LatLng;
for (i=0;i<locations.length;i++){
bounds.extend(locations[i]);
}


map.setCenter(bounds.getCenter(), map.fitBounds(bounds)); 

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
												{imagePath: "images/m"});


      }


      var locations = <?php echo $json_text2; ?>;
    </script>
<script src="js/markerclusterer.js">
    </script>
	<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkUzRGYIzsKp0eLjurTT1-HAHhX7uZOw4&callback=initMap">
		</script>



</div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>