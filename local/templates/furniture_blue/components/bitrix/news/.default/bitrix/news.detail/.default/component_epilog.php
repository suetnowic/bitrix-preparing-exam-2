<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

var_dump($arResult["CANONICAL"]);

if(isset($arResult["CANONICAL"])) {
    $APPLICATION->SetPageProperty('canonical', $arResult['CANONICAL']);
}