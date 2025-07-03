<div id="search-overlay" class="visible-xs">
    <div class="overlay-container">
		<span class="close-overlay">
        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close button" />
		</span>
        <div class="overlay-content"></div>
        <div class="search-section" style="display:none">
            <?php get_scoped_template_part('partials/search/anything', '', isset($anything)?$anything:array()); ?>
        </div>
    </div>
</div>

<?php get_shared_template('homepage/button-overlay'); ?>


<div id="header" class="visible-header">
    <div class="header-top hidden-sm hidden-xs">
        <div class="dealer-phone">
            <span class="phone">Sales: <span id="phonenumber_sales"><?php echo do_shortcode('[di_phone option_key="sales" format="withparens" clickable="true"]'); ?></span></span> <span class="header-btw-phones"> | </span>
            <span class="phone">Service: <span id="phonenumber_service"><?php echo do_shortcode('[di_phone option_key="service" format="withparens" clickable="true"]'); ?></span> </span>
        </div>
        <div class="dealer-hours-container">
            <div class="dealer-hours">
                <span class="sales-hours">Sales: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span>
                <span class="service-hours">Service: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span>
            </div>
            <div class="hours-dropdown">
                <div id="saleshours">
                    <?php
                    echo do_shortcode('[dealer_info show_phones="false" show_heading="false" departments="Sales" full_day_string="true" ]');
                    ?>
                </div>
                <div id="servicehours">

                    <?php
                    // Testing for Service or Service & Parts
                    $hourscheck = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Monday');
                    $hoursheading = "Service & Parts";
                    if(empty($hourscheck)) {
                        $hourscheck = DIHoursShortcode::get_day_specific_hours('Service', 'Monday');
                        $hoursheading = "Service";
                    }
                    ?>
                    <?php
                    echo do_shortcode('[dealer_info show_phones="false" show_heading="false" departments="'.$hoursheading.'" full_day_string="true" ]');
                     ?>
                </div>
            </div>
        </div>
        <div class="dealer-address">
            <?php do_action('before_fj_header_v2_address'); ?>
                <a trid="790354c61f754846befab4" trc target="_blank" itemprop="directions" href="<?php echo get_option('di_google_map'); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo get_option('di_street_address'); ?> • <?php echo get_option('di_city'); ?>, <?php echo get_option('di_state'); ?> <?php echo get_option('di_zipcode'); ?></a>
            <?php do_action('after_fj_header_v2_address'); ?>
        </div>
        <div class="header__language-toggle">
            <?php get_scoped_template_part('partials/translate/google', 'translate', array('languages' => 'ar,zh-CN,zh-TW,ru,es,vi')); ?>
        </div>
    </div>
    <div class="header-bottom">
        <div class="header-left">
            <?php 
                $nav_image = get_field('header_nav_image', 'option');
                $nav_image_link = get_field('header_nav_image_link', 'option');
                if( $nav_image ): ?>
                <div class="header-ad-image hidden-xs">
                    <a trid="567bb14b47f54c0b9b9461" trc href="<?php echo $nav_image_link; ?>" >
                        <img src="<?php echo $nav_image['url']; ?>" alt="<?php echo $nav_image['alt']; ?>" />
                    </a>
                </div>
            <?php endif; ?>
            <a trid="e5e1e9b778eb4c2bb4eb5f" trc id="mobile-menu-toggle" class="menu-hamburger" data-side="left" data-container="mobile-menu" data-gtm-event="mobileHeaderHamburger">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="header-mid">
                <a trid="4a97fd36e9184d47844a2c" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo" class="fj-navbar-brand">
                    <span class="text-logo logo" itemscope itemtype="http://schema.org/Organization">
                    <?php
                    $imageOverride = get_field('vessel_main_logo', 'option');
                    if ( !empty($imageOverride) ): ?>
                    <div class="vessel-main-logo">
                        <img src="<?php echo $imageOverride['url']; ?>" alt="<?php echo $imageOverride['alt']; ?>">
                    </div>
                    <?php else: ?>
                        <img itemprop="logo" src="<?php echo '/wp-content/plugins/vessel/content/dealers/' . get_option('di_slug') . '/images/logo-head.png'  ?>" alt="<?php echo get_bloginfo('title'); ?>">
                    <?php endif; ?>
                    <?php if (get_field('vessel_header_image', 'option') && get_field('vessel_header_image_link', 'option')): ?>
                        <a trid="02ccb29836414020abfe69" trc href="<?php echo get_field('vessel_header_image_link', 'option'); ?>">
                            <img id="vessel-header-img" src="<?= get_field('vessel_header_image', 'option'); ?>" alt="Custom Header Image">
                        </a>
                    <?php elseif (get_field('vessel_header_image', 'option')): ?>
                        <img id="vessel-header-img" src="<?= get_field('vessel_header_image', 'option'); ?>" alt="Custom Header Image">
                    <?php endif; ?>
                    </span>
                </a>
            <?php if(get_field( 'rotating-logos', $pg ) == 'Yes') : ?>
                <ul id="menu-top-menu" class="nav logo-swap hidden-xs">
                    <li class="menu-item rotating-logos" id="rotating-logos">
                        <div class="menu-item-img">
                            <?php if(get_field( 'amg-logo-header', $pg ) == true) : ?>
                                <a trid="0a3f3a3c220d44b8821e7f" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg.png" alt="Amg Logo" class="loading"></a>
                            <?php endif; ?>
                            <?php if(get_field( 'sprinter-logo-header', $pg ) == true) : ?>
                                <a trid="a5e722db59e042a98ea233" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter.png" alt="Sprinter Logo" class="loading"></a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            <?php endif ; ?>

            <?php do_action( 'before_mobile_menu_icons', get_the_ID() ); ?>
        </div>
        <div class="header-right">
            <a trid="c7ec0978c0894632bb578a" trc class="store-locator" target="_blank" href="<?php echo get_option('di_google_map'); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
            <div class="header-search hidden-xs">
                <div class="search-toggle">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
                <div class="search-bar" data-testid="search-menu">
                    <span id="close-search"><i class="fa fa-close"></i></span>
                    <?php get_scoped_template_part('partials/search/anything', '', array('button_text'=>'Search', 'search_placeholder'=>'Search Anything...')); ?>
                </div>
            </div>
            <a trid="87e58dcf5a174124bdfa49" trc id="search" class="overlay-toggle visible-xs" data-toggle-target="#algolia-overlay" data-gtm="desktop.homepage.btn.buy">
                <i class="fa fa-search"></i>
            </a>
            <a trid="2d8cd0a20a824b1884392d" trc id="contact-us" class="di-modal" href="#ab-modal--contactUs">
                <i class="fa fa-phone"></i>
            </a>
        </div>
    </div>
    <div id="mobile-menu" class="mobile-nav-menu sidebar-navigation-enabled" style="display: none;">
        <div class="navbar">
            <div class="navbar-inner">
                <?php
                $nav_menu_settings = array(
                    'theme_location'  => isset($theme_location) ? $theme_location : 'mobile-menu',
                    'container'       => 'div',
                    'container_class' => 'collapse navbar-collapse',
                    'container_id'    => 'collapse-1',
                    'menu_class'      => isset($menu_class) ? $menu_class : 'nav',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'depth'           => isset($depth) ? $depth : 3,
                    'walker'		  => isset($walker) ? $walker : new wp_bootstrap_navwalker(),
                );
                ?>
                <div class="nav_section">
                    <?php DIFunctions::nav_menu( $nav_menu_settings, 'mobile' ); ?>
                </div>
                <?php do_action('after_mobile_menu'); ?>
                <?php apply_filters('after_offcanvas_mobile_nav', ''); ?>
            </div>
        </div>
    </div>
    <div class="visible-sm visible-xs">
        <?php get_template_part('partials/homepage/mobile/open-hours'); ?>
    </div>
</div>
<div class="fixed-top-spacer"></div>