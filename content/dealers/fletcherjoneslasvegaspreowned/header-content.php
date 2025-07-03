<div class="hidden-sm hidden-xs">
    <div id="header" class="menu-top">
        <div class="header-top">
            <a trid="c51169d1ae624e178d597c" trc id="desktop-toggle" class="menu-toggle menu">
                <div class="menu-tab">
                    <div class="hamburger">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </div>
                    <span class="menu-text">MENU</span>
                </div>
            </a>

            <div class="logo" itemscope itemtype="http://schema.org/Organization">
                <a trid="ff21101b72dd4bb0aec434" trc itemprop="url" href="<?php echo home_url(); ?>">
                    <img itemprop="logo" src="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
                      get_option('di_slug') .
                      '/images/logo-head.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>">
                </a>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <img id="vessel-header-img" src="<?= get_field(
                      'vessel_header_image',
                      'option',
                    ) ?>" alt="Custom Header Image">
                <?php endif; ?>
            </div>

            <?php if (is_active_sidebar('holiday-hours')): ?>
                <a trid="ab7e7093703f4cc7bcfae1" trc class="holiday-hours-btn" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="Special Hours">
                    Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
                </a>
                <?php dynamic_sidebar('holiday-hours'); ?>
            <?php else: ?>
                <a trid="10a5c4a5889e4c0f991683" trc class="hours-icon" data-toggle="modal" data-target="#DIModal" data-modal-content="#hidden-div" data-modal-title="%%di_name%% Hours" data-modal-footer="hide"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
            <?php endif; ?>

            <!-- SEARCH ANYTHING -->
            <div class="search-anything-toggle">
                <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                    <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                    <button trid="1dd96ab44fd2447491f5b6" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn"> <?php get_template_part(
                      'includes/svg/icon',
                      'search',
                    ); ?></button>
                </form>
            </div>
        </div>


        <div class="header-bottom">
            <div class="header-bottom__left">
                <div class="dealer-phone">
                    <span class="phone"><i class="fa fa-phone" aria-hidden="true"></i> Sales: <span id="phonenumber_sales"><?php echo do_shortcode(
                      '[di_phone option_key="sales" format="withparens" clickable="true"]',
                    ); ?></span></span> |
                    <span class="phone"> Service: <span id="phonenumber_service"><?php echo do_shortcode(
                      '[di_phone option_key="service" format="withparens" clickable="true"]',
                    ); ?></span> </span>
                </div>
            </div>
            <div class="header-bottom__center">
                <div class="dealer-hours-container">
                    <div class="dealer-hours">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <span class="hours">Sales: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span> 
                    </div>
                </div>
            </div>
            <div class="header-bottom__right">
                <div class="dealer-address">
                    <a trid="16d1f8e36e2a40068bf437" trc target="_blank" itemprop="directions" href="<?php echo get_option(
                      'di_google_map',
                    ); ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo get_option(
  'di_street_address',
); ?> • <?php echo get_option('di_city'); ?>, <?php echo get_option('di_state'); ?> <?php echo get_option(
   'di_zipcode',
 ); ?></a>
                </div>
                <?php get_shared_template('header/language-toggle'); ?>
            </div>
        </div>
    </div>
</div>


<!-- VERTICAL MENU -->
<div id="menu-overlay" class="hidden-xs hidden-sm">
    <div id="header-vertical">
        <div class="navbar vertical">
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

<div id="search-overlay">
    <div class="overlay-container">
        <div class="overlay-content"></div>
    </div>
</div>

<div id="algolia-overlay" class="hidden-all">
    <span class="close-overlay">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close" />
    </span>
    <div class="search-field">
        <?php if (!is_plugin_active('maven-algolia/maven-algolia.php')) { ?>
            <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                <?php get_template_part('includes/svg/icon', 'search'); ?>
                <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                <button trid="8da5f27455ee482c93844c" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn">SEARCH</button>
            </form>
            <?php } else { ?>
            <?php get_scoped_template_part('partials/search/anything', '', isset($anything) ? $anything : []); ?>
            <?php } ?>
    </div>
</div>
<div id="contact-overlay" class="hidden-all">
    <span class="close-overlay">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close" />
    </span>
    <div>
        <h2> Contact Us </h2>
        <span class="sales-phone">
            <span class="department">Sales:</span> <?php echo do_shortcode(
              '[di_phone option_key="sales" format="withparens" clickable="true" classes="phone"]',
            ); ?>
        </span>
        <span class="service-phone">
            <span class="department">Service:</span> <?php echo do_shortcode(
              '[di_phone option_key="service" format="withparens" clickable="true" classes="phone"]',
            ); ?>
        </span>
    </div>
</div>

<div id="hidden-div" style="display:none;" class="clearfix">

    <div id="saleshours" class="col-md-6">
        <h3>Hours</h3>
        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
          $hours = DIHoursShortcode::get_day_specific_hours('Sales', $day);
          if (!empty($hours)) { ?>
                <div class="department-hours">
                    <span><?php echo $day; ?>: </span><span><?php echo $hours['open']['time']; ?> AM-<?php
 echo $hours['close']['time'];
 echo $hours['close']['meridiem'];
 ?></span>
                </div>
                <?php } else { ?>
                <div class="department-hours">
                    <span><?php echo $day; ?>: </span><span>Closed</span>
                </div>
                <?php }
        } ?>
    </div>

    <div id="servicehours" class="col-md-6">

        <?php
        // Testing for Service or Service & Parts
        $hourscheck = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Monday');
        $hoursheading = 'Service & Parts';
        if (empty($hourscheck)) {
          $hourscheck = DIHoursShortcode::get_day_specific_hours('Service', 'Monday');
          $hoursheading = 'Service';
        }
        ?>

        <h3><?php echo $hoursheading; ?></h3>
        <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day) {
          $hours = DIHoursShortcode::get_day_specific_hours($hoursheading, $day);

          if (!empty($hours)) { ?>
                <div class="department-hours">
                    <span><?php echo $day; ?>: </span><span><?php echo $hours['open']['time']; ?> AM-<?php
 echo $hours['close']['time'];
 echo $hours['close']['meridiem'];
 ?></span>
                </div>
                <?php } else { ?>
                <div class="department-hours">
                    <span><?php echo $day; ?>: </span><span>Closed</span>
                </div>
                <?php }
        } ?>
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

    <div class="menu-top <?php echo $showtitle ? 'with-labels' : ''; ?>">
        <div class="mobile-header-top">

            <div class="deviceWrapper__menu menu-hamburger open-overlay-js header-toggle-js" target="fullmenu">
                <span class="active">
                    <?php get_scoped_template_part('includes/svg/icon-menu', '', [
                      'height' => '25px',
                      'width' => '25px',
                    ]); ?>
                </span>
                <span class="icon-label">MENU</span>
            </div>

			<span class="logo" itemscope itemtype="http://schema.org/Organization">
				<a trid="8d4ea5c1364743489996bf" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
					<img itemprop="logo" src="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
       get_option('di_slug') .
       '/images/logo-head-mobile.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>">
				</a>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <img id="vessel-header-img" src="<?= get_field(
                      'vessel_header_image',
                      'option',
                    ) ?>" alt="Custom Header Image">
                <?php endif; ?>
			</span>

            <?php if (get_field('rotating-logos', '3') == 'Yes'): ?>
                <ul id="menu-top-menu" class="nav logo-swap hidden-xs">
                    <li class="menu-item rotating-logos" id="rotating-logos">
                        <div class="menu-item-img">
                            <?php if (get_field('amg-logo-header', '3') == true): ?>
                                <a trid="f70064d7973742e39d6eee" trc href="/new-vehicles/amg/"><img src="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg.png" alt="Amg Logo" class="loading"></a>
                            <?php endif; ?>
                            <?php if (get_field('sprinter-logo-header', '3') == true): ?>
                                <a trid="76435799ec7544a89d739b" trc href="/commercial-vans/"><img src="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter.png" alt="Sprinter Logo" class="loading"></a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>

            <?php do_action('before_mobile_menu_icons', get_the_ID()); ?>

            <div class="icons">
                <span class="menu-hours hidden-xs">
                  <a trid="7f7c7f9ef81343d0aa819d" trc class="hours-icon" target="_blank" href="<?php echo get_option(
                    'di_google_map',
                  ); ?>">
                    <?php get_scoped_template_part('includes/svg/icon-map-marker', '', [
                      'height' => '24px',
                      'width' => '24px',
                    ]); ?>
                  </a>
                </span>

                <span class="menu-search">
					<a trid="866d7f3703cc4b3cb699f3" trc class="overlay-toogle" data-toggle-target="#algolia-overlay" data-gtm="desktop.homepage.btn.buy">
                        <?php get_scoped_template_part('includes/svg/icon-search', '', [
                          'height' => '24px',
                          'width' => '24px',
                        ]); ?>
					</a>
				</span>

                <span class="menu-phone">
                    <?php
                    $phone = get_option('di_phone');
                    if (empty($phone)) {
                      $phone = get_option('di_phone_sales');
                    }
                    ?>
        			<a trid="f08fa8b0755643fab0f17f" trc data-phone="Sales" itemprop="phone" data-toggle-target="#contact-overlay" href="tel:<?php echo str_replace(
             [' ', '-', '(', ')', '.'],
             '',
             $phone,
           ); ?>" rel="nofollow">
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
                                        <div trid="bca9967fd69548f2b26b66" trc class="back-button">
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
    <?php if (\DIFunctions::is_inventory_page() && get_the_id() !== 20) { ?>
    <a trid="afee5e0c507b456e96de34" trc id="vrp-custom-filter" class="button primary-button" href="javascript:void(0);"><i class="fa fa-filter"></i> Filter</a>
    <?php } ?>
</div>

<?php get_frontend_component('header/model-row'); ?>
