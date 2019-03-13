

<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

    if(CModule::IncludeModule("iblock"))
        {

$IBLOCK_ID = 1459;        // указываем из какого инфоблока берем элементы

$arOrder = Array("SORT"=>"AES");    // сортируем по свойству SORT по возрастанию
$arSelect = Array("ID", "NAME",  "PROPERTY_DIR");
$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

    while($ob = $res->GetNextElement())
    {
    $arFields = $ob->GetFields();           
    $aMenuLinksExt[] = Array(
                $arFields['NAME'],
                "detail/".$arFields['PROPERTY_DIR_VALUE']."/",
                Array(),
                Array(),
                ""
                );
    
    }       
    
        }    

 $aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
// $aMenuLinks = array_merge($aMenuLinks);

?>
