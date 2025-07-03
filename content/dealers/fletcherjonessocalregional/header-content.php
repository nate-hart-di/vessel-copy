<div id="header">
    <div class="header-bottom">
        <div class="header-left">
            <a trid="43358be5e58d459fa1e5ca" trc id="mobile-menu-toggle" class="menu-hamburger" data-side="left" data-container="mobile-menu" data-gtm-event="mobileHeaderHamburger">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="header-mid">
            <?php
            $nav_image = get_field('header_nav_image', 'option');
            $nav_image_link = get_field('header_nav_image_link', 'option');
            $main_logo = get_field('main_logo', 'option');

            if ($nav_image): ?>
                <div class="header-image">
                    <a trid="5ff0ef7bffa24135b0b327" trc href="<?php echo $nav_image_link; ?>" >
                        <img src="<?php echo $nav_image['url']; ?>" alt="<?php echo $nav_image['alt']; ?>" />
                    </a>
                </div>
                <?php else: ?>
                    <a trid="1b93114ceaf54dad8a1068" trc class="fj-navbar-brand" href="/"><span class="text-logo">Fletcher Jones</span></a>
            <?php endif;
            ?>
            
            <?php do_action('before_mobile_menu_icons', get_the_ID()); ?>
        </div>
        <div class="header-right">
            <div class="header-search">
                <div class="search-toggle">
                    <i class="fa fa-search" aria-hidden="true"></i><span>Search</span>
                </div>
                <div class="search-bar" data-testid="search-menu">
                    <span id="close-search"><i class="fa fa-close"></i></span>
                    <?php get_scoped_template_part('partials/search/anything', '', [
                      'button_text' => 'Search',
                      'search_placeholder' => 'Search Anything...',
                    ]); ?>
                </div>
            </div>
            <a trid="c292cbff9ce04fab94b111" trc class="store-locator" href="/locations/"><i class="fa fa-map-marker" aria-hidden="true"></i>Store Locator</a>
            <?php get_shared_template('header/language-toggle'); ?>
        </div>
    </div>
    <div id="mobile-menu" class="mobile-nav-menu sidebar-navigation-enabled" style="display: none;">
        <div class="navbar">
            <div class="navbar-inner">
                <?php $nav_menu_settings = [
                  'theme_location' => isset($theme_location) ? $theme_location : 'mobile-menu',
                  'container' => 'div',
                  'container_class' => 'collapse navbar-collapse',
                  'container_id' => 'collapse-1',
                  'menu_class' => isset($menu_class) ? $menu_class : 'nav',
                  'echo' => true,
                  'fallback_cb' => 'wp_page_menu',
                  'depth' => isset($depth) ? $depth : 3,
                  'walker' => isset($walker) ? $walker : new wp_bootstrap_navwalker(),
                ]; ?>
                <div class="nav_section">
                    <?php DIFunctions::nav_menu($nav_menu_settings, 'mobile'); ?>
                </div>
                <?php do_action('after_mobile_menu'); ?>
                <?php apply_filters('after_offcanvas_mobile_nav', ''); ?>
            </div>
        </div>
    </div>
</div>
<div class="fixed-top-spacer hidden-xs"></div>