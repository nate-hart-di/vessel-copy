<?php
$pg = get_option('page_on_front'); ?>
<div class="hidden-sm hidden-xs">
    <div id="header" class="menu-top">
        <div class="header-top">
            <div class="logo" itemscope itemtype="http://schema.org/Organization">
                <a trid="cce6acfe80cb48abbed20d" trc itemprop="url" href="<?php echo home_url(); ?>">
                    <?php if (!get_field('vessel_header_image', 'option')): ?>
                        <img itemprop="logo" data-original="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-head.png" alt="<?php echo get_bloginfo(
  'title',
); ?>">
                    <?php endif; ?>
                    <?php if (get_field('vessel_header_image', 'option')): ?>
                        <img id="vessel-header-img" data-original="<?= get_field(
                          'vessel_header_image',
                          'option',
                        ) ?>" alt="Custom Header Image">
                    <?php endif; ?>
                </a>
            </div>
            <div id="main-navbar" class="navbar flex">
                <div class="navbar-inner">
                    <div class="nav_section">
                        <?php if (
                          get_field('rotating-logos', $pg) == 'Yes' &&
                          get_field('rotating-logos-header', $pg) == 'Yes'
                        ): ?>
                            <ul id="menu-top-menu" class="nav logo-swap">
                                <li class="menu-item rotating-logos" id="rotating-logos">
                                    <a trid="751d79fef69e4d0da72307" trc class="menu-item-img">
                                        <?php
                                        $rotatingenable = '';
                                        if (
                                          get_field('amg-logo-header', $pg) == true &&
                                          get_field('sprinter-logo-header', $pg) == true
                                        ) {
                                          $rotatingenable = ' rotating';
                                        }
                                        ?>
                                        <?php if (get_field('amg-logo-header', $pg) == true): ?>
                                            <img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg.png" alt="Amg Logo" id="<?php echo $rotatingenable; ?>" class="loading">
                                        <?php endif; ?>
                                        <?php if (get_field('sprinter-logo-header', $pg) == true): ?>
                                            <img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter.png" alt="Sprinter Logo" id="<?php echo $rotatingenable; ?>" class="loading">
                                        <?php endif; ?>
                                    </a>
                                    <div class="header-dropdown dropdown-full">
                                        <div class="header-dropdown-container">
                                            <?php if (get_field('amg-logo-header', $pg) == true): ?>
                                                <a trid="f72c965633304252bf07db" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg-large.png" alt="Amg Logo"></a>
                                            <?php endif; ?>
                                            <?php if (get_field('sprinter-logo-header', $pg) == true): ?>
                                                <a trid="54a9af4f545b48698f3b93" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter-large.png" alt="Sprinter Logo"></a><br>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <?php endif; ?>


                        <ul id="menu-top-menu" class="nav">
                            <?php
                            $items = wp_get_nav_menu_items('main-menu');
                            foreach ($items as $i => $menu_item) {
                              $class = $menu_item->classes['0']; ?>
                                <?php if ($menu_item->menu_item_parent == 0): ?>
                                    <li class="menu-item"><a trid='f6f1c112a8704817981413' trc <?php if (
                                      $class == '' ||
                                      in_array('hide-submenu', $menu_item->classes)
                                    ): ?>href="<?= $menu_item->url ?>"<?php endif; ?>><?php echo str_replace(
  ' Vehicles',
  '',
  $menu_item->title,
); ?></a>
                                        <?php if ($class != '' || in_array('hide-submenu', $menu_item->classes)): ?>
                                            <div class="header-dropdown dropdown-full">
                                                <div class="header-dropdown-container">
                                                    <div class="menu-navigation">

                                                        <h2> <?= $menu_item->attr_title != ''
                                                          ? $menu_item->attr_title
                                                          : $menu_item->title ?> </h2>
                                                        <?php if (is_active_sidebar($class . '-menu-sidebar')) {
                                                          dynamic_sidebar(ucfirst($class) . ' Menu Sidebar');
                                                        } ?>
                                                    </div>

                                                    <div class="menu-image-sidebar">
                                                        <?php
                                                        $menuad = get_field($class . '_menu_ad', 3);
                                                        $menuadlink = get_field($class . '_menu_ad_link', 3);

                                                        if (!empty($menuad)): ?>

                                                            <a trid="3269bb791b3c40428fda01" trc href="<?php echo $menuadlink; ?>">
                                                                <img data-original="<?php echo $menuad['sizes'][
                                                                  'large'
                                                                ]; ?>" alt="<?php echo $menuad['alt']; ?>" />
                                                            </a>

                                                        <?php endif;
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>

                </div>
            </div>
            <?php
            $nav_image = get_field('header_nav_image', 'option');
            $nav_image_link = get_field('header_nav_image_link', 'option');
            if ($nav_image): ?>
            <div class="header-ad-image">
                <a trid="212f3d8450474f4990d164" trc href="<?php echo $nav_image_link; ?>" >
                    <img src="<?php echo $nav_image['url']; ?>" alt="<?php echo $nav_image['alt']; ?>" />
                </a>
            </div>
            <?php endif;
            ?>

            <?php if (is_active_sidebar('holiday-hours')): ?>
                <a trid="4e24591489dd4e2b96fd7d" trc class="holiday-hours-btn" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="Special Hours">
                    Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
                </a>
                <?php dynamic_sidebar('holiday-hours'); ?>
            <?php else: ?>
                <a trid="088554e9bcc64c65b3708f" trc class="hours-icon" data-toggle="modal" data-target="#DIModal" data-modal-content="#hidden-div" data-modal-title="%%di_name%% Hours" data-modal-footer="hide"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
            <?php endif; ?>

            <!-- SEARCH ANYTHING -->
            <div class="search-anything-toggle">
                <form action="/" id="searchform" role="search" method="get">
                <?php get_scoped_template_part('partials/search/anything', '', isset($anything) ? $anything : []); ?>

                    <button trid="c94fcb3990fa4499b18027" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn"> <?php get_template_part(
                      'includes/svg/icon',
                      'search',
                    ); ?></button>
                </form>
            </div>
        </div>


        <div class="header-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="dealer-phone">
                            <span class="phone"><i class="fa fa-phone" aria-hidden="true"></i> Sales: <span id="phonenumber_sales"><?php echo do_shortcode(
                              '[di_phone option_key="sales" format="withparens" clickable="true"]',
                            ); ?></span></span> |
                            <span class="phone"> Service: <span id="phonenumber_service"><?php echo do_shortcode(
                              '[di_phone option_key="service" format="withparens" clickable="true"]',
                            ); ?></span> </span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dealer-hours-container">
                            <div class="dealer-hours">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <span class="hours">Sales: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span>
                                |<span class="hours">Service: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="dealer-address">
                            <a trid="8d760de177b44d97af00ee" trc target="_blank" itemprop="directions" href="<?php echo get_option(
                              'di_google_map',
                            ); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo get_option(
  'di_street_address',
); ?> • <?php echo get_option('di_city'); ?>, <?php echo get_option('di_state'); ?> <?php echo get_option(
   'di_zipcode',
 ); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (shortcode_exists('inventory_lightning')): ?>
    <div class="fixed-top-spacer">
    </div>
    <?php endif; ?>
</div>

<div id="search-overlay">
    <div class="overlay-container">
		<span class="close-overlay">
        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close button" />
		</span>
        <div class="overlay-content">
        </div>
        <div class="search-section" style="display:none">
            <?php get_scoped_template_part('partials/search/anything', '', isset($anything) ? $anything : []); ?>
        </div>
    </div>
</div>

<?php get_shared_template('homepage/button-overlay'); ?>

<div id="algolia-overlay" class="hidden-all">
    <div class="search-field">
        <?php if (!is_plugin_active('maven-algolia/maven-algolia.php')) { ?>
            <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                <?php get_template_part('includes/svg/icon', 'search'); ?>
                <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                <button trid="a5c3877bd3cc41acb5499d" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn">SEARCH</button>
            </form>
            <?php } else { ?>
            <?php get_scoped_template_part('partials/search/anything', '', isset($anything) ? $anything : []); ?>
            <?php } ?>
    </div>
</div>

<div id="contact-overlay" class="hidden-all">
    <h2> Contact Us </h2>
    <span class="sales-phone">
		<span class="department">Sales:</span> <span id="phonenumber_sales2"><?php echo do_shortcode(
    '[di_phone option_key="sales" format="withparens" clickable="true" classes="phone"]',
  ); ?></span>
	</span>
    <span class="service-phone">
        <span class="department">Service:</span> <span id="phonenumber_service2"><?php echo do_shortcode(
          '[di_phone option_key="service" format="withparens" clickable="true" classes="phone"]',
        ); ?></span>
	</span>
</div>

<div id="hidden-div" style="display:none;" class="clearfix">

    <div id="saleshours" class="col-md-12">
        <?php echo do_shortcode(
          '[dealer_info show_phones="false" show_heading="false" departments="Sales" full_day_string="true" ]',
        ); ?>
    </div>

    <div id="servicehours" class="col-md-12">

        <?php
        // Testing for Service or Service & Parts
        $hourscheck = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Monday');
        $hoursheading = 'Service & Parts';
        if (empty($hourscheck)) {
          $hourscheck = DIHoursShortcode::get_day_specific_hours('Service', 'Monday');
          $hoursheading = 'Service';
        }
        ?>
        <?php echo do_shortcode(
          '[dealer_info show_phones="false" show_heading="false" departments="' .
            $hoursheading .
            '" full_day_string="true" ]',
        ); ?>
    </div>
</div>

<?php if (has_action('fj_below_homepage_video') || get_field('search_usp')) { ?>
    <div id="usp-overlay" class="hidden-all">
        <?php if (has_action('fj_below_homepage_video')) {
          do_action('fj_below_homepage_video');
        } else {
          the_field('search_usp');
        } ?>
    </div>
<?php } ?>

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
				<a trid="ce4077657e534429858ac9" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
					<img itemprop="logo" data-original="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
       get_option('di_slug') .
       '/images/logo-head-mobile.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>">
				</a>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <a trid="6c335d933d2042c2b58cb9" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
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
                                <a trid="e9227e37e22d4f9c8b79c3" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg.png" alt="Amg Logo" class="loading"></a>
                            <?php endif; ?>
                            <?php if (get_field('sprinter-logo-header', $pg) == true): ?>
                                <a trid="caee5fa11dc5444092afff" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter.png" alt="Sprinter Logo" class="loading"></a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>

            <?php do_action('before_mobile_menu_icons', get_the_ID()); ?>

            <div class="icons">
                <span class="menu-hours hidden-xs">
                  <a trid="d25cb2f1a8d948c891fca7" trc class="hours-icon" target="_blank" href="<?php echo get_option(
                    'di_google_map',
                  ); ?>">
                    <?php get_scoped_template_part('includes/svg/icon-map-marker', '', [
                      'height' => '24px',
                      'width' => '24px',
                    ]); ?>
                  </a>
                </span>

                <span class="menu-search">
					<a trid="352d5f9b917841568d522c" trc class="overlay-toogle" data-toggle-target="#algolia-overlay" data-gtm="desktop.homepage.btn.buy">
                        <?php get_scoped_template_part('includes/svg/icon-search', '', [
                          'height' => '24px',
                          'width' => '24px',
                        ]); ?>
					</a>
				</span>

                <span class="menu-phone">
					<a trid="81c0ef2f2f2846cf805f82" trc class="overlay-toogle" data-toggle-target="#contact-overlay" data-gtm-event="mobileHeaderPhone">
						<?php get_scoped_template_part('includes/svg/icon-phone', '', ['height' => '24px', 'width' => '24px']); ?>
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

        <?php get_template_part('partials/homepage/mobile/open-hours'); ?>

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
                                        <div trid="7a6a8cc2339a46b5a8f312" trc class="back-button">
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

    <?php
    $template = get_page_template_slug();
    if (\DIFunctions::is_inventory_page() && get_the_id() !== 20 && $template != 'page-di-page-composer.php') { ?>
    <a trid="befcd7cd62154a0faf5b6c" trc id="vrp-custom-filter" class="button primary-button" href="javascript:void(0);"><i class="fa fa-filter"></i> Filter</a>
    <?php }
    ?>
</div>
