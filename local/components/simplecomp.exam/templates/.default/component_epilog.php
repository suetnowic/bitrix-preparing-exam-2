<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($APPLICATION->GetViewContent("min_max_cost") === '') {
    $APPLICATION->AddViewContent("min_max_cost", GetMessage("MIN_MAX", ['#MIN#' => $arResult['MIN_MAX_COST']['MIN'], '#MAX#' => $arResult['MIN_MAX_COST']['MAX']]));
}
