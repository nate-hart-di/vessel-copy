<?php
$pg = get_option('page_on_front'); ?>
<div class="visible-sm visible-xs">
     /*
    Basic Mobile Header - Optional Icon Labels
    */<?php


    $link = get_option('di_mobile_header_link');
    $showtitle = get_option('di_show_header_titles', false);
    ?>

    <div class="menu-top <?php echo $showtitle ? ' with-labels' : ''; ?>">
        <div class="mobile-header-top">

            <div class="deviceWrapper__menu menu-hamburger open-overlay-js header-toggle-js" target="fullmenu">
                <span class="active">
                    <?php get_scoped_template_part('includes/svg/icon-menu', '', [
                      'height' => '25px',
                      'width' => '25px',
                    ]); ?>
                </span>
                <span class="icon-label hidden">MENU</span>
            </div>

            <span class="logo" itemscope itemtype="http://schema.org/Organization">
                <a trid="8fbc645c729c4e06a20e3b" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
                    <img itemprop="logo" src="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
                      get_option('di_slug') .
                      '/images/logo-head-mobile.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>">
                </a>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <a trid="74c840ada69843cfa7684f" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
                    <img id="vessel-header-img" data-original="<?= get_field(
                      'vessel_header_image',
                      'option',
                    ) ?>" alt="Custom Header Image">
                    </a>
                <?php endif; ?>
            </span>

            <?php if (get_field('rotating-logos', $pg) == 'Yes'): ?>
                <ul id="menu-top-menu" class="nav logo-swap hidden-xs">
                    <li class="menu-item rotating-logos" id="rotating-logos">
                        <div class="menu-item-img">
                            <?php if (get_field('amg-logo-header', $pg) == true): ?>
                                <a trid="ce8eeaf784d8442e9f20ec" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg.png" alt="Amg Logo" class="loading"></a>
                            <?php endif; ?>
                            <?php if (get_field('sprinter-logo-header', $pg) == true): ?>
                                <a trid="d0aefdbf06bb4edbaa16fe" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter.png" alt="Sprinter Logo" class="loading"></a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>

            <?php do_action('before_mobile_menu_icons', get_the_ID()); ?>

            <div class="icons">
                <span class="menu-address hidden-xs">
                  <a trid="d1e6bca071324c2180473c" trc class="hours-icon" target="_blank" href="<?php echo get_option(
                    'di_google_map',
                  ); ?>">
                    <?php get_scoped_template_part('includes/svg/icon-map-marker', '', [
                      'height' => '24px',
                      'width' => '24px',
                    ]); ?>
                  </a>
                </span>

                <span class="menu-search">
                    <a trid="81905bc095b346ea90581f" trc class="overlay-toogle" data-toggle-target="#algolia-overlay" data-gtm="desktop.homepage.btn.buy">
                        <?php get_scoped_template_part('includes/svg/icon-search', '', [
                          'height' => '24px',
                          'width' => '24px',
                        ]); ?>
                    </a>
                </span>

                <span class="menu-phone">
                    <a trid="cdff0fae0a1243db98b031" trc class="overlay-toogle" data-toggle-target="#contact-overlay" data-gtm-event="mobileHeaderPhone">
                        <?php get_scoped_template_part('includes/svg/icon-phone', '', [
                          'height' => '24px',
                          'width' => '24px',
                        ]); ?>
                    </a>
                </span>

            </div>

            <?php do_action('after_mobile_menu_icons', get_the_ID()); ?>

            <?php
            //kept for backwards compatibility
            ob_start();
            if (DIContactAtOnce::get()->is_enabled() && DIContactAtOnce::get()->is_placement_set('mobile')): ?>
                <span class="mobile-chat" data-gtm-event="mobileHeaderChat">
                <?php DIContactAtOnce::get()->chatbutton(
                  '<img src="' . get_stylesheet_directory_uri() . '/images/mobile-chat.png" alt="Find Us">',
                  '',
                  true,
                ); ?>
            </span>
            <?php endif;
            $mobile_chat_code = ob_get_contents();
            ob_end_clean();

            echo apply_filters('mobilechat', $mobile_chat_code, [
              'chat' => [
                'container_class' => 'visible-xs visible-sm mobile-chat',
                'html_button' =>
                  '<span class="glyphicon glyphicon-comment" aria-hidden="true"></span><span class="icon-label">CHAT</span>',
              ],
              'text' => [
                'container_class' => 'visible-xs mobile-text',
                'html_button' =>
                  '<span class="glyphicon glyphicon-phone" aria-hidden="true"></span><span class="icon-label">TEXT</span>',
              ],
            ]);
            ?>
        </div>
    </div>

    <div class="fixed-top-spacer"></div>

    <div id="full-overlay" class="">
        <div id="overlayInner" class="">
            <!-- MENU OVERLAY MOBILE -->
            <div id="fullmenu-overlay" class="tool-overlay targetOverlay" style="display: none;">
                <div class="wrapper visible-xs visible-sm">
                    <div class="device-nav-menu">
                        <div id="close-button" class="close">
                            <?php get_scoped_template_part('includes/svg/icon-close', '', [
                              'height' => '25px',
                              'width' => '25px',
                            ]); ?>
                        </div>
                        <div class="navbar">
                            <div class="navbar-inner">
                                <?php $nav_menu_settings = [
                                  'theme_location' => isset($theme_location) ? $theme_location : 'mobile-header-menu',
                                  'container' => false,
                                  'menu_class' => isset($menu_class) ? $menu_class : 'nav',
                                  'echo' => true,
                                  'fallback_cb' => 'wp_page_menu',
                                  'depth' => isset($depth) ? $depth : 3,
                                  'walker' => isset($walker) ? $walker : new wp_bootstrap_navwalker(),
                                ]; ?>
                                <div class="nav_section">
                                    <?php DIFunctions::nav_menu($nav_menu_settings, 'mobile'); ?>
                                    <div class="overlay" id="menu-submenu-overlay">
                                        <div trid="ccab393eeb4744b4b416f7" trc class="back-button">
                                            <div class="back" id="back-button">
                                              <?php get_scoped_template_part('includes/svg/icon-chevron-left', '', [
                                                'height' => '30px',
                                                'width' => '30px',
                                              ]); ?>
                                            </div>
                                            <div class="title" id="heading-title">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_template_part('partials/homepage/mobile/open-hours'); ?>
    <?php
    $template = get_page_template_slug();
    if (\DIFunctions::is_inventory_page() && get_the_id() !== 20 && $template != 'page-di-page-composer.php') { ?>
    <a trid="fba362565d8e498baeb221" trc id="vrp-custom-filter" class="button primary-button" href="javascript:void(0);"><i class="fa fa-filter"></i> Filter</a>
    <?php }
    ?>
</div>