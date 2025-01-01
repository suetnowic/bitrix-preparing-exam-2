<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"AUTHOR_PROP_CODE" => [
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_AUTHOR_PROP_CODE"),
			"TYPE" => "STRING",
		],
		"UF_FIELD" => [
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_UF_FIELD"),
			"TYPE" => "STRING",
		],
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	),
);