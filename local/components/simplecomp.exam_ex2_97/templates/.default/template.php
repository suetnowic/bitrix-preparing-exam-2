<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<p>---</p>

<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<ul>
	<? foreach ($arResult["ITEMS"] as $item): ?>
		<li>
			[<?=$item["ID"]?>] - <?=$item["LOGIN"]?>
			<ul>
				<? foreach($item["NEWS"] as $news): ?>
				<li>
					- <?=$news["NAME"]?> - <?=$news["ACTIVE_FROM"]?>
				</li>
				<? endforeach ?>
			</ul>
		</li>
	<? endforeach ?>
</ul>
