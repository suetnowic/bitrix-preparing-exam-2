<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam_ex2_97", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"NEWS_IBLOCK_ID" => "1",
		"AUTHOR_PROP_CODE" => "AUTHOR",
		"UF_FIELD" => "UF_AUTHOR_TYPE"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>