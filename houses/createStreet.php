<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/send.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/push_send.php");
$APPLICATION->SetTitle("�������� �����");
?>
<link rel="stylesheet" type="text/css" href="css/create.css?<?php echo time(); ?>"/>
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/create.js?<?php echo time(); ?>"></script>
<form id="view_form" action="" method="post">
<div class="enter_div" >
<table class="treatment_form" style="width: 100%;" border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 	
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
<tr>
	<td><b>�������� �����:</b><span class="star"> *</span></td>
	<td><input required name="nameStreet" id="nameStreet" type="text" size="34"></td>
</tr> 
</tbody>
</table>
</div>
<br/>
<div style="text-align: center;"><font size="2" style="text-align: center;"><input style="width: 65px; height: 22px;" type="submit" value="�������" id="create" name="create"/></font></div>
<?
if (isset($_POST['create'])) 
	{
		$el = new CIBlockElement;

		$PROP = array();
		$PROP[city] = $_POST["sel_city_list"]; 
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // ������� ������� ������� �������������
			"IBLOCK_SECTION_ID" => false,          // ������� ����� � ����� �������
			"IBLOCK_ID"      => 1458,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $_POST["nameStreet"],
			"ACTIVE"         => "Y"        // �������
		);

		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{ echo "<div id='dialog-message' title='�������� �����'><p style = 'text-align: center; font-size: 14px; color:red'>����� ������� �������!</p></div>"; }
		else
		  echo "Error: ".$el->LAST_ERROR;	
		echo "</br>";

		
	}?>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>