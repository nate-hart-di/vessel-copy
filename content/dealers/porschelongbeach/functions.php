<?php

// ACTIONS
add_action('wp_enqueue_scripts', 'load_child_scripts');
add_action('wp_print_scripts', 'override_js');
add_action('init', 'register_shortcodes');
add_action('vehicle_pre_save', 'cpo_pdf_urls');
add_action('vrp_listview_pricing_bottom_text', 'vrp_options_cta');
add_filter('di_common_svg_dirs', 'custom_svgs', 20, 1);
function custom_svgs($dirs)
{
  return array_merge($dirs, [WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher']);
}

// FILTERS
add_filter('vdp_link_url_variables', 'dealer_theme_vdp_url_keys');
add_filter('google_font_list', 'dealer_theme_google_fonts');
add_filter('di_hotwheels_gallery_path', function ($path) {
  return 'partials/vdp/project-hotwheels/vehicle-gallery-condensed';
});

// INCLUDES
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/partials/hours/closed-hours-text/closed-hours-text.php';
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/cookie-disclaimer/cookie-disclaimer.php';

// add make-specific vehicle styles
function load_child_scripts()
{
  if (function_exists('load_vehicle_sprites')) {
    load_vehicle_sprites(['porsche-menu']);
  }

  wp_register_style('swiper-css', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css');
  wp_enqueue_style('swiper-css');

  wp_register_script(
    'swiper-js',
    get_template_directory_uri() . '/includes/js/swiper/swiper.jquery.min.js',
    ['jquery'],
    null,
    true,
  );
  wp_enqueue_script('swiper-js');

  wp_register_style('porschefont', get_template_directory_uri() . '/css/dealer-groups/porsche/porsche-fonts.css');
  wp_enqueue_style('porschefont');
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

//Shared Functions
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/porsche/porsche-functions.php';

//CREATE FULL MAP SHORTCODE
function full_map()
{
  ob_start();
  get_template_part('/partials/dealer-groups/porsche/map-row');
  return ob_get_clean();
}

//REGISTER SHORTCODES
function register_shortcodes()
{
  add_shortcode('full-map', 'full_map');
}

add_filter('di_shiftdigital_form_mapping', function ($formMapping) {
  $formMapping[3] = ['shift_id' => 481, 'abort_email' => false, 'custom' => false];
  $formMapping[22] = ['shift_id' => 479, 'abort_email' => true, 'custom' => false];
  unset($formMapping['14']);
  unset($formMapping['15']);
  unset($formMapping['16']);
  return $formMapping;
});

// Legacy Form Migration Shift Mappings Admin Notice
add_action('admin_notices', function () {
  $screen = get_current_screen();
  if ($screen->id != 'dealer-inspire_page_dealerinspire-shift-digital') {
    return;
  }
  ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e(
          'This site has a special form mapping for Shift Digital; it does not use the standard 16 forms.',
          'dealer-theme',
        ); ?></p>
    </div>
    <?php
});

add_action('header_right_oem_logo', function () {
  if (get_field('vessel_header_image', 'option')): ?>
        <img id="vessel-header-img" src="<?= get_field('vessel_header_image', 'option') ?>" alt="Custom Header Image">
     <?php endif;
});

add_action('vrp_listview_pricing_bottom_text', function () {
  global $inventoryFrontend;

  //Black Friday
  if (
    is_in_black_friday_window() &&
    DIFunctions::is_inventory_page('new') &&
    $inventoryFrontend->vehicle->year == 2018
  ): ?>

        <div id="bf-disclaimer">2 year complimentary prepaid maintenance</div>

    <?php endif;
});
//00249444 - OEM plugin default image placeholder is overriding the custom placeholder image. This undos that so the custom placeholder image for this dealership will show instead of the
add_action('vehicle_pre_save', function ($vehicle) {
  $placeholderImage = get_option('im_placeholder_image');
  if ($vehicle->__image_count < 1 && !empty($placeholderImage)) {
    $vehicle->images = [$placeholderImage];
  }

  return $vehicle;
});

function cpo_pdf_urls($vehicle)
{
  foreach (['MSRP', 'Carfax', 'CPO'] as $type) {
    $key = sprintf('%s_pdf_url', str_replace('-', '_', strtolower($type)));

    $regex = '^(.*)' . strtolower($type) . '[_|-]' . strtolower($vehicle['stock']) . '(.*)$';
    $args = [
      'post_type' => 'attachment',
      'post_mime_type' => 'application/pdf',
      'post_status' => 'inherit',
      'posts_per_page' => '1',
      'meta_query' => [
        [
          'key' => '_wp_attached_file',
          'value' => $regex,
          'compare' => 'REGEXP',
        ],
      ],
    ];
    $query_images = new WP_Query($args);
    foreach ($query_images->posts as $image) {
      if (isset($image->guid) && !empty($image->guid)) {
        $vehicle[$key] = $image->guid;
      }
    }
    wp_reset_postdata();
  }

  return $vehicle;
}

function vrp_options_cta()
{
  global $inventoryFrontend;
  $vehicle = $inventoryFrontend->vehicle;
  if (!isset($vehicle['factory_options']) || empty($vehicle['factory_options'])) {
    return;
  }
  $html =
    '<div trid="f41f15e729704628a35340" trc class="button primary-button block options-button" data-toggle="modal" data-target="#DIModal" data-modal-content="#vrp-vehicle-packages-' .
    $vehicle['vin'] .
    '" data-modal-title="' .
    $vehicle['title'] .
    ' Options" data-modal-footer="hide">' .
    do_shortcode('[di_svg name="gear"]') .
    'View Options</div><div id="vrp-vehicle-packages-' .
    $vehicle['vin'] .
    '" style="display:none;"><ul>';

  foreach ($vehicle['factory_options'] as $package) {
    if (
      isset($package['name']) &&
      !empty($package['name']) &&
      !in_array($package['name'], [
        'ADDITIONAL EQUIPMENT',
        'PRIMARY PAINT',
        'SEAT TYPE',
        'SEAT TRIM',
        'WHEELS',
        'SEAT VENTILATION',
      ])
    ) {
      $html .= '<li>' . $package['name'] . '</li>';
    } elseif (isset($package['description']) && !empty($package['description'])) {
      $html .= '<li>' . $package['description'] . '</li>';
    }
  }

  $html .= '</ul></div>';

  echo $html;
}
