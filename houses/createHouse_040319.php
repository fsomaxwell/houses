<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/send.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/push_send.php");


$APPLICATION->SetTitle("�������� ����");

?>
<link rel="stylesheet" type="text/css" href="css/create.css?<?php echo time(); ?>"/>
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/create.js?<?php echo time(); ?>"></script>

<p>��� ����������� ��������� ����� ������� ������  �� ������ ���� � ������� <a target="_blank" href="https://yandex.ru/maps/">������-�����</a>.���������� ����������� � �������������� ������� (����� �����) ��� �� ������������ ���� ��� ������� �� ����������� ���� �� �����.</p>
<form id="view_form" enctype="multipart/form-data" action="" method="post">
<div class="enter_div" >
<table class="treatment_form" style="width: 100%;" border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 		
<!--<?
	//������ ���
	$tsj_drop = "<tr id='tsj_list' ><td><b>���:</b><span class='star'> *</span></td><td> <select required name ='sel_tsj_list' id='sel_tsj_list' ><option disabled selected></option>";
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
	//������ �������
	$city_drop = "<tr id='city_list' ><td><b>�����:</b><span class='star'> *</span></td><td> <select required name ='sel_city_list' id='sel_city_list' ><option disabled selected></option>";
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
<?
	//������ ����
	$street_drop = "<tr id='street_list' ><td><b>�����:</b><span class='star'> *</span></td><td> <select required name ='sel_street_list' id='sel_street_list' ><option disabled selected></option>";
$arFilter = Array('IBLOCK_ID'=>1458, 'ACTIVE'=>'Y');
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
	<td><b>� ����:</b><span class="star"> *</span></td>
	<td><input required name="nameHouse" id="nameHouse" type="text" size="34"></td>
</tr> 
<tr>
	<td><b>������ (������ 48.514027):</b><span class="star"> *</span></td>
	<td><input required name="lat" id="lat" type="text" size="34"></td>
</tr>
<tr>
	<td><b>������� (������ 135.155218):</b><span class="star"> *</span></td>
	<td><input required name="lng" id="lng" type="text" size="34"></td>
</tr>
<tr><td><b>���� ����</b></td><td id="td_file"> <input id="file_foto" name="file_foto" type="file" accept="image/*,text/html,text/css" /></td></tr>
</tbody>
</table>
</div>
<br/>
<div style="text-align: center;"><font size="2" style="text-align: center;"><input style="width: 65px; height: 22px;" type="submit" value="�������" id="create" name="create"/></font></div>
<?php
 function translit($s) {
  $s = (string) $s; // ����������� � ��������� ��������
  $s = strip_tags($s); // ������� HTML-����
  $s = str_replace(array("\n", "\r"), " ", $s); // ������� ������� �������
  $s = preg_replace("/\s+/", ' ', $s); // ������� ����������� �������
  $s = trim($s); // ������� ������� � ������ � ����� ������
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // ��������� ������ � ������ ������� (������ ���� ������ ������)
  $s = strtr($s, array('�'=>'a','�'=>'b','�'=>'v','�'=>'g','�'=>'d','�'=>'e','�'=>'e','�'=>'j','�'=>'z','�'=>'i','�'=>'y','�'=>'k','�'=>'l','�'=>'m','�'=>'n','�'=>'o','�'=>'p','�'=>'r','�'=>'s','�'=>'t','�'=>'u','�'=>'f','�'=>'h','�'=>'c','�'=>'ch','�'=>'sh','�'=>'shch','�'=>'y','�'=>'e','�'=>'yu','�'=>'ya','�'=>'','�'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // ������� ������ �� ������������ ��������
  $s = str_replace(" ", "-", $s); // �������� ������� ������ �����
  return $s; // ���������� ���������
}
?>
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
		$dir_name=translit($name_street.$_POST["nameHouse"]);
		$PROP[dir] = $dir_name;
		//echo $_POST["street_input"]." ".$_POST["nameHouse"];
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // ������� ������� ������� �������������
			"IBLOCK_SECTION_ID" => false,          // ������� ����� � ����� �������
			"IBLOCK_ID"      => 1459,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $name_street." ".$_POST["nameHouse"],
			"ACTIVE"         => "Y"        // �������
		);


$dir_path="/version2/site/houses/detail/".$dir_name."/";

		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{ 

CheckDirPath($_SERVER["DOCUMENT_ROOT"].$dir_path);
$content = '<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("'.$name_street.$_POST["nameHouse"].'");?>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>';
			//$content=iconv("windows-1251","utf-8",$content);
			//$convertedText = mb_convert_encoding($content, 'Windows-1252', mb_detect_encoding($content));

			RewriteFile($_SERVER["DOCUMENT_ROOT"].$dir_path."index.php", $content);
			//Directory::createDirectory(Application::getDocumentRoot().$dir_path);


			echo "<div id='dialog-message' title='�������� ����'><p style = 'text-align: center; font-size: 14px; color:red'>".$isExist."��� ������� ������!</p></div>"; }
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