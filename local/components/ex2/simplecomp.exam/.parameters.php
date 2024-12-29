<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"UF_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USER_UF_CODE"),
			"TYPE" => "STRING",
		),
		"AUTHOR" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PROPERTY_AUTHOR"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
		"CACHE_GROUPS" => [
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CP_BN_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		],
	),
);