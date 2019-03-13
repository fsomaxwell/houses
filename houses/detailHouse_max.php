<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/send.php");
require($_SERVER["DOCUMENT_ROOT"]."/scripts/push_send.php");
$APPLICATION->SetTitle("Изменение улицы");
?>
<link rel="stylesheet" type="text/css" href="css/create.css?<?php echo time(); ?>"/>
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/create.js?<?php echo time(); ?>"></script>
<?
if (isset($_POST['edit'])) 
	{
		$el = new CIBlockElement;
		$PROP = array();
		$PROP[tsj] = $_POST['sel_tsj_list'];  
		$PROP[street] = $_POST['sel_street_list']; 
		$PROP[upravdom] = $_POST['upravdom']; 		
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => 1459,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $_POST["street_input"]." ".$_POST["nameHouse"],
		);

	if($el->Update($_GET["id_house"],$arLoadProductArray))
		{ 
			echo "<div id='dialog-message' title='Изменение дома'><p style = 'text-align: center; font-size: 14px; color:red'>Дом успешно изменен!</p></div>"; 
		}
		else
			echo "Error: ".$el->LAST_ERROR;	
		echo "</br>";
		
	}
?>

<?
if (isset($_POST['delete'])) 
	{
	if(CIBlockElement::Delete($_GET["id_house"]))
		{ 
			require($_SERVER["DOCUMENT_ROOT"]."/houses/listHouse.php"); 
		}
		else
			echo "Ошибка удаления!";	
		echo "</br>";
		
	}
?>
	
<?
if (isset($_GET['id_house'])) 
	{
		$res = CIBlockElement::GetByID($_GET['id_house']);
		if($ar_res = $res->GetNext())
		{			
			$db_props = CIBlockElement::GetProperty(1459,  $ar_res['ID'], array("sort" => "asc"), Array("CODE"=>"TSJ"));
			if($ar_props = $db_props->Fetch())
				$id_tsj = $ar_props["VALUE"];	
			$db_props = CIBlockElement::GetProperty(1459,  $ar_res['ID'], array("sort" => "asc"), Array("CODE"=>"STREET"));
			if($ar_props = $db_props->Fetch())
				$id_street = $ar_props["VALUE"];
			$db_props = CIBlockElement::GetProperty(1459,  $ar_res['ID'], array("sort" => "asc"), Array("CODE"=>"UPRAVDOM"));
			if($ar_props = $db_props->Fetch())
				$id_upravdom = $ar_props["VALUE"];
			$res2 = CIBlockElement::GetByID($id_street);
			if($ar_res2 = $res2->GetNext())
			{
				$name_street = $ar_res2['NAME'];
				$name_street .=" ";
			}
			$name_house = $ar_res['NAME'];
			$name_house = str_replace($name_street, "", $name_house);
		}
		
	}?>
<form id="view_form" action="" method="post">
<div class="enter_div" >
<table class="treatment_form" style="width: 100%;" border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 		
<?
	//Список ТСЖ
	$tsj_drop = "<tr id='tsj_list' ><td><b>ТСЖ:</b><span class='star'> *</span></td><td> <select required name ='sel_tsj_list' id='sel_tsj_list' ><option disabled selected></option>";
	$arFilter = Array('IBLOCK_ID'=>1457, 'ACTIVE'=>'Y');
	CModule::IncludeModule("iblock");
	$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		if($arFields["ID"] == $id_tsj)
		{
			$tsj_drop .= "<option selected value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
		}else{
			$tsj_drop .= "<option value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
		}
	}
	$tsj_drop .= "</select></td></tr>";
    echo $tsj_drop;  
?>	
<?
	//Список улиц
	$street_drop = "<tr id='street_list' ><td><b>Улица:</b><span class='star'> *</span></td><td> <select required name ='sel_street_list' id='sel_street_list' ><option disabled selected></option>";
	$arFilter = Array('IBLOCK_ID'=>1458, 'ACTIVE'=>'Y');
	$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		if($arFields["ID"] == $id_street)
		{
			$street_drop .= "<option selected value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
		}else{
			$street_drop .= "<option value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
		}
	}
	$street_drop .= "</select>";
	$street_drop .= "<input type='hidden' name='street_input' id='street_input'/>";
	$street_drop .= "</td></tr>";
    echo $street_drop;  
?>			  
<tr>
	<td><b>№ дома:</b><span class="star"> *</span></td>
	<td><input required name="nameHouse" id="nameHouse" type="text" size="34" value="<?echo $name_house?>">
		<input name="upravdom" id="upravdom" type="hidden" size="34" value="<?echo $id_upravdom?>">
	</td>
</tr> 
</tbody>
</table>
</div>
<br/>
<div style="text-align: center;">
	<font size="2" style="text-align: center;">
		<input style="width: 65px; height: 22px;" type="submit" value="Изменить" id="edit" name="edit"/>
		<input style="width: 65px; height: 22px;" type="submit" value="Удалить" id="delete" name="delete"/>
	</font>
</div>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>