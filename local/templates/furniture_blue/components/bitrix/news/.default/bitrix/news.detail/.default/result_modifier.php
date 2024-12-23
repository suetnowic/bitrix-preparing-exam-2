<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arParams["CANONICAL"])) {
    $dbRes = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID" => $arParams["CANONICAL"],
            "PROPERTY_NEWS_ID" => $arResult["ID"],
        ],
        false,
        false,
        ["NAME"]
    )->Fetch();

    if($dbRes) {
        $arResult['CANONICAL'] = $dbRes['NAME'];
        $this->__component->SetResultCacheKeys(['CANONICAL']);
    }
}