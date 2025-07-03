<?php
$pg = 'option'; ?>
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
                    <a trid="dc8d3e8f4e3f4d77a8243e" trc itemprop="url" href="<?php echo home_url(); ?>">
                        <img itemprop="logo" src="<?php echo '/wp-content/plugins/vessel/content/dealers/' .
                          get_option('di_slug') .
                          '/images/logo-head.png'; ?>" alt="<?php echo get_bloginfo('title'); ?>">
                    </a>
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
                                    <a trid="ddf7e1ef6f9444f2a8cb57" trc class="menu-item-img">
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
                                                <a trid="8fff2f048e1e4205ab884d" trc href="/new-vehicles/amg/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-amg-large.png" alt="Amg Logo"></a>
                                            <?php endif; ?>
                                            <?php if (get_field('sprinter-logo-header', $pg) == true): ?>
                                                <a trid="bc3180dac1d6457fa53762" trc href="/commercial-vans/"><img data-original="/wp-content/themes/DealerInspireCommonTheme/images/dealer-groups/fletcherjones-v2/logo-sprinter-large.png" alt="Sprinter Logo"></a><br>
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

                              $class = $menu_item->classes['0'];
                              $link_target = '_self';
                              $target = $menu_item->target;
                              if (is_array($target) && !empty($target)) {
                                if (array_key_exists('_menu_item_target', $target)) {
                                  $link_target = $target['_menu_item_target'][0];
                                }
                              }
                              ?>
                                <?php if ($menu_item->menu_item_parent == 0): ?>
                                    <li class="menu-item"><a trid="581f2873f0f646fc8b76dd" trc <?php if (
                                      $class == '' ||
                                      in_array('hide-submenu', $menu_item->classes)
                                    ): ?>href="<?= $menu_item->url ?>"<?php endif; ?> target="<?php echo $link_target; ?>" ><?php echo str_replace(
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

                                                            <a trid="8e6a06b8e4bb4a52b45ee7" trc href="<?php echo $menuadlink; ?>">
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
            <?php
            $nav_image = get_field('header_nav_image', 'option');
            $nav_image_link = get_field('header_nav_image_link', 'option');
            if ($nav_image): ?>
            <div class="header-ad-image">
                <a trid="9469d0e58250490294b99d" trc href="<?php echo $nav_image_link; ?>" >
                    <img src="<?php echo $nav_image['url']; ?>" alt="<?php echo $nav_image['alt']; ?>" />
                </a>
            </div>
            <?php endif;
            ?>

            <?php if (is_active_sidebar('holiday-hours')): ?>
                <a trid="0c2773e8f6434512ab968f" trc class="holiday-hours-btn" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="Special Hours">
                    Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
                </a>
                <?php dynamic_sidebar('holiday-hours'); ?>
            <?php else: ?>
                <a trid="af737cf92a774d0ca5b469" trc class="hours-icon" data-toggle="modal" data-target="#DIModal" data-modal-content="#hidden-div" data-modal-title="%%di_name%% Hours" data-modal-footer="hide"><i class="fa fa-clock-o" aria-hidden="true"></i></a>
            <?php endif; ?>

            <!-- SEARCH ANYTHING -->
            <div class="search-anything-toggle">
                <?php if (!is_plugin_active('maven-algolia/maven-algolia.php')) { ?>
                    <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                        <?php get_template_part('includes/svg/icon', 'search'); ?>
                        <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]'); ?>
                        <button trid="e89859201a2c493c84c85a" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn">SEARCH</button>
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
                    <div class="col-sm-4">
                        <div class="dealer-phone">
                            <span class="phone"><i class="fa fa-phone" aria-hidden="true"></i> Sales: <?php echo do_shortcode(
                              '[di_phone option_key="sales" format="withparens" clickable="true"]',
                            ); ?> </span> |
                            <span class="phone"> Service: <?php echo do_shortcode(
                              '[di_phone option_key="service" format="withparens" clickable="true"]',
                            ); ?> </span>
                            <?php do_action('mb_additional_phone_number'); ?>
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
                            <a trid="3ec90bfd3e424f6d96f257" trc target="_blank" itemprop="directions" href="<?php echo get_option(
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
</div>

<div id="search-overlay">
    <div class="overlay-container">
        <span class="close-overlay">
            <img data-original="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close" />
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
                <button trid="b4bc184cc172468796ee5e" trc type="submit" class="btn search-anything-submit-btn" data-gtm-event="mobileSearchOverlaySearchBtn">SEARCH</button>
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
                    <span><?php echo $day; ?>: </span>
                    <span>
                        <?php
                        $openTodayText = get_option('di_open_today_text');
                        if (!empty($openTodayText)) {
                          echo $openTodayText;
                        } else {
                          echo $hours['open']['time']; ?> AM-<?php
 echo $hours['close']['time'];
 echo $hours['close']['meridiem'];

                        }
                        ?>
                    </span>
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
