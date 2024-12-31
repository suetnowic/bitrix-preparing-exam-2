<?

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("DEACTIVATE", "OnBeforeIBlockElementUpdateHandler"));

class DEACTIVATE
{
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
			if($ob["SHOW_COUNTER"] > 2) {
				global $APPLICATION;
	            $APPLICATION->throwException(GetMessage("STATUS", ["#COUNT#" => $ob["SHOW_COUNTER"]]));
	            return false;
			}
		}
		
	}
}