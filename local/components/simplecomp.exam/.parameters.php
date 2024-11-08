<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CAT_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_ID"),
			"TYPE" => "STRING",
		),
		"USER_FIELD" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USER_FIELD"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
	),
);