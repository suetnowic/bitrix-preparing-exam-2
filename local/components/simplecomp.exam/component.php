<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use	Bitrix\Iblock;
use Bitrix\Main\Localization\Loc;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if($this->StartResultCache()) {

	if(intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0 && intval($arParams["NEWS_IBLOCK_ID"]) > 0)
	{
		$arProducts = [];
		$arNews = [];
		$arSections = [];
		$productQty = 0;
		$productPrice = [];

		$rsElements = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"IBLOCK_SECTION_ID",
				"PROPERTY_PRICE",
				"PROPERTY_ARTNUMBER",
				"PROPERTY_MATERIAL"
			]
		);
		while ($element = $rsElements->GetNext()) {
			++$productQty;
			$arProducts[$element["IBLOCK_SECTION_ID"]][] = [
				"ID" => $element["ID"],
				"NAME" => $element["NAME"],
				"ARTNUMBER" => $element["PROPERTY_ARTNUMBER_VALUE"],
				"MATERIAL" => $element["PROPERTY_MATERIAL_VALUE"],
				"PRICE" => $element["PROPERTY_PRICE_VALUE"],
			];
			$productPrice[] = $element["PROPERTY_PRICE_VALUE"];
		}

		$rsElements = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			],
			false,
			false,
			[
				"ID",
				"NAME",
				"ACTIVE_FROM"
			]
		);
		while ($element = $rsElements->GetNext()) {
			$arNews[] = [
				"ID" => $element["ID"],
				"NAME" => $element["NAME"],
				"ACTIVE_FROM" => $element["ACTIVE_FROM"]
			];
		}

		$rsSections = CIBlockSection::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			],
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				$arParams["USER_FIELD"]
			], 
			false
		);
		while($section = $rsSections->GetNext()) {
			$arSections[] = $section;
		}

		$result = [];
		foreach($arNews as $news) {
			$item = $news;
			$item['PRODUCTS'] = [];
			foreach($arSections as $section) {
				if(in_array($news['ID'], $section[$arParams['USER_FIELD']])) {
					$item['SECTIONS'][$section['ID']] = $section['NAME'];
					$item['PRODUCTS'] = array_merge($item['PRODUCTS'], $arProducts[$section['ID']]);
				}
			}
			$result[] = $item;
			
		}
		sort(array: $productPrice);
		$arResult['ITEMS'] = $result;
		$arResult['COUNT'] = $productQty;
		$arResult['MIN_MAX_COST'] = [
			"MIN" => $productPrice[0],
			"MAX" => $productPrice[count($productPrice) - 1]
		];
		
		$this->SetResultCacheKeys(['COUNT', 'MIN_MAX_COST']);
	}
} else {
	$this->AbortResultCache();
}
$this->includeComponentTemplate();

$APPLICATION->SetTitle(Loc::getMessage("SIMPLECOMP_EXAM2_COUNT_TITLE", ["#COUNT#" => $arResult['COUNT']]));

?>