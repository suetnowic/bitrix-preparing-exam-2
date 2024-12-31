<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(isset($arParams["CANONICAL"])) {

	$elementId = $arResult['ID'];
	$newsIblockId = $arParams['IBLOCK_ID'];
	$canonicalIblockId = $arParams['CANONICAL'];

	$res = CIBlockElement::GetList(
		[],
		[
			"IBLOCK_ID" => $canonicalIblockId, 
			"ACTIVE" => "Y",
			"PROPERTY_NEWS" => $elementId
		],
		false,
		false,
		["NAME"]
	)->Fetch();
	if($res){
		$arResult["CANONICAL"] = $res['NAME'];
		$this->__component->SetResultCacheKeys(["CANONICAL"]);
	}
}

