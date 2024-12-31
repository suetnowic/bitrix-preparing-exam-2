<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler("main", "OnBuildGlobalMenu", [ChangeGlobalMenu::class, "change"]);

class ChangeGlobalMenu
{

	const GROUP_CONTENT_MANAGER = "content_editor";
	const GLOBAL_CONTENT_MENU = "global_menu_content";
	const MENU_ITEMS_NEWS = "menu_iblock_/news";
	const SUB_NEWS_MENU_ITEM = "menu_iblock_/news/1";

	public static function change(&$aGlobalMenu, &$aModuleMenu)
	{
		global $USER;
		$groupId = self::getContentEditorGroupId();

		if ($USER->IsAdmin() || $groupId == 0) {
			return;
		}
		
		foreach ($aGlobalMenu as $key => $arMenu) {
			if($key !== self::GLOBAL_CONTENT_MENU) {
				unset($aGlobalMenu[$key]);
			}
		}

		foreach ($aModuleMenu as $key => $arMenu) {
			if($arMenu["items_id"] !== self::MENU_ITEMS_NEWS) {
				unset($aModuleMenu[$key]);
			}
 		}
 		
 		foreach($aModuleMenu as $key => &$childMenu) {
 			foreach($childMenu["items"] as $key => $subChildMenu) {
 				if($subChildMenu["items_id"] !== self::SUB_NEWS_MENU_ITEM) {
 					unset($childMenu["items"][$key]);
 				}
 			}
 		}
	}

	public static function getContentEditorGroupId()
	{
		$group = CGroup::GetList(
			"",
			"",
			["STRING_ID" => self::GROUP_CONTENT_MANAGER]
		)->Fetch();
		return $group ? $group["ID"] : 0;
	}

}