<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$url = $APPLICATION->GetCurPage() . "?F=Y"; ?>
<?=GetMessage("FILTER_TITLE") . "<a href='" . $url . "'>" . $url . "</a>"?>
<p>---</p>

<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<ul>
	<? foreach ($arResult["ITEMS"] as $item): ?>
		<li>
			<? $item["SECTIONS"] = is_array($item["SECTIONS"]) ? $item["SECTIONS"] : []; ?>
			<b><?=$item["NAME"]?></b> - <?=$item["ACTIVE_FROM"]?> (<?=implode(', ', $item["SECTIONS"])?>)
			<ul>
				<?foreach ($item["PRODUCTS"] as $product): ?>
					<li>
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