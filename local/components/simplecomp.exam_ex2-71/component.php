<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

global $USER;
if($this->StartResultCache(false, $USER->GetGroups())) {
	if(
		intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0 &&
		intval($arParams["CLASSIFICATOR_IBLOCK_ID"]) > 0 &&
		!empty($arParams["PROPERTY_CODE"]) && 
		!empty($arParams["TEMPLATE_DETAIL_URL"])
	) {
		
		$arFirm = [];

		$rsClassificator = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["CLASSIFICATOR_IBLOCK_ID"],
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"]
			],
			false,
			false,
			["ID", "NAME"]
		);
		while($ob = $rsClassificator->GetNext()) {
			$arFirm[$ob["ID"]] = $ob;
		}

		$result["FIRM_DATA"] = $arFirm;

		$rsProducts = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y",
				"CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
				"=PROPERTY_" . $arParams["PROPERTY_CODE"] => array_column($arFirm, "ID"),
			],
			false,
			false,
			["ID", "NAME", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_PRICE", "IBLOCK_SECTION_ID", "PROPERTY_" . $arParams["PROPERTY_CODE"]]
		);
		while($ob = $rsProducts->GetNext()) {

			$result["FIRM_DATA"][$ob["PROPERTY_" . $arParams["PROPERTY_CODE"] . "_VALUE"]]["PRODUCTS"][] = [
				"ID" => $ob["ID"],
				"NAME" => $ob["NAME"],
				"PRICE" => $ob["PROPERTY_PRICE_VALUE"],
				"MATERIAL" => $ob["PROPERTY_MATERIAL_VALUE"],
				"ARTNUMBER" => $ob["PROPERTY_ARTNUMBER_VALUE"],
				"DETAIL" => str_replace(["#SECTION_ID#", "#ELEMENT_ID#"], [$ob["IBLOCK_SECTION_ID"], $ob["ID"]], $arParams["TEMPLATE_DETAIL_URL"])
			];

		}

		$arResult["ITEMS"] = $result["FIRM_DATA"];
		$arResult["FIRM_QTY"] = count($arFirm);
 		
	}
}

$this->includeComponentTemplate();

$APPLICATION->SetTitle(GetMessage("COUNT_TITLE", ["#COUNT#" => $arResult["FIRM_QTY"]]));
?>