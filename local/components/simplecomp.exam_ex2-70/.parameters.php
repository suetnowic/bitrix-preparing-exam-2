<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => [
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		],
		"UF_PROP_CODE" => [
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_UF_PROP_CODE"),
			"TYPE" => "STRING",
		],
		"TEMPLATE_DETAIL_URL" => [
			"NAME" => GetMessage("TEMPLATE_DETAIL_URL"),
			"TYPE" => "STRING",
		],
		"ELEMENT_PER_PAGE" => [
			"NAME" => GetMessage("ELEMENT_PER_PAGE"),
			"TYPE" => "STRING",
		],
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	),
);