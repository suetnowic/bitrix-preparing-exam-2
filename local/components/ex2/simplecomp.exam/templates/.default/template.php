<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<pre>
<ul>
<?
foreach($arResult['ELEMENTS'] as $id => $value): ?>
    <li>[<?=$id?>] - <?=$value['LOGIN']?>
        <ul>
            <?foreach($value['NEWS'] as $news): ?>
                <li>- <?=$news?></li>
            <?endforeach;?>
        </ul>
    </li>
<?endforeach; ?>
</ul>

