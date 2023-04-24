<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$arComponentParameters = array(
	"GROUPS" => array(
		"VK" => array(
			"NAME" => "Вконтакте",
			"SORT" => 20,
		),
		"YOU" => array(
			"NAME" => "Ютуб",
			"SORT" => 10,
		),
		"VIBER" => array(
			"NAME" => "Viber",
			"SORT" => 30,
		),
		"WA" => array(
			"NAME" => "Whatsapp",
			"SORT" => 40,
		),
		"TG" => array(
			"NAME" => "Телеграмм",
			"SORT" => 50,
		),
	),
	"PARAMETERS" => array(
		"VKONTAKTE_LINK" => array(
			"NAME" => "Ссылка",
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "VK",
		),
		"VKONTAKTE_CHECK" => array(
			"NAME" => "Отображать",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "VK",
		),
		"YOUTUBE_LINK" => array(
			"NAME" => "Ссылка",
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "YOU",
		),
		"YOUTUBE_CHECK" => array(
			"NAME" => "Отображать",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "YOU",
		),
		"VIBER_LINK" => array(
			"NAME" => "Номер (без +)",
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "VIBER",
		),
		"VIBER_CHECK" => array(
			"NAME" => "Отображать",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "VIBER",
		),
		"WA_LINK" => array(
			"NAME" => "Номер (без +)",
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "WA",
		),
		"WA_CHECK" => array(
			"NAME" => "Отображать",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "WA",
		),
		"TG_LINK" => array(
			"NAME" => "Ссылка",
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "TG",
		),
		"TG_CHECK" => array(
			"NAME" => "Отображать",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "TG",
		),
	),
);
?>
