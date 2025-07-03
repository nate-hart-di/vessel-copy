<?php
require_once WP_CONTENT_DIR . '/themes/DealerInspireDealerTheme/includes/acf/homepage-youtube-acf.php';

// add make-specific vehicle styles
function load_child_scripts()
{
  if (function_exists('load_vehicle_sprites')) {
    load_vehicle_sprites(['porsche-menu']);
  }
}
add_action('wp_enqueue_scripts', 'load_child_scripts');

add_filter('google_font_list', function ($fonts) {
  $fonts[] = 'Lato:100,300,400,500,700';
  return $fonts;
});

function override_js()
{
  wp_dequeue_script('custom');
}
add_action('wp_print_scripts', 'override_js');

/*
 *  Pull in shared FJ_Functions class
 */
require_once WP_CONTENT_DIR .
  '/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/shared-functions.php';
// Create a new instance of the class
FJ_Functions::instance();
// end of shared functions

//  Change VRP and VDP CTA labels to "GET E-PRICE"
add_action('im_vrp_main_cta', function ($cta_buttons) {
  global $inventoryFrontend;

  if ($inventoryFrontend->data['vehicle']['special_field_1'] == 'S') {
    //if the same label applies to both CPO and used vehicles use this instead
    if (
      strpos($inventoryFrontend->data['vehicle']['type'], 'Used') !== false &&
      !empty($inventoryFrontend->data['vehicle']['our_price']) &&
      is_numeric($inventoryFrontend->data['vehicle']['our_price'])
    ) {
      $cta_buttons[$inventoryFrontend->data['vehicle']['type']]['listview']['label'] = 'GET E-PRICE';
    }
  }
  return $cta_buttons;
});

add_action('im_vdp_main_cta', function ($cta_buttons) {
  global $inventoryFrontend;
  if ($inventoryFrontend->data['vehicle']['special_field_1'] == 'S') {
    //if the same label applies to both CPO and used vehicles use this instead
    if (
      strpos($inventoryFrontend->data['vehicle']['type'], 'Used') !== false &&
      !empty($inventoryFrontend->data['vehicle']['our_price']) &&
      is_numeric($inventoryFrontend->data['vehicle']['our_price'])
    ) {
      $cta_buttons['used']['label'] = 'GET E-PRICE';
    }
  }
  return $cta_buttons;
});

// Index a list of Partial VINs for the vehicle.
add_filter('algolia_inventory_fields', function ($fields) {
  if (!in_array('partial_vins', $fields)) {
    $fields[] = 'partial_vins';
  }
  return $fields;
});

// Build the list of Partial VINs to be indexed.
add_filter(
  'algolia_pre_save_objects',
  function ($objects, $indexName) {
    $filtered_objects = [];

    if (stripos($indexName, 'inventory') === false) {
      return $objects;
    }

    foreach ($objects as $v) {
      $partial_vins = [];
      for ($a = 8; $a <= strlen($v['vin']); $a++) {
        $partial_vins[] = substr($v['vin'], $a * -1);
      }
      $v['partial_vins'] = $partial_vins;
      $filtered_objects[] = $v;
    }

    return $filtered_objects;
  },
  10,
  2,
);

add_filter(
  'vrp_sorting_options_array',
  function ($options) {
    foreach ($options as $option => $data) {
      if ($data['key'] == 'images') {
        unset($options[$option]);
      }
    }
    return $options;
  },
  10,
  1,
);

require_once __DIR__ .
  '/../../../../../themes/DealerInspireCommonTheme/includes/plugins/HomepageBackgroundImageOverrides/HomepageBackgroundImageOverrides.php';
(new \DICommonTheme\HomepageBackgroundImageOverrides())->setMainBackgroundImageMobile('#videobanner');
