<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<? if(!empty($arResult['ELEMENTS'])):?>
    <ul>
       <?foreach($arResult['ELEMENTS'] as $id => $value): ?>
            <li>[<?=$id?>] - <?=$value['LOGIN']?></li>
            <?if(!empty($value['NEWS'])):?>
                <ul>
                    <?foreach($value['NEWS'] as $arNews): ?>
                        <li>- <?=$arNews['NAME']?> - <?=$arNews['ACTIVE_FROM']?></li>
                    <?endforeach;?>
                </ul>
                <?endif;?>
        <?endforeach; ?>
</ul>
<? endif;
