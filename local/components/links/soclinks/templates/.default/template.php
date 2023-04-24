<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
      
<?php if (empty($arResult)) return; ?>  

<!-- <? //echo "<pre>".print_r($arResult, 1)."</pre>"; ?> -->

<ul class="link_block">
	<?foreach($arResult as $linkItem):?>
	<li class="link_item">
		<a
			target="_blank"
			href="<?=($linkItem["LINK"]);?>"
		><img src="<?=($linkItem["SRC"]);?>"></img></a>
	</li>
	<?endforeach?>
</ul>