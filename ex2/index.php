<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Экзамен2");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam_ex2-71", 
	".default", 
	array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CLASSIFICATOR_IBLOCK_ID" => "7",
		"PRODUCTS_IBLOCK_ID" => "2",
		"PROPERTY_CODE" => "COMPANY",
		"TEMPLATE_DETAIL_URL" => "/products/#SECTION_ID#/#ELEMENT_ID#/",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>