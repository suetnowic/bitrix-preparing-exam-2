<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam_ex2-71", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"PRODUCTS_IBLOCK_ID" => "2",
		"CLASSIFICATOR_IBLOCK_ID" => "7",
		"TEMPLATE_DETAIL_URL" => "/products/#SECTION_ID#/#ELEMENT_ID#/",
		"PROPERTY_CODE" => "COMPANY"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>