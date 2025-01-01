<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<p>---</p>

<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<ul>
	
	<? foreach ($arResult["ITEMS"] as $item): ?>
		<li><b><?=$item["NAME"]?></b>
			<ul>
				<?foreach ($item["PRODUCTS"] as $product): ?>
					<li>
						<?=$product["NAME"]?> - 
						<?=$product["PRICE"]?> - 
						<?=$product["MATERIAL"]?> - 
						<?=$product["ARTNUMBER"]?> - 
						<a href="<?=$product["DETAIL"]?>"><?=$product["DETAIL"]?></a></li>
				
				<?endforeach?>
			</ul>
		</li>
	<?endforeach?>
</ul>