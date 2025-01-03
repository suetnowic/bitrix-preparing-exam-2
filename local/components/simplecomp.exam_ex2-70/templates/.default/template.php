<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$url = $APPLICATION->GetCurPage() . "?F=Y"; ?>
<?=GetMessage("FILTER_TITLE") . "<a href='" . $url . "'>" . $url . "</a>"?>
<br>
<?=GetMessage("TIMESTAMP");?><?=time();?>

<p>---</p>

<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<?
$this->AddEditAction("news-add", $arResult["ADD_NEWS"]["LINK"], CIBlock::GetArrayByID($arResult["ADD_NEWS"]["IBLOCK_ID"], "ELEMENT_ADD"));
?>
<ul id="<?=$this->GetEditAreaId("news-add")?>">
	<? foreach ($arResult["ITEMS"] as $item): ?>
		<?
		$this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<li id="<?=$this->GetEditAreaId($item['ID'])?>">
			<? $item["SECTIONS"] = is_array($item["SECTIONS"]) ? $item["SECTIONS"] : []; ?>
			<b><?=$item["NAME"]?></b> - <?=$item["ACTIVE_FROM"]?> (<?=implode(', ', $item["SECTIONS"])?>)

			<?
			$this->AddEditAction("product-add", $arResult["ADD_PRODUCT"]["LINK"], CIBlock::GetArrayByID($arResult["ADD_PRODUCT"]["IBLOCK_ID"], "ELEMENT_ADD"));
			?>
			<ul id="<?=$this->GetEditAreaId("product-add")?>">
				<?foreach ($item["PRODUCTS"] as $product): ?>
					<?
					$this->AddEditAction($product['ID'], $product['EDIT_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($product['ID'], $product['DELETE_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<li id="<?=$this->GetEditAreaId($product['ID'])?>">
						<?=$product["NAME"]?> - 
						<?=$product["PRICE"]?> - 
						<?=$product["MATERIAL"]?> - 
						<?=$product["ARTNUMBER"]?> 
						(<?=$product["DETAIL_URL"]?>.php)
						</li>	
				<? endforeach ?>
			</ul>
		</li>
	
	<? endforeach ?>
</ul>

<br>

<p>
	<b>
		<?=GetMessage("NAVIGATION")?>
	</b>
	<br>
		<?=$arResult["NAV_STRING"]?>
</p>