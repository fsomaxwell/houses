<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Перечень ТСЖ");
?>
 
<link rel="stylesheet" href="/bitrix/js/jquery/Smoothness/css/smoothness/jquery-ui-1.10.1.custom.css"></link> 
<script src="/bitrix/js/jquery/js/jquery-1.9.1.js"></script>
<script src="/bitrix/js/jquery/js/jquery-ui-1.10.1.custom.js"></script>
<script src="js/listTsj.js?<?php echo time(); ?>"></script>
<link rel="stylesheet" href="css/list.css?<?php echo time(); ?>"></link>


</br>
    <div class="enter_div" >

		<table class="treatment_form" cellspacing="1" cellpadding="1" style="width: 97%;" > 
          <tbody>  
				<tr><th>Название ТСЖ</th></tr>
			<?
			CModule::IncludeModule("iblock");
			$arFilter = Array("IBLOCK_ID"=>1457, "ACTIVE"=>"Y");
			$res = CIBlockElement::GetList(Array("NAME"=>"asc"), $arFilter, false, false, Array("ID","NAME"));
			while($ob = $res->GetNextElement())
			{
				$arFields = $ob->GetFields();
				echo "<tr class='hover_el' id='".$arFields["ID"]."'><td style='width:100%'>".$arFields["NAME"]."</td></tr>";
			}
			?>			
           </tbody>
         </table>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>