<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Перечень улиц");
?>
 
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/listStreet.js?<?php echo time(); ?>"></script>
<link rel="stylesheet" href="css/list.css?<?php echo time(); ?>"></link>


</br>
    <div class="enter_div" >

		<table class="treatment_form" cellspacing="1" cellpadding="1" style="width: 97%;" > 
          <tbody>  
				<tr><th>Название улиц</th><th>Город</th></tr>
			<?
			CModule::IncludeModule("iblock");
			$arFilter = Array("IBLOCK_ID"=>1458, "ACTIVE"=>"Y");
			$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME","PROPERTY_CITY.NAME"));
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				echo "<tr class='hover_el' id='".$arFields["ID"]."'><td >".$arFields["NAME"]."</td>";
				 echo "<td>".$arFields["PROPERTY_CITY_NAME"]."</td>";
                echo "</tr>";
			}
			?> 			
           </tbody>
         </table>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>