<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Экзамен2");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam_ex2-71",
	"",
	Array(
		"PRODUCTS_IBLOCK_ID" => ""
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>