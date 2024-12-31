<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler("main", "OnBeforeEventAdd", array(ChangeFeedback::class, "OnBeforeEventAddHandler"));

class ChangeFeedback
{

	const FEEDBACK_FORM_EVENT = "FEEDBACK_FORM";

	public static function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
	{
		global $USER;
		if ($event === self::FEEDBACK_FORM_EVENT) {
			if($USER->IsAuthorized()) {
				$arFields["AUTHOR"] = GetMessage(
					"AUTHORIZED", 
					[
						"#ID#" => $USER->GetID(), 
						"#LOGIN#" => $USER->GetLogin(),
						"#NAME#" => $USER->GetFullName(),
						"#AUTHOR#" => $arFields["AUTHOR"]
					]
				);

			} else {
				$arFields["AUTHOR"] = GetMessage(
					"UNATHORIZED",
					[
						"AUTHOR" => $arFields["AUTHOR"]
					]
				);
			}
			CEventLog::Add([
				"SEVERITY" => "SECURITY",
				"AUDIT_TYPE_ID" => GetMessage("AUDIT_TYPE_ID"),
				"MODULE_ID" => "main",
				"DESCRIPTION" => GetMessage("DESCRIPTION", ["#AUTHOR#" => $arFields["AUTHOR"]]),
			]);
		}
		
	}
}