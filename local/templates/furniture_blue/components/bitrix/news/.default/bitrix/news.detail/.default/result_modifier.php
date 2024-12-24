<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(isset($arParams["IBLOCK_CANONICAL_ID"])) {
    $dbRes = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID" => $arParams['IBLOCK_CANONICAL_ID'],
            "PROPERTY_NEWS_ID" => $arResult["ID"]
        ],
        false,
        false,
        ['NAME']
    )->Fetch();

    if($dbRes) {
        $arResult['CANONICAL'] = $dbRes['NAME'];
        $this->__component->SetResultCacheKeys(['CANONICAL']);
    }
}