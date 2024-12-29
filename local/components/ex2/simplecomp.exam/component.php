<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

// Отображаются только те авторы, у которых тот же «тип» что и у текущего пользователя
// Новости, в которых в авторстве присутствует текущий пользователь, не выводятся у других авторов.
// Неавторизованному пользователю данные не выводятся
// Текущий пользователь и его новости – не выводятся
global $USER;
$currentUserId = $USER->GetID();
if ($USER->IsAuthorized() && $this->StartResultCache(false, $currentUserId)) {
	if (
		intval($arParams["NEWS_IBLOCK_ID"]) > 0 &&
		!empty($arParams['UF_CODE']) &&
		!empty($arParams['AUTHOR'])
	) {

		$rsUser = CUser::GetList(
			'',
			'',
			[],
			[
				'SELECT' => [
					$arParams['UF_CODE']
				],
				'FIELDS' => [
					'ID',
					'LOGIN'
				]
			]
		);

		$currentUserType = 0;
		$arUsersType = [];
		$arUsers = [];
		while ($arUser = $rsUser->GetNext()) {
			if ((int)$currentUserId === (int)$arUser['ID']) {
				$currentUserType = (int)$arUser[$arParams['UF_CODE']];
			}
			$arUsers[] = $arUser;
		}

		foreach ($arUsers as $arUser) {
			if ($currentUserType === (int)$arUser[$arParams['UF_CODE']]) {
				$arUsersType[$arUser['ID']] = $arUser;
			}
		}

		$arNews = [];
		$rsElements = CIBlockElement::GetList(
			[
				"NAME" => "ASC"
			],
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"PROPERTY_".$arParams['AUTHOR'] => array_column($arUsersType, 'ID'),
				"ACTIVE" => "Y"
			], 
			false, 
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				"PROPERTY_".$arParams['AUTHOR'],
				"ACTIVE_FROM"
			]
		);
		while ($arElement = $rsElements->GetNextElement()) {

			$arProps = $arElement->getProperties();
			if(
				isset($arProps[$arParams['AUTHOR']]['VALUE']) && 
				!in_array($currentUserId, $arProps[$arParams['AUTHOR']]['VALUE'])
			) {
				$arNews[] = $arElement->GetFields();
			}
		}

		$arNewsName = [];
		$arResult['ELEMENTS'] = [];
		foreach($arNews as $news) {
			$arResult['ELEMENTS'][$news['PROPERTY_AUTHOR_VALUE']]['LOGIN'] = $arUsers[$news['PROPERTY_AUTHOR_VALUE']];
			$arResult['ELEMENTS'][$news['PROPERTY_AUTHOR_VALUE']]['NEWS'][] = $news;
			$arNewsName[] = $news['ID'];
		}
		$arResult['ELEMENTS_COUNT'] = count(array_unique($arNewsName));
	} else {
		$this->AbortResultCache();
	}
} 

$this->includeComponentTemplate();

$APPLICATION->SetTitle(GetMessage("COUNT_NEWS", ['#COUNT#' => $arResult['ELEMENTS_COUNT']]));
