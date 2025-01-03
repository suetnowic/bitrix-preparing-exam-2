<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc; 

Loc::loadLanguageFile(__FILE__);

$APPLICATION->AddViewContent("min_max_price", Loc::getMessage("MIN_MAX_PRICE", ["#MIN#" => $arResult["PRICE"]["MIN"], "#MAX#" => $arResult["PRICE"]["MAX"]]));