<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    ShowError('Модуль «Информационные блоки» не установлен');
}

$cache_id = serialize($arParams); 

$obCache = new CPHPCache; 

$arResult = [];

if ($obCache->InitCache($arParams["CACHE_TIME"], $cache_id)) { // тянем данные если они есть
   $arResult = $obCache->GetVars(); 

   echo '<pre>'. print_r($isCache='кеш действителен', 1) . '</pre>';
//    echo '<pre>'. print_r($obCache, 1) . '</pre>';

} 
elseif ($obCache->StartDataCache()) { // иначе запишем для того, чтобы следующий раз получить 
	
	$arSocialList = [];

	$arFilter = [
		"IBLOCK_ID" => 4, 
		"ID" => $arParams["SOCLINKS"],
		"ACTIVE_DATE" => "Y", 
		"ACTIVE" => "Y",
		"!PROPERTY_SOCLINK" => false,	///@TODO офлыволфыв
	];

	$arSelect = [
		"ID",
		"NAME",
		"PROPERTY_SOCLINK",
		"PROPERTY_SOCIMG"
	];

	$rsSocial = CIBlockElement::GetList (
		[], 
		$arFilter, 
		false,
		false, 
		$arSelect,
	);

	while($arSocial = $rsSocial->Fetch()) {
		$arSocialList[$arSocial["ID"]] = $arSocial;
	}

	foreach ($arSocialList as $item) {
		$arResult[$item["ID"]] = [
			"LINK" => $item["PROPERTY_SOCLINK_VALUE"],
			"SRC" => $item["PROPERTY_SOCIMG_VALUE"],
		];
	}

   $obCache->EndDataCache($arResult);

   echo '<pre>'. print_r($isCache='кеш отсутствует', 1) . '</pre>';
   
}

$this->IncludeComponentTemplate();

// if ($this->StartResultCache($arParams["CACHE_TIME"])) {

// 	$arResult = [];

// 	$arSocialList = [];

// 	$arFilter = [
// 		"IBLOCK_ID" => 4, 
// 		"ID" => $arParams["SOCLINKS"],
// 		"ACTIVE_DATE" => "Y", 
// 		"ACTIVE" => "Y",
// 		"!PROPERTY_SOCLINK" => false,	///@TODO офлыволфыв
// 	];

// 	$arSelect = [
// 		"ID",
// 		"NAME",
// 		"PROPERTY_SOCLINK",
// 		"PROPERTY_SOCIMG"
// 	];

// 	$rsSocial = CIBlockElement::GetList (
// 		[], 
// 		$arFilter, 
// 		false,
// 		false, 
// 		$arSelect,
// 	);

// 	while($arSocial = $rsSocial->Fetch()) {
// 		$arSocialList[$arSocial["ID"]] = $arSocial;
// 	}

// 	foreach ($arSocialList as $item) {
// 		$arResult[$item["ID"]] = array(
// 			"LINK" => $item["PROPERTY_SOCLINK_VALUE"],
// 			"SRC" => $item["PROPERTY_SOCIMG_VALUE"],
// 		);
// 	}

// 	$this->IncludeComponentTemplate();

// 	echo '<pre>'. print_r($dsd='кеш отсутствует', 1) . '</pre>';
// } else {
// 	echo '<pre>'. print_r($dsd='кеш действителен', 1) . '</pre>';
// }

// echo '<pre>'. print_r($arResult, 1) . '</pre>';
?>