<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дома в управлении");
?> 
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<link rel="stylesheet" href="css/houses.css?<?php echo time(); ?>"></link>

<?
	CModule::IncludeModule("iblock");
	
	
?>
    <div id="main_div"  class="main_div">
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
            CModule::IncludeModule("iblock");
            $arFilter = Array("IBLOCK_ID"=>1459, "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME","PROPERTY_STREET.PROPERTY_CITY","PROPERTY_FOTO","PROPERTY_DIR"));
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                echo '<a class="a_house" href="detail\\'.$arFields["PROPERTY_DIR_VALUE"].'\\"><div class="'.$arFields["PROPERTY_STREET_PROPERTY_CITY_VALUE"].'" id="'.$arFields["ID"].'"><p class="p_house">'.$arFields["NAME"].'</p>';
				$file = CFile::ResizeImageGet($arFields["PROPERTY_FOTO_VALUE"], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_EXACT, true);                
                  echo "<img class='img_house' src=".$file['src'].">";
                echo "</div></a>";
            }
            ?>            
          
    </div>
<script>
$('#sel_city_list').change(function () {
var id_city =$('#sel_city_list').val();

	if (id_city=="0000") {$("#main_div div").css("display","inline-block");}
	else {
$("#main_div div[class!='"+id_city+"']").css("display","none");
		$("."+id_city).css("display","inline-block"); }

});
</script>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>