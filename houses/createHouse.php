<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/version2/site/scripts/functions.php");

$APPLICATION->SetTitle("Создание дома");

$exemp= new RG();

?>
<link rel="stylesheet" type="text/css" href="css/create.css?<?php echo time(); ?>"/>
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/create.js?<?php echo time(); ?>"></script>

<p>Для определения координат можно сделать запрос  по адресу дома в сервисе <a target="_blank" href="https://yandex.ru/maps/">Яндекс-карты</a>.Координаты скопировать с информационной области (левая форма) или из всплывающего окна при нажатии на изображение дома на карте.</p>
<form id="view_form" enctype="multipart/form-data" action="" method="post">
<div class="enter_div" >
<table class="treatment_form" style="width: 100%;" border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 		
<!--<?
	//Список ТСЖ
	$tsj_drop = "<tr id='tsj_list' ><td><b>ТСЖ:</b><span class='star'> *</span></td><td> <select required name ='sel_tsj_list' id='sel_tsj_list' ><option disabled selected></option>";
	$arFilter = Array('IBLOCK_ID'=>1457, 'ACTIVE'=>'Y');
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$tsj_drop .= "<option value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
	}
	$tsj_drop .= "</select></td></tr>";
    echo $tsj_drop;  
?>	 -->
<?
	//Список Городов
	$city_drop = "<tr id='city_list' ><td><b>Город:</b><span class='star'> *</span></td><td> <select required name ='sel_city_list' id='sel_city_list' ><option disabled selected></option>";
	$arFilter = Array('IBLOCK_ID'=>$exemp->city_ibl, 'ACTIVE'=>'Y');
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
<?
	//Список улиц
	$street_drop = "<tr id='street_list' ><td><b>Улица:</b><span class='star'> *</span></td><td> <select required name ='sel_street_list' id='sel_street_list' ><option disabled selected></option>";
$arFilter = Array('IBLOCK_ID'=>$exemp->street_ibl, 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME","PROPERTY_CITY"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$street_drop .= '<option style="display: none;" value='.$arFields["ID"].'  class='.$arFields["PROPERTY_CITY_VALUE"].'>'.$arFields["NAME"].'</option>';
	}
	$street_drop .= "</select>";
	$street_drop .= "</td></tr>";
echo $street_drop;  
?>		  
<tr>
	<td><b>№ дома:</b><span class="star"> *</span></td>
	<td><input required name="nameHouse" id="nameHouse" type="text" size="34"></td>
</tr> 
<tr>
	<td><b>Широта (формат 48.514027):</b><span class="star"> *</span></td>
	<td><input required name="lat" id="lat" type="text" size="34"></td>
</tr>
<tr>
	<td><b>Долгота (формат 135.155218):</b><span class="star"> *</span></td>
	<td><input required name="lng" id="lng" type="text" size="34"></td>
</tr>
<tr><td><b>Фото дома</b></td><td id="td_file"> <input id="file_foto" name="file_foto" type="file" accept="image/*,text/html,text/css" /></td></tr>
</tbody>
</table>
</div>
<br/>
<div style="text-align: center;"><font size="2" style="text-align: center;"><input style="width: 65px; height: 22px;" type="submit" value="Создать" id="create" name="create"/></font></div>
<?
if (isset($_POST['create'])) 
	{

		$el = new CIBlockElement;
		$PROP = array();
		$PROP[tsj] = $_POST['sel_tsj_list'];  
		$PROP[street] = $_POST['sel_street_list'];  
		$PROP[house] = $_POST["nameHouse"];  
		$PROP[lat] = $_POST["lat"];
		$PROP[lng] = $_POST["lng"];
		$PROP[foto] = $_FILES["file_foto"];
		$obElement = CIBlockElement::GetByID($_POST['sel_street_list']);
		if($ar_res = $obElement->GetNext())
  		$name_street= $ar_res['NAME'];
		$dir_name=transliterate($name_street."_".$_POST["nameHouse"]);
		$dir_name=strtolower($dir_name);
		$dir_name = str_replace(".","_",$dir_name);
		$PROP[dir] = $dir_name;
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => $exemp->house_ibl,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $name_street." ".$_POST["nameHouse"],
			"ACTIVE"         => "Y"        // активен
		);


$dir_path="/version2/site/houses/detail/".$dir_name."/";

		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{ 

CheckDirPath($_SERVER["DOCUMENT_ROOT"].$dir_path);
$content = '<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("'.$name_street." ".$_POST["nameHouse"].'");?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>';
RewriteFile($_SERVER["DOCUMENT_ROOT"].$dir_path."index.php", $content);

		echo "<div id='dialog-message' title='Создание дома'><p style = 'text-align: center; font-size: 14px; color:red'>".$isExist."Дом успешно создан!</p></div>"; }
		else
		echo "Error: ".$el->LAST_ERROR;	
		echo "</br>";

		
	}?>
</form>
<script>
$('#sel_city_list').change(function () {
$("#sel_street_list").prop('selectedIndex', 0);
var id_city =$('#sel_city_list').val();
$("#sel_street_list option[class!='"+id_city+"']").css("display","none");
	$("."+id_city).css("display","");

});
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>