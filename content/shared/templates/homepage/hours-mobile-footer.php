<div id="mobileHours" style="display:none;">
    <div id="dealerHours">
        <?= do_shortcode('[dealer_info full_day_string=true show_phones=false show_heading=false departments="" ]'); ?>
    </div>
    <div id="dealerInfo">
        <p>
            <a trid="a437e9a4aa384773b502c1" trc target="_blank" href="<?php echo get_option('di_google_map'); ?>">
                <?= get_option('di_street_address'); ?><br />
                <?= get_option('di_city'); ?>, <?= get_option('di_state'); ?> <?= get_option('di_zipcode'); ?>
            </a><br />
            
            Sales: <?= do_shortcode('[di_phone option_key="sales" clickable="true"]'); ?><br />
            Service: <?= do_shortcode('[di_phone option_key="service" clickable="true"]'); ?>
        </p>
    </div>
</div>