<?

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementUpdate", [Deactivate::class, "OnBeforeIBlockElementUpdateHandler"]);

class Deactivate
{

	const MIN_SHOW_COUNT = 2;

	public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
	{
		CModule::IncludeModule("iblock");

		$res = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arFields["IBLOCK_ID"],
				"ID" => $arFields["ID"],
			],
			false,
			false,
			["SHOW_COUNTER"]
		);
		while ($ob = $res->GetNext()) {
			if($ob["SHOW_COUNTER"] > self::MIN_SHOW_COUNT) {
				global $APPLICATION;
	            $APPLICATION->throwException(GetMessage("STATUS", ["#COUNT#" => $ob["SHOW_COUNTER"]]));
	            return false;
			}
		}
		
	}
}