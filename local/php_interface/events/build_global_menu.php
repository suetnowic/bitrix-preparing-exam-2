<?

use Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('main', 'OnBuildGlobalMenu', [ChangeGlobalMenu::class, 'change']);

class ChangeGlobalMenu
{

    const CONTENT_EDITOR_GROUP_CODE = "content_editor";
    const CONTENT_MENU_ID = "global_menu_content";
    const MENU_ITEMS_ID = "menu_iblock_/news";

    public static function change(&$aGlobalMenu, &$aModuleMenu)
    {
        global $USER;
        $arGroups = $USER->GetUserGroupArray();
        if($USER->IsAdmin() || !in_array(self::getUserGroup(), $arGroups)) {
            return;
        }
        
        foreach($aGlobalMenu as $key => $item) {
            if($key !== self::CONTENT_MENU_ID) {
                unset($aGlobalMenu[$key]);
            }
        }
         
        foreach($aModuleMenu as $key => $menu) {
            if($menu['items_id'] !== self::MENU_ITEMS_ID) {
                unset($aModuleMenu[$key]);
            }
        }
    }

    private static function getUserGroup(): string
    {
        return CGroup::GetList('by', 'asc', ['STRING_ID' => self::CONTENT_EDITOR_GROUP_CODE])->Fetch()["ID"];
    }
}