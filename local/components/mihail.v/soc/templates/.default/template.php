<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
?>

<div class="soc">
	<? if ($arResult['YOUTUBE_CHECK'] == 'Y' && !empty($arResult['YOUTUBE_LINK'])) : ?>
		<div class="soc__item">
			<a href="<?= $arResult['YOUTUBE_LINK'] ?>" class="soc__link" target="_blank"><img src="/local/components/mihail.v/soc/images/you.svg" alt="icon" class="soc__icon"></a>
		</div>
	<? endif; ?>

	<? if ($arResult['VKONTAKTE_CHECK'] == 'Y' && !empty($arResult['VKONTAKTE_LINK'])) : ?>
		<div class="soc__item">
			<a href="<?= $arResult['VKONTAKTE_LINK'] ?>" class="soc__link" target="_blank"><img src="/local/components/mihail.v/soc/images/vk.svg" alt="icon" class="soc__icon"></a>
		</div>
	<? endif; ?>

	<? if ($arResult['VIBER_CHECK'] == 'Y' && !empty($arResult['VIBER_LINK'])) : ?>
		<div class="soc__item">
			<a href="viber://chat?number=+<?= $arResult['VIBER_LINK'] ?>" class="soc__link" target="_blank"><img src="/local/components/mihail.v/soc/images/viber.svg" alt="icon" class="soc__icon"></a>
		</div>
	<? endif; ?>

	<? if ($arResult['WA_CHECK'] == 'Y' && !empty($arResult['WA_LINK'])) : ?>
		<div class="soc__item">
			<a href="https://wa.me/<?= $arResult['WA_LINK'] ?>" class="soc__link" target="_blank"><img src="/local/components/mihail.v/soc/images/wa.svg" alt="icon" class="soc__icon"></a>
		</div>
	<? endif; ?>

	<? if ($arResult['TG_CHECK'] == 'Y' && !empty($arResult['TG_LINK'])) : ?>
		<div class="soc__item">
			<a href="<?= $arResult['TG_LINK'] ?>" class="soc__link" target="_blank"><img src="/local/components/mihail.v/soc/images/tg.svg" alt="icon" class="soc__icon"></a>
		</div>
	<? endif; ?>

</div>