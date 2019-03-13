<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/send.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/push_send.php");
$APPLICATION->SetTitle("Создание улицы");
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
<tr>
	<td><b>Название улицы:</b><span class="star"> *</span></td>
	<td><input required name="nameStreet" id="nameStreet" type="text" size="34"></td>
</tr> 
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
		
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => 1458,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $_POST["nameStreet"],
			"ACTIVE"         => "Y"        // активен
		);

		if($PRODUCT_ID = $el->Add($arLoadProductArray))
		{ echo "<div id='dialog-message' title='Создание улицы'><p style = 'text-align: center; font-size: 14px; color:red'>Улица успешно создана!</p></div>"; }
		else
		  echo "Error: ".$el->LAST_ERROR;	
		echo "</br>";

		
	}?>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>