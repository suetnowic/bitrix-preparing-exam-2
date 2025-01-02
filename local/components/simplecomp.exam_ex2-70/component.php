<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

$filter = false;

if(isset($_GET['F'])) {
	$filter = true;
}

if($this->StartResultCache(false, $filter)) {

	if (
		intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0 && 
		intval($arParams["NEWS_IBLOCK_ID"]) > 0 && 
		!empty($arParams["UF_PROP_CODE"])
	) {

		$arSections = [];
		$arProducts = [];
		$arNews = [];
		$productQty = 0;

		$rsSect = CIBlockSection::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y",
			],
			false,
			["ID", "NAME", $arParams["UF_PROP_CODE"]],
			false
		);
		while($arElement = $rsSect->GetNext()) {
			$arSections[$arElement["ID"]] = $arElement;
		}

		$arProductFilter = [
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y",
		];

		if($filter) {
			$arProductFilter[] = [
				"LOGIC" => "OR",
				["<=PROPERTY_PRICE" => 1700, "PROPERTY_MATERIAL" => "Дерево, ткань"],
				["<PROPERTY_PRICE" => 1500, "PROPERTY_MATERIAL" => "Металл, пластик"]
			];
			$this->AbortResultCache();
		}

		$rsProducts = CIBlockElement::GetList(
			[				
				"NAME" => "ASC",
				"SORT" => "ASC"
			],
			$arProductFilter,
			false,
			false,
			["ID", "NAME", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "PROPERTY_PRICE", "IBLOCK_SECTION_ID", "CODE"]
		);
		while($arElement = $rsProducts->GetNext()) {
			++$productQty;
			$arProducts[$arElement["IBLOCK_SECTION_ID"]][] = [
				"ID" => $arElement["ID"],
				"NAME" => $arElement["NAME"],
				"MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
				"ARTNUMBER" => $arElement["PROPERTY_ARTNUMBER_VALUE"],
				"PRICE" => $arElement["PROPERTY_PRICE_VALUE"],
				"DETAIL_URL" => str_replace(
					["#SECTION_ID#", "#ELEMENT_CODE#"], 
					[$arElement["IBLOCK_SECTION_ID"], $arElement["CODE"]], 
					$arParams["TEMPLATE_DETAIL_URL"]
				),
			];
		}

		$rsNews = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"ACTIVE" => "Y",
			],
			false,
			false,
			["ID", "NAME", "ACTIVE_FROM"]
		);
		while($arElement = $rsNews->GetNext()) {
			$arNews[$arElement["ID"]] = $arElement;
		}

		$result = [];
		foreach ($arNews as $news) {
			$item = $news;
			$item["PRODUCTS"] = [];
			foreach($arSections as $arSection) {
				if(in_array($news["ID"], $arSection[$arParams["UF_PROP_CODE"]])) {
					$arProducts[$arSection["ID"]] = is_array($arProducts[$arSection["ID"]]) ? $arProducts[$arSection["ID"]] : [];
					$item["SECTIONS"][$arSection["ID"]] = $arSection["NAME"];
					$item["PRODUCTS"] = array_merge($item["PRODUCTS"], $arProducts[$arSection["ID"]]);
				}
			}
			$result[] = $item;
		}
		$arResult["ITEMS"] = $result;
		$arResult["PRODUCT_QTY"] = $productQty;

	} else {
		$this->AbortResultCache();
	}
}

$this->includeComponentTemplate();

$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_TITLE", ["#COUNT#" => $arResult["PRODUCT_QTY"]]));

?>