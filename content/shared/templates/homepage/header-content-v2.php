<?php use DealerInspire\Vessel\FJ as _FJ;
$id = get_option('di_id');
$isTemecula = $id == _FJ::getInstance()->dealerIdList['temecula'];
$pg = 'option';
?>

<div class="hidden-sm hidden-xs">
    <div id="header" class="menu-top">

        <div class="header-top">
            <div class="logo" itemscope itemtype="http://schema.org/Organization">
                <?php
                $imageOverride = get_field('vessel_main_logo', 'option');
                if (!empty($imageOverride)): ?>
                <div class="vessel-main-logo">
                    <img src="<?php echo $imageOverride['url']; ?>" alt="<?php echo $imageOverride['alt']; ?>">
                </div>
                <?php else: ?>
                <a trid="e1e7c51f55c14536ac6e4b" trc itemprop="url" href="<?php echo home_url(); ?>"><img itemprop="logo" src="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
  get_option('di_slug') .
  '/images/logo-head.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>"></a>
                <?php endif;
                ?>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <img id="vessel-header-img" src="<?= get_field(
                      'vessel_header_image',
                      'option',
                    ) ?>" alt="Custom Header Image">
                <?php endif; ?>
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
                                    <a trid="a9dc1a8019ac4e00b19b11" trc class="menu-item-img">
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
                                                <a trid="146776dff55b435d9db9df" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg-large.png" alt="Amg Logo"></a>
                                            <?php endif; ?>
                                            <?php if (get_field('sprinter-logo-header', $pg) == true): ?>
                                                <a trid="ff56968a4c9143c4811a8b" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter-large.png" alt="Sprinter Logo"></a><br>
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
                                    <li class="menu-item"><a trid="46c8da80e8a14c7db05558" trc <?php if (
                                      $class == '' ||
                                      in_array('hide-submenu', $menu_item->classes)
                                    ): ?>href="<?= $menu_item->url ?>"<?php endif; ?>><?php echo str_replace(
  ' Vehicles',
  '',
  $menu_item->title,
); ?></a>
                                        <?php if ($class != '' || in_array('hide-submenu', $menu_item->classes)): ?>
                                            <div class="header-dropdown dropdown-full <?php echo $class; ?>">
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

                                                            <a trid="eb51c5c721944982ac65fd" trc href="<?php echo $menuadlink; ?>">
                                                                <img data-original="<?php echo $menuad[
                                                                  'url'
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
            <?php if (is_active_sidebar('holiday-hours')): ?>
                <a trid="bce407c1fa574231bbfafe" trc class="holiday-hours-btn" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="Special Hours">
                    Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
                </a>
                <?php dynamic_sidebar('holiday-hours'); ?>
            <?php else: ?>
                <a trid="4a524d0d7cd643379f4d42" trc class="hours-icon" data-toggle="modal" data-target="#DIModal" data-modal-content="#hidden-div" data-modal-title="%%di_name%% Hours" data-modal-footer="hide"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
            <?php endif; ?>

            <!-- SEARCH ANYTHING -->
            <div class="search-anything-toggle">
                <?php if (!is_plugin_active('maven-algolia/maven-algolia.php')) { ?>
                    <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                        <?php get_template_part('includes/svg/icon', 'search'); ?>
                        <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                        <button trid="4e36b66bba384d3781f953" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn">SEARCH</button>
                    </form>
                    <?php } else { ?>
                    <?php get_scoped_template_part(
                      'partials/search/anything',
                      '',
                      isset($anything) ? $anything : [],
                    ); ?>
                    <?php } ?>
            </div>
        </div>


        <div class="header-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4 no-padding">
                        <div class="dealer-phone">
                            <span class="phone"><i class="fa fa-phone" aria-hidden="true"></i> Sales: <?php echo do_shortcode(
                              '[di_phone option_key="sales" format="withparens" clickable="true"]',
                            ); ?> </span> |
                            <span class="phone"> Service: <?php echo do_shortcode(
                              '[di_phone option_key="service" format="withparens" clickable="true"]',
                            ); ?> </span>
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
                    <div class="col-sm-4 no-padding">
                        <div class="dealer-address">
                            <a trid="83969b06021c4291b226db" trc target="_blank" itemprop="directions" href="<?php echo get_option(
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
        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close" />
		</span>
        <div class="overlay-content">
        </div>
        <div class="search-section" style="display:none">
        <?php if ($isTemecula) { ?>
                <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                    <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                </form>
                <?php } else { ?>
                <?php get_scoped_template_part('partials/search/anything', '', isset($anything) ? $anything : []); ?>
                <?php } ?>
        </div>
    </div>
</div>

<?php get_shared_template('homepage/button-overlay'); ?>

<div id="algolia-overlay" class="hidden-all">
    <div class="search-field">
        <?php if (!is_plugin_active('maven-algolia/maven-algolia.php')) { ?>
            <form action="/" id="searchform"  data-testid="searchform" role="search" method="get">
                <?php get_template_part('includes/svg/icon', 'search'); ?>
                <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                <button trid="d9eebdd070474ba7860da3" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn">SEARCH</button>
            </form>
            <?php } else { ?>
            <?php get_scoped_template_part('partials/search/anything', '', isset($anything) ? $anything : []); ?>
            <?php } ?>
    </div>
</div>

<div id="contact-overlay" class="hidden-all">
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

<div id="hidden-div" style="display:none;" class="clearfix">

    <div id="saleshours" class="col-md-6">
        <h3>Sales Hours</h3>
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
        $mondayHrs = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Monday');

        if (empty($mondayHrs)) {
          $hourscheck = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Tuesday');
        } else {
          $hourscheck = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Monday');
        }

        $hoursheading = 'Service & Parts';

        if (empty($hourscheck)) {
          if ($mondayHrs) {
            $hourscheck = DIHoursShortcode::get_day_specific_hours('Service', 'Tuesday');
          } else {
            $hourscheck = DIHoursShortcode::get_day_specific_hours('Service', 'Monday');
          }
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

    <div class="menu-top <?php echo $showtitle ? ' with-labels' : ''; ?>">
        <div class="mobile-header-top">
			<span class="logo" itemscope itemtype="http://schema.org/Organization">
				<a trid="35e61b85a8214fe99662f6" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
					<img itemprop="logo" data-original="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
       get_option('di_slug') .
       '/images/logo-head-mobile.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>">
				</a>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <img id="vessel-header-img" data-original="<?= get_field(
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
                                <a trid="e8eacb2e00634c6b84885a" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg.png" alt="Amg Logo" class="loading"></a>
                            <?php endif; ?>
                            <?php if (get_field('sprinter-logo-header', '3') == true): ?>
                                <a trid="b11dede8557d4fcbbaff32" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter.png" alt="Sprinter Logo" class="loading"></a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            <?php endif; ?>

            <?php do_action('before_mobile_menu_icons', get_the_ID()); ?>

            <div class="icons">
				<span class="menu-hours">
				  <?php if (is_active_sidebar('holiday-hours')): ?>
                      <a trid="d20f847646704efc9cbbe3" trc class="holiday-hours-btn" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="Special Hours">
				      <i class="fa fa-clock-o fa-lg fa-fw"></i>
				    </a>
                      <?php dynamic_sidebar('holiday-hours'); ?>
                  <?php else: ?>
                      <a trid="cc63602d3e314fe6aa216e" trc class="hours-icon" data-toggle="modal" data-target="#DIModal" data-modal-content="#hidden-div" data-modal-title="%%di_name%% Hours" data-modal-footer="hide">
				      <i class="fa fa-clock-o" aria-hidden="true"></i>
				    </a>
                  <?php endif; ?>
				</span>

                <span class="menu-search">
					<a trid="1ae52230fa6f45f290f527" trc class="overlay-toogle" data-toggle-target="#algolia-overlay" data-gtm="desktop.homepage.btn.buy">
						<img data-original="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-search.png" alt="Search" />
					</a>
				</span>

                <span class="menu-phone">
					<a trid="155bea36568e42aab18753" trc class="overlay-toogle" data-toggle-target="#contact-overlay" data-gtm-event="mobileHeaderPhone">
						<img data-original="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-phone.png" alt="Search" />
					</a>
				</span>

                <a trid="af2ff80e437143fd8dc491" trc id="mobile-menu-toggle" class="menu-hamburger visible-sm visible-xs" data-side="right" data-container="mobile-menu" data-gtm-event="mobileHeaderHamburger">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-label">MENU</span>
                </a>

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

    <div id="mobile-menu" class="mobile-nav-menu sidebar-navigation-enabled" style="display: none;">
        <div class="menu-row">
            <div class="menu-span">
                <div class="navbar">
                    <div class="navbar-inner">
                        <?php $nav_menu_settings = [
                          'theme_location' => isset($theme_location) ? $theme_location : 'mobile-menu',
                          'container' => false,
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_template_part('partials/homepage/mobile/open-hours'); ?>
</div>
