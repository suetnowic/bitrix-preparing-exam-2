<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

global $USER;
if($USER->IsAuthorized() && $this->StartResultCache(false, $USER->GetID())) {
	if(
		intval($arParams["NEWS_IBLOCK_ID"]) > 0 &&
		!empty($arParams["AUTHOR_PROP_CODE"]) &&
		!empty($arParams["UF_FIELD"])
	) {
		
		$arUsers = [];
		$arUserCurentType = [];
		$currentType = 0;
		$newsQty = 0;
		$rsUsers = CUser::GetList(
			"",
			"",
			[],
			[
				"SELECT" => [$arParams["UF_FIELD"]],
				"FIELDS" => ["ID", "LOGIN"]
			]
		);	
		while($arUser = $rsUsers->GetNext()) {
			if((int)$USER->GetID() === (int)$arUser["ID"]) {
				$currentType = (int)$arUser[$arParams["UF_FIELD"]];
			}
			$arUsers[$arUser[$arParams["UF_FIELD"]]][$arUser["ID"]] = $arUser;
		}

		$arUserCurentType = $arUsers[$currentType];

		$arAuthors = [];
		foreach ($arUserCurentType as $arAuthor) {
			$arAuthors[$arAuthor["ID"]] = $arAuthor["LOGIN"];
		}

		$rsNews = CIBlockElement::GetList(
			[],
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"PROPERTY_" . $arParams["AUTHOR_PROP_CODE"] => array_column($arUserCurentType, "ID"),
				"ACTIVE" => "Y"
			],
			false,
			false,
			[]
		);
		$arNews = [];
		while($obNews = $rsNews->GetNextElement()) {
			$arProps = $obNews->getProperties();
			$arFields = $obNews->getFields();

			if(!in_array($USER->GetID(), $arProps[$arParams["AUTHOR_PROP_CODE"]]["VALUE"])) {
				++$newsQty;
				foreach($arProps[$arParams["AUTHOR_PROP_CODE"]]["VALUE"] as $author) {
					if(array_key_exists($author, $arUserCurentType)) {
 						$arNews[$author]["ID"] = $author;
 						$arNews[$author]["LOGIN"] = $arAuthors[$author];
						$arNews[$author]["NEWS"][] = [
							"ID" => $arFields["ID"],
							"NAME" => $arFields["NAME"],
							"ACTIVE_FROM" => $arFields["ACTIVE_FROM"]
						];
					}
				}
			}
		}
		$arResult["NEWS_QTY"] = $newsQty;
		$arResult["ITEMS"] = $arNews;
	} else {
		$this->AbortResultCache();
	}
}
$this->includeComponentTemplate();	

$APPLICATION->SetTitle(GetMessage("CATALOG_TITLE", ["#COUNT#" => $arResult["NEWS_QTY"]]));
?>