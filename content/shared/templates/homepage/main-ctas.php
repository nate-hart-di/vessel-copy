<?php
$feature_button_text = get_field('button_text', 'option');
$feature_button_color = get_field('button_color', 'option');
$fj_blue = '#0059a8';
$button_link = get_field('button_link', 'option');
$cta_one_text = get_field('button_text_one');
$cta_two_text = get_field('button_text_two');
$cta_two_link = get_field('button_link_two');
$cta_three_text = get_field('button_text_three');
$cta_three_link = get_field('button_link_three');
$cta_four_text = get_field('button_text_four');
$cta_four_link = get_field('button_link_four');
?>
<div class="cta-buttons">
    <div class="text-center">
        <a trid="90c21fcd964148018e9abf" trc class="button secondary-button overlay-toggle" data-toggle-target="#buy-overlay" data-gtm="desktop.homepage.btn.buy"> <?= $cta_one_text ?> </a>
        <a trid="e008c0dad50746a085effb" trc class="button secondary-button ab-test-trade" href="<?= $cta_two_link ?>" data-gtm="desktop.homepage.btn.sell"><?= $cta_two_text ?></a>
        <a trid="312da85f944e4ceda2fb84" trc class="homepage-feature-button button primary-button <?= (glow()) ? 'button-radioactive' : ''; ?>"
        style="background: <?= (!empty($feature_button_color)) ? $feature_button_color .'!important;' : $fj_blue . '!important;';?>"
        href="<?= $cta_three_link ?>" data-gtm="desktop.homepage.btn.specials"><?= $cta_three_text ?></a>
        <a trid="411cd66dd22041308e2312" trc class="button secondary-button service" href="<?= $cta_four_link?>" data-gtm="desktop.homepage.btn.service"><?= $cta_four_text ?> </a>
    </div>
</div>