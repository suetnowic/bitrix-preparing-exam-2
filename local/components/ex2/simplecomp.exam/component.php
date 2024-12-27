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
if ($USER->IsAuthorized() && $this->startResultCache(false, $USER->GetID())) {
	if (
		intval($arParams["NEWS_IBLOCK_ID"]) > 0 &&
		!empty($arParams['USER_UF_CODE']) &&
		!empty($arParams['PROPERTY_AUTHOR'])
	) {

		$rsUser = CUser::GetList(
			'',
			'',
			[],
			[
				'SELECT' => [
					$arParams['USER_UF_CODE']
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
			if ((int)$USER->GetID() === (int)$arUser['ID']) {
				$currentUserType = (int)$arUser[$arParams['USER_UF_CODE']];
			}
			if ($currentUserType === (int)$arUser[$arParams['USER_UF_CODE']]) {
				$arUsersType[$arUser['ID']] = $arUser;
				$arUsers[$arUser['ID']] = $arUser['LOGIN'];
			}
		}

		$arNews = [];
		$rsElements = CIBlockElement::GetList(
			[
				"NAME" => "ASC"
			],
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				$arParams['PROPERTY_AUTHOR'] => array_column($arUsersType, 'ID'),
				"ACTIVE" => "Y"
			], 
			false, 
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				$arParams['PROPERTY_AUTHOR'],
				"ACTIVE_FROM"
			]
		);
		while ($arElement = $rsElements->GetNextElement()) {
			if(!in_array($USER->GetID(), $arElement->getProperties()['AUTHOR']['VALUE'])) {
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
	}
}

$this->includeComponentTemplate();

$APPLICATION->SetTitle(GetMessage("COUNT_NEWS", ['#COUNT#' => $arResult['ELEMENTS_COUNT']]));
