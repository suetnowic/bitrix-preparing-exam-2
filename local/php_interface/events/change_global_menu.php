<?

use \Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('main', 'OnBuildGlobalMenu', [ChangeGlobalMenu::class, 'change']);

class ChangeGlobalMenu
{

    const CONTENT_MANAGER_CODE = "content_editor";
    const GLOBAL_MENU_CONTENT = "global_menu_content";
    const MENU_ITEM_ID = "menu_iblock_/news";

    public static function change(&$arGlobalMenu, &$arModuleMenu)
    {
        global $USER;
        $groupId = self::getContentEditorGroupId();
        if ($USER->IsAdmin() || $groupId == 0) {
            return;
        }

        foreach ($arGlobalMenu as $key => $arMenu) {
            if ($key !== self::GLOBAL_MENU_CONTENT) {
                unset($arGlobalMenu[$key]);
            }
        }

        foreach ($arModuleMenu as $key => $menuItem) {
            if ($menuItem['items_id'] !== self::MENU_ITEM_ID) {
                unset($arModuleMenu[$key]);
            }
        }
    }

    private static function getContentEditorGroupId(): int
    {
        $group = CGroup::GetList(
            '',
            '',
            ['STRING_ID' => self::CONTENT_MANAGER_CODE]
        )->Fetch();

        return $group ? (int)$group['ID'] : 0;
    }
}
