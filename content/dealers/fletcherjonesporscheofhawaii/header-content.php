<?php

$phone_department = 'Sales,Service'; ?>

<header id="header" class="menu-top hidden-xs hidden-sm">
    <div class="header-top">
        <div class="dealer-hours">
            <?php echo do_shortcode('[di_display_open_hours departments="' . $hours_department . '"]'); ?>
        </div>

        <div class="dealer-address">
            <a trid="a32fc87a51334d1da58358" trc target="_blank" itemprop="directions" href="<?php echo get_option(
              'di_google_map',
            ); ?>" data-gtm-event="desktopHeaderMapLink">
                <?php echo get_option('di_street_address'); ?> &bull; <?php echo get_option(
   'di_city',
 ); ?>, <?php echo get_option('di_state'); ?> <?php echo get_option('di_zipcode'); ?>
            </a>
        </div>

        <?php do_action('header_after_address'); ?>

        <div class="dealer-phone">
            <?php if ($phone_department !== false) {
              $phone_department = explode(',', $phone_department);

              foreach ($phone_department as $phone) { ?>
                    <span class="phone"><?php echo $phone; ?>: <?php echo do_shortcode(
  '[di_phone option_key="' . $phone . '"]',
); ?> </span>
                    <?php }
            } ?>
        </div>

        <?php do_action('header_before_glovebox'); ?>

        <?php do_action('porsche_top_item'); ?>

        <div class="header-glovebox">
            <a trid="79b6286468ce40ff823620" trc href="/glovebox/"><i class="fa fa-heart-o" aria-hidden="true"></i> My Glovebox</a>
        </div>
    </div>

    <div id="header-bottom">
        <div class="header-wrapper">
            <div class="header-bottom-wrap">
                <div class="header-bottom-top">
                    <div class="dealer-name">
                        <a trid="e2c37006628c4a82a1e3f6" trc href="<?php echo home_url(); ?>">%%di_name%%</a>
                    </div>
                    <?php do_action('header_left_oem_logo'); ?>
                    <div class="logo-wrap">
                        <a trid="79d35637fbd24d39b4b7ae" trc href="/">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="Porsche" class="lazyload-loading">
                        </a>
                        <?php if (get_field('vessel_header_image', 'option')): ?>
                            <img id="vessel-header-img" src="<?= get_field(
                              'vessel_header_image',
                              'option',
                            ) ?>" alt="Custom Header Image">
                        <?php endif; ?>
                    </div>
                    <?php do_action('header_right_oem_logo'); ?>
                    <div id="search-wrap">
                        <?php get_scoped_template_part(
                          'partials/search/anything',
                          '',
                          isset($anything) ? $anything : [],
                        ); ?>
                    </div>
                </div>
                <div class="header-bottom-bottom">
                    <div class="navbar">
                        <div class="navbar-inner hidden-sm hidden-xs">
                            <div class="navbar">
                                <div class="navbar-inner">
                                    <?php $defaults = [
                                      'theme_location' => 'main-menu',
                                      'container' => false,
                                      'menu_class' => 'nav',
                                      'echo' => true,
                                      'fallback_cb' => 'wp_page_menu',
                                      'depth' => 3,
                                      'walker' => '',
                                    ]; ?>
                                    <div class="nav_section">
                                        <?php wp_nav_menu($defaults); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a trid="363218a15f0e4933bd177e" trc id="mobile-menu-toggle" class="menu-hamburger visible-sm visible-xs" data-side="right" data-container="mobile-menu" data-gtm-event="mobileHeaderHamburger">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-label">MENU</span>
            </a>
        </div>
    </div>

    <?php
    $chat_code = apply_filters('livechat', '', '<span>Live Chat</span>', 'chat button small');
    if ($chat_code):
      echo $chat_code;
    endif;
    ?>
</header>

<?php get_scoped_template_part('partials/translate/google', 'translate', [
  'mobile' => 'true',
]); ?>

<div class="fixed-top-spacer hidden-sm hidden-xs"></div>


<div class="visible-sm">
    <?php get_shared_mobile_template('header-tabletbasic'); ?>
</div>

<div class="visible-xs">
    <?php get_shared_mobile_template('header-mobilebasic'); ?>
</div>

<div class="visible-sm visible-xs">
      <?php get_scoped_template_part('partials/navigations/offcanvas', 'nav', ['theme_location' => 'main-menu']); ?>
</div>
