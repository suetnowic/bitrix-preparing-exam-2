<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler("main", "OnBeforeProlog", [SeoTags::class, "change"]);

class SeoTags
{

	const IBLOCK_CODE = "METATEGS";

	public static function change()
	{

		CModule::IncludeModule("iblock");
		global $APPLICATION;

		$dbRes = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_CODE" => self::IBLOCK_CODE,
				"=NAME" => $APPLICATION->GetCurPage(),
			],
			false,
			false,
			["ID", "PROPERTY_TITLE", "PROPERTY_DESCRIPTION"]
		);
		while ($ob = $dbRes->GetNext()) {
			$APPLICATION->SetPageProperty("title", $ob["PROPERTY_TITLE_VALUE"]);
			$APPLICATION->SetPageProperty("description", $ob["PROPERTY_DESCRIPTION_VALUE"]);
		}

	}
}