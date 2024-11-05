<?

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler('main', 'onBeforeEventAdd', [ChangeFeedback::class, 'change']);

class ChangeFeedback
{
    public static function change(&$event, &$lid, &$arFields): void
    {
        global $USER;
        if($event == "FEEDBACK_FORM") {
            if($USER->IsAuthorized()) {
                $arFields['AUTHOR'] = Loc::getMessage(
                    'USER_AUTH',
                    [
                        '#ID#' => $USER->GetID(),
                        '#LOGIN#' => $USER->GetLogin(),
                        '#NAME#' => $USER->GetFullName(),
                        '#USERNAME#' => $arFields['AUTHOR']
                    ]
                    );
            } else {
                $arFields['AUTHOR'] = Loc::getMessage(
                    'USER_NOT_AUTH',
                    [
                        '#USERNAME#' => $arFields['AUTHOR']
                    ]
                );
            }
            CEventLog::Add(array(
                "SEVERITY" => "SECURITY",
                "AUDIT_TYPE_ID" => Loc::getMessage('AUDIT_TYPE_ID'),
                "MODULE_ID" => "main",
                "DESCRIPTION" => Loc::getMessage('CHANGE_DESCR', ['#AUTHOR#' => $arFields['AUTHOR']]),
             ));
       
        }
        
    }
}