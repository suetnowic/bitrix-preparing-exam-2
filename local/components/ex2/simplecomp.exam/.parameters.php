<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"USER_UF_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USER_UF_CODE"),
			"TYPE" => "STRING",
		),
		"PROPERTY_AUTHOR" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PROPERTY_AUTHOR"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	),
);