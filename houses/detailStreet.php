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
		$PROP[city]=$_POST["sel_city_list"];
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			"IBLOCK_ID"      => 1458,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $_POST["nameStreet"],
		);

	if($el->Update($_GET["id_street"],$arLoadProductArray))
		{ 
			echo "<div id='dialog-message' title='Изменение улицы'><p style = 'text-align: center; font-size: 14px; color:red'>Улица успешно изменена!</p></div>"; 
		}
		else
			echo "Error: ".$el->LAST_ERROR;	
		echo "</br>";
		
	}
?>

<?
if (isset($_POST['delete'])) 
	{
	if(CIBlockElement::Delete($_GET["id_street"]))
		{ 
			require($_SERVER["DOCUMENT_ROOT"]."/houses/listStreet.php"); 
		}
		else
			echo "Ошибка удаления!";	
		echo "</br>";
		
	}
?>
	
<?
if (isset($_GET['id_street'])) 
	{
		$id_street = $_GET['id_street'];
		$res = CIBlockElement::GetByID($_GET['id_street']);
		if($ar_res = $res->GetNext())
		   $name_street = $ar_res['NAME'];
 $db_props = CIBlockElement::GetProperty(1458,  $ar_res['ID'], array("sort" => "asc"), Array("CODE"=>"CITY"));
            if($ar_props = $db_props->Fetch())
                $id_city = $ar_props["VALUE"];
		
	}?>
<form id="view_form" action="" method="post">
<div class="enter_div" >
<table class="treatment_form" style="width: 100%;" border="0" cellpadding="1" cellspacing="5"> 
          <tbody> 			
<?
    //Список городов
    $city_drop = "<tr id='city_list' ><td><b>Город:</b><span class='star'> *</span></td><td> <select required name ='sel_city_list' id='sel_city_list' ><option disabled selected></option>";
    $arFilter = Array('IBLOCK_ID'=>1624, 'ACTIVE'=>'Y');
    $res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));

    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        if($arFields["ID"] == $id_city)
        {
            $city_drop .= "<option selected value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
        }else{
            $city_drop .= "<option value=".$arFields["ID"].">".$arFields["NAME"]."</option>";
        }
    }
    $city_drop .= "</select>";
    $city_drop .= "</td></tr>";
    echo $city_drop;  
?>        
<tr>
	<td><b>Название улицы:</b><span class="star"> *</span></td>
	<td><input required name="nameStreet" id="nameStreet" type="text" size="34" value="<?echo $name_street?>">
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