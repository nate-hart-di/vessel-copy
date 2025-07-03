<?php
// Adds on non Site Builder sites "skip-to-main-content tab above the header for Accessibility: needed for skipping navigation"
add_action(
  'wp_after_body',
  function () {
    $sb = get_option('site_builder_enabled');
    if (is_front_page() && !$sb) {
      echo "<div id='skip-to-main-content'><a trid='a39869be76f24908b76007' trc href='#main-content'>skip to main content</a></div>";
    }
  },
  8,
);

// ACTIONS
add_action('wp_enqueue_scripts', 'load_child_scripts');
add_action('wp_print_scripts', 'override_js');
add_action('acf/init', 'toyota_two_cta_field_groups');
add_action('acf/init', 'toyota_two_service_field_groups');
add_action('wp_enqueue_scripts', 'load_header_shared_script');
add_action('header_after_logo', function () {
  ?>
        <?php if (get_field('vessel_header_image', 'option') && get_field('vessel_header_image_link', 'option')): ?>
                <a trid="654417994ee44662b0f00c" trc href="<?php echo get_field(
                  'vessel_header_image_link',
                  'option',
                ); ?>">
                    <img id="vessel-header-img" src="<?php echo get_field(
                      'vessel_header_image',
                      'option',
                    ); ?>" alt="Custom Header Image">
                </a>
            <?php elseif (get_field('vessel_header_image', 'option')): ?>
                <img id="vessel-header-img" src="<?= get_field(
                  'vessel_header_image',
                  'option',
                ) ?>" alt="Custom Header Image">
            <?php endif; ?>
    <?php
});

// FILTERS
add_filter('vdp_link_url_variables', 'dealer_theme_vdp_url_keys');
add_filter('google_font_list', 'dealer_theme_google_fonts');
add_filter('load_sprites_on_mobile', '__return_true');
add_filter('acf/load_value/key=cta_section', 'default_value_toyota_two_cta', 10, 3);
add_filter('acf/load_value/key=service_buttons', 'default_value_toyota_two_service', 10, 3);

// INCLUDES
include_once WP_CONTENT_DIR .
  '/themes/DealerInspireCommonTheme/includes/oem/toyota/toyotaexample2/section-cta-acfs.php';
include_once WP_CONTENT_DIR .
  '/themes/DealerInspireCommonTheme/includes/oem/toyota/toyotaexample2/section-service-acfs.php';

// add make-specific vehicle styles
function load_child_scripts()
{
  if (function_exists('load_vehicle_sprites')) {
    load_vehicle_sprites(['toyota-menu']);
  }

  wp_register_script(
    'child-script',
    get_stylesheet_directory_uri() . '/includes/js/min/custom.min.js',
    ['jquery'],
    filemtime(WP_CONTENT_DIR . '/themes/DealerInspireDealerTheme/includes/js/min/custom.min.js'),
    true,
  );
  wp_enqueue_script('child-script');

  wp_enqueue_script('jquery-ui-accordion', false, ['jquery', 'jquery-ui-core'], null, true);

  wp_register_style('swiper-css', get_template_directory_uri() . '/includes/js/swiper/swiper.min.css');
  wp_enqueue_style('swiper-css');
  wp_register_script('swiper-js', get_template_directory_uri() . '/includes/js/swiper/swiper.jquery.min.js');
  wp_enqueue_script('swiper-js');
  wp_register_style('toyotafont', get_template_directory_uri() . '/css/dealer-groups/toyota/toyota-fonts.css');
  wp_enqueue_style('toyotafont');
}

function load_header_shared_script()
{
  wp_register_script(
    'header-script',
    get_template_directory_uri() . '/includes/oem/toyota/toyota-header-script.js',
    ['jquery'],
    filemtime(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/toyota/toyota-header-script.js'),
    true,
  );
  wp_enqueue_script('header-script');
}

// Async Google font loader
function dealer_theme_google_fonts($fonts)
{
  // Add each font to the array separately like so:
  //$fonts[] = 'Source+Sans:700,300,900,600,400';
  //$fonts[] = 'Another+Sans:100';
  return $fonts;
}

function override_js()
{
  wp_dequeue_script('custom');
}

// Default to VDP URLs having new/used in the URL
function dealer_theme_vdp_url_keys($keys)
{
  return ['type', 'year', 'make', 'model', 'trim', 'drivetrain', 'body', 'vin'];
}

// use "condensed" image gallery on HotWheels VDP - DO NOT REMOVE
add_filter('di_hotwheels_gallery_path', function ($path) {
  return 'partials/vdp/project-hotwheels/vehicle-gallery-condensed';
});

function main_overlay()
{
  ob_start();
  get_template_part('partials/slider-overlay');
  return ob_get_clean();
}

//CREATE FULL MAP SHORTCODE
function mapbox_map()
{
  ob_start();
  get_scoped_template_part('partials/map/mapboxscript', '', [
    'node' => 'map',
    'style_url' => 'mapbox://styles/di-sysops/cjli1eb8c0rh22roj7j4pfbx1',
    'zoom' => 14,
    'map_options' => '{dragging:0,zoomControl:false}',
    'load_on_mobile' => true,
  ]);
  return ob_get_clean();
}

//REGISTER SHORTCODES - FULL MAP
function register_shortcodes()
{
  add_shortcode('hero-slider-overlay', 'main_overlay');
  add_shortcode('mapbox-map', 'mapbox_map');
}
add_action('init', 'register_shortcodes');

//Add additional button in header before logo
add_action('header_after_logo', 'header_mobile_logo');
function header_mobile_logo()
{
  ?>
    <a trid="7822f382008a4bc2b6f1a8" trc href="<?php echo home_url(); ?>" class="logo__dealer--imageMobile visible-sm visible-xs">
        <picture>
            <img
                src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-header.png?ver=<?php echo filemtime(
  get_stylesheet_directory() . '/images/logo-header.png',
); ?>"
                alt="<?php // No Alt text because the image is decorative
  ?>"
                loading="eager"
                width="auto"
                height="30" />
        </picture>
    </a>
<?php
}

//Add additional button in header before logo
add_action('header_before_phone', 'hours_dropdown');
function hours_dropdown()
{
  ?>
    <div class="dealer-hours-container">
        <div class="dealer-hours">
            <span class="sales-hours">Sales: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span>
            <span class="service-hours">Service: <i class="fa fa-spinner fa-spin"></i><span class="hours-placeholder"></span></span>
        </div>
        <div class="hours-dropdown">
            <div id="saleshours">
                <?php echo do_shortcode(
                  '[dealer_info show_phones="false" show_heading="false" departments="Sales" full_day_string="true" ]',
                ); ?>
            </div>
            <div id="servicehours">

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
    </div>
<?php
}

add_action('navigation_left', function () {
  ob_start();
  include plugin_dir_path(__FILE__) . 'partials/language-toggle.php';
  echo ob_get_clean();
});

include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/acf/local-json.php';
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/acf/site-settings-option-page-logo.php';
