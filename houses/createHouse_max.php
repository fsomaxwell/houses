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
<form id="view_form" action="" method="post">
<div class="enter_div" >
<table class="treatment_form" style="width: 100%;" border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 		
<?
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
?>	
<?
	//������ ����
	$street_drop = "<tr id='street_list' ><td><b>�����:</b><span class='star'> *</span></td><td> <select required name ='sel_street_list' id='sel_street_list' ><option disabled selected></option>";
	$arFilter = Array('IBLOCK_ID'=>1458, 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$street_drop .= "<option value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
	}
	$street_drop .= "</select>";
	$street_drop .= "<input type='hidden' name='street_input' id='street_input'/>";
	$street_drop .= "</td></tr>";
    echo $street_drop;  
?>		  
<tr>
	<td><b>� ����:</b><span class="star"> *</span></td>
	<td><input required name="nameHouse" id="nameHouse" type="text" size="34"></td>
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
		$PROP[tsj] = $_POST['sel_tsj_list'];  
		$PROP[street] = $_POST['sel_street_list'];  
		//echo $_POST["street_input"]." ".$_POST["nameHouse"];
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // ������� ������� ������� �������������
			"IBLOCK_SECTION_ID" => false,          // ������� ����� � ����� �������
			"IBLOCK_ID"      => 1459,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $_POST["street_input"]." ".$_POST["nameHouse"],
			"ACTIVE"         => "Y"        // �������
		);

		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{ echo "<div id='dialog-message' title='�������� ����'><p style = 'text-align: center; font-size: 14px; color:red'>��� ������� ������!</p></div>"; }
		else
		  echo "Error: ".$el->LAST_ERROR;	
		echo "</br>";

		
	}?>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>