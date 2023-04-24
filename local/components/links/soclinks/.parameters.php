<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
return;

$dbIBlocks = CIBlock::GetList(
    array(
        "SORT"  =>  "ASC"
    ),
    array(
        "ACTIVE"    =>  "Y",
        "TYPE"      =>  $arCurrentValues["IBLOCK_TYPE"],
    ));

while ($arIBlocks = $dbIBlocks->GetNext())
{
    $paramIBlocks[$arIBlocks["ID"]] = "[" . $arIBlocks["ID"] . "] " . $arIBlocks["NAME"];
}

$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y");

$rsSocial = CIBlockElement::GetList(
    Array(),
    $arFilter,
    false,
    false,
    Array("ID", "NAME", "PROPERTY_SOCNAME"));

$arSocialList = [];

while($arSocial = $rsSocial->Fetch()){
    $arSocialList[$arSocial["ID"]] = $arSocial["PROPERTY_SOCNAME_VALUE"];
    // echo "<pre>".print_r($arSocialList, 1)."</pre>";
}

$arComponentParameters = array(
    "GROUPS" => array(
        "SOCLINKS"    =>  array(
            "NAME"  =>  "Соц сети",
            "SORT"  =>  "300",
        ),
    ),
    "PARAMETERS" => array(
        "IBLOCK_ID" =>  array(
            "PARENT"    =>  "SOCLINKS",
            "NAME"      =>  "Инфоблок",
            "TYPE"      =>  "LIST",
            "VALUES"    =>  $paramIBlocks,
            "REFRESH"   =>  "Y",
            "MULTIPLE"  =>  "N",
            "DEFAULT"   =>  $arCurrentValues["IBLOCK_ID"]=4,
        ),
        "SOCLINKS" =>  array(
            "PARENT"    =>  "SOCLINKS",
            "NAME"      =>  "Социальные сети",
            "TYPE"      =>  "LIST",
            "VALUES"    =>  $arSocialList,
            "MULTIPLE"  =>  "Y",
            "SIZE"      =>  "5",
            "DEFAULT"   =>  "",
        ),
        "CACHE_TIME" => array(
            "DEFAULT"   => 604800, // Время кеширования в секундах
        )

    ),
);
?>