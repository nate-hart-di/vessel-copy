<?php
// Actions
add_action('wp_enqueue_scripts', 'load_child_scripts');
add_action('wp_footer', 'add_mixpanel_events');
add_action('gform_after_submission', 'add_mixpanel_form_data', 10, 2);
add_action('im_keyword_search_replace_array', 'inventory_search_synonyms');
add_action('vehicle_pre_save', 'cpo_pdf_urls');
add_action('init', 'register_shortcodes');
add_action('init', 'add_categories_to_pages');
add_action('content_after_eqs', function () {
  echo '<div class="ev-model-range">Range: 350<sup>†</sup> miles</div>';
});
add_action('content_after_eqb', function () {
  echo '<div class="ev-model-range">Range: 245<sup>†</sup> miles</div>';
});
add_action('content_after_eqs_suv', function () {
  echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>';
});
add_action('content_after_eqe', function () {
  echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>';
});
add_action('content_after_eqe_suv', function () {
  echo '<div class="ev-model-range">Range: 279<sup>†</sup> miles</div>';
});

function custom_svgs($dirs)
{
  return array_merge($dirs, [WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher']);
}

// Filters
add_filter('google_font_list', 'enqueue_google_fonts');
add_filter('algolia_inventory_synonyms', 'homepage_search_synonyms');
add_filter('vdp_video_position', 'vdp_video_index_position', 10, 2);
add_filter('di_flexslider_lazy_load', 'lazy_load_flexslider_images');
add_filter('di_common_svg_dirs', 'custom_svgs', 20, 1);
add_filter('acf/get_field_group', 'show_categories_on_di_composer_pages');
//Includes
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/partials/hours/closed-hours-text/closed-hours-text.php';

//=====================================================
// FUNCTIONS ADDED FOR NEW DESKTOP REDESIGN 06/20
//=====================================================
function scroll_reveal()
{
  wp_enqueue_script('scrollreveal', plugin_dir_url(__FILE__) . '/js/min/scrollreveal.min.js', ['jquery'], '', true);
}
add_action('wp_enqueue_scripts', 'scroll_reveal');

/* Mobile Redevelopments */
// CREATE mobile footer nav menu
register_nav_menus([
  'mobile-footer-menu' => 'Mobile Footer Menu',
  'mobile-header-menu' => 'Mobile Header Menu',
  'mobile-menu' => 'Mobile Menu',
]);

//CREATE MOBILE CTA CAROUSEL SHORTCODE
function mobile_carousel()
{
  ob_start();
  get_shared_mobile_template('mobile-carousel');
  return ob_get_clean();
}

//CREATE MOBILE SINGLE CTA SHORTCODE
function mobile_cta()
{
  ob_start();
  get_shared_mobile_template('mobile-cta');
  return ob_get_clean();
}

//REGISTER SHORTCODES
function register_shortcodes()
{
  add_shortcode('mobile-carousel', 'mobile_carousel');
  add_shortcode('mobile-cta', 'mobile_cta');
  add_shortcode('show-posts', 'fj_show_posts');
}

// Async Google font loader
function enqueue_google_fonts($fonts)
{
  $fonts[] = 'Montserrat:300,400,500,700,800';
  return $fonts;
} // eof: enqueue_google_fonts()

function add_mixpanel_events()
{
  if (DIFunctions::is_inventory_page() === true) {
    $output = '';
    $output .= "<script>\n";
    $output .=
      "jQuery(document).ready(function($){jQuery(window).load(function () { if(typeof mixpanel != 'undefined'){\n";

    if (DIFunctions::is_inventory_page('new') === true) {
      $output .= "mixpanel.track('VRP Page Visit - New');\n";
    } else {
      $output .= "mixpanel.track('VRP Page Visit - Used');\n";
    }

    $output .= "mixpanel.track_links('.vehicle .vehicle-image a', 'VRP vehicle image click');\n";
    $output .= "mixpanel.track_links('.vehicle .primary-cta .cta-button', 'VRP get e-price button');\n";
    $output .= "if ( typeof jQuery === 'function') {\n";
    $output .=
      "    jQuery('.vehicle .btn-customize-lease').on('click', function(e) { mixpanel.track('VRP customize lease button'); });\n";
    $output .=
      "    jQuery('.vehicle .price-leaseandfinance .finance').on('click', function(e) { mixpanel.track('VRP finance amount'); });\n";
    $output .=
      "    jQuery('.vehicle .price-leaseandfinance .leasepayment').on('click', function(e) { mixpanel.track('VRP lease amount'); });\n";
    $output .= "}}\n";
    $output .= "});});\n";
    $output .= "</script>\n";

    echo $output;
  }
} // eof: add_mixpanel_events()

///// Mixpanel Gravity Forms Handling /////

function add_mixpanel_form_data($entry, $form)
{
  $submitted_data = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'phone' => '',
  ];

  foreach ($form['fields'] as $field) {
    if ($field['type'] == 'honeypot') {
      // Skip honeypot fields.
      continue;
    }

    switch ($field['label']) {
      case 'First Name':
        $submitted_data['first_name'] = rgar($entry, $field['id']);
        break;
      case 'Last Name':
        $submitted_data['last_name'] = rgar($entry, $field['id']);
        break;
      case 'Name':
        if (isset($field->inputs) && !empty($field->inputs)) {
          $submitted_data['first_name'] = rgar($entry, $field['inputs'][0]['id']);
          $submitted_data['last_name'] = rgar($entry, $field['inputs'][1]['id']);
        }
        break;
      case 'Phone':
        $submitted_data['phone'] = rgar($entry, $field['id']);
        break;
      case 'Email':
      case 'E-mail':
      case 'E-Mail':
        $submitted_data['email'] = rgar($entry, $field['id']);
        break;
      default:
        break;
    }
  }

  $profile = [
    '$email' => $submitted_data['email'],
    '$first_name' => $submitted_data['first_name'],
    '$last_name' => $submitted_data['last_name'],
    '$phone' => $submitted_data['phone'],
    '$created' => date('c'),
  ];
  setcookie('mixpanel_people_profile', json_encode($profile), 0, '/');
} // eof: add_mixpanel_form_data()

//MBUSA functions file commented out - client not using mb model/trim
// include_once(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/mbusa/mbusa-functions.php');

//FD #13289
function inventory_search_synonyms($keywords_list)
{
  $keywords_list[] = [
    'find' => ' class',
    'replace' => '-class',
  ];
  return $keywords_list;
} // eof: inventory_search_synonyms()

function homepage_search_synonyms($syns)
{
  $syns[] = ['GT S', 'GTS'];
  return $syns;
} // eof: hompage_search_synonyms()

function vdp_video_index_position($position, $vehicle)
{
  $position = 1;
  return $position;
} // eof: vdp_video_index_position()

//Lazy Load
function lazy_load_flexslider_images()
{
  return false;
} // eof: lazy_load_flexslider_images()

//    ===============================================================================
//    Raw File Includes
//    ===============================================================================

//// Pull in shared FJ_Functions class
//require_once(WP_CONTENT_DIR.'/themes/DealerInspireCommonTheme/includes/dealer-groups/fletcher-jones/shared-functions.php');
//// Create a new instance of the class
//FJ_Functions::instance();

//    ===============================================================================
//    Dealer Specific
//    ===============================================================================

add_action('inventory_search_object_pre_find', function ($search_object) {
  global $inventoryFrontend;
  if ($inventoryFrontend->action == 'im_ajax_call' && !empty($search_object->search_term)) {
    if (stripos($search_object->search_term, 'cars') !== false) {
      $search_object->search_term = trim(str_ireplace('cars', 'sedan', $search_object->search_term));
    }

    if (stripos($search_object->search_term, 'with special') !== false) {
      $search_object->search_term = trim(str_ireplace('with special', '', $search_object->search_term));
      $search_object->special_field_1 = 'S';
    }
  }
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

//Case 35673
add_action('vrp_sorting_options_array', function ($sorting_options_array) {
  //Remove 'Number of Images' (both) Sorting
  foreach ($sorting_options_array as $elementKey => $element) {
    foreach ($element as $valueKey => $value) {
      if ($valueKey == 'key' && $value == 'images') {
        unset($sorting_options_array[$elementKey]);
      }
    }
  }

  return $sorting_options_array;
});

add_filter('algolia_inventory_synonyms', function ($syns) {
  $syns[] = ['GT S', 'GTS'];
  return $syns;
});

add_filter('get_vehicle_array', function ($vehicle) {
  $executive_arr = ['48491', '48540', '50279'];
  if (in_array($vehicle['stock'], $executive_arr)) {
    $vehicle['our_price'] = "Please Call for Manager's Special!";
    $vehicle['our_price_label'] = '';
  }
  return $vehicle;
});

add_filter('comment_moderation_recipients', 'add_additional_notification_email', 11, 2);
add_filter('comment_notification_recipients', 'add_additional_notification_email', 11, 2);
function add_additional_notification_email($emails, $comment_id)
{
  $emails[] = 'kperez@fletcherjones.com';
  return $emails;
}

add_action('vrp_listview_pricing_bottom_text', function () {
  global $inventoryFrontend;

  //End of year disclaimer
  if (
    is_in_end_of_year_window() &&
    eoy_model_check(strtolower($inventoryFrontend->vehicle->model)) &&
    DIFunctions::is_inventory_page('new') &&
    $inventoryFrontend->vehicle->year == 2018
  ): ?>

        <div id="eoy-disclaimer">2 Month Payment Waiver!*</div>

    <?php endif;
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

// enable categories on pages
function add_categories_to_pages()
{
  register_taxonomy_for_object_type('category', 'page');
}

// Show category taxononomy on di composer pages
function show_categories_on_di_composer_pages($group)
{
  if ($group['key'] != 'group_554d290c123aa') {
    return $group;
  }

  $hide_on_screen = $group['hide_on_screen'];
  $group['hide_on_screen'] = array_diff($hide_on_screen, ['categories']);

  return $group;
}

//Override show posts shortcode
function fj_show_posts($atts, $content = null)
{
  extract(
    shortcode_atts(
      [
        'category' => '',
        'posts' => '3',
        'excerpt' => 'true',
        'date' => 'true',
        'thumbnail' => 'false',
        'text' => 'light',
        'post_type' => 'post',
      ],
      $atts,
    ),
  );
  $args = [
    'post_type' => explode(',', $post_type),
    'posts_per_page' => $posts,
    'orderby' => 'date',
    'order' => 'DESC',
    'category_name' => $category,
  ];
  $query = new \WP_Query($args);
  if ($query->have_posts()) {
    ob_start(); ?>

        <ul class="<?= $post_type ?> posts list-unstyled clearfix <?= ($thumbnail == 'true' ? 'withThumbnail ' : '') .
   ($text != 'light' ? $text : '') ?>">
            <?php while ($query->have_posts()):

              $query->the_post();
              $id = get_the_id();
              ?>

                <li class="post">
                    <?php
                    if ($date == 'true' && $thumbnail == 'false') { ?>
                        <span class="post-date"><?= get_the_date() ?></span>
                    <?php }
                    if ($thumbnail == 'true') { ?>
                        <span class="post-image"><a trid="27daadd37a8b42309570bd" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail(
  $id,
  ['auto', 50],
) ?></a></span>
                    <?php }
                    ?>
                    <h3><a trid="32375270b976491499df8a" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
                    <?php
                    if ($date == 'true' && $thumbnail == 'true') { ?>
                        <span class="post-date"><?= get_the_date() ?></span>
                    <?php }
                    if ($excerpt == 'true') { ?>
                        <p><?= get_the_excerpt() ?></p>
                    <?php }
                    ?>
                </li>
            <?php
            endwhile; ?>
        </ul>

        <?php $output = ob_get_clean();
  } else {
    $output = '<h3>No posts found at this time.</h3>';
  }

  wp_reset_postdata();

  return $output;
} // show_posts shortcode

add_action('wp_enqueue_scripts', 'dequeue_frontpage_scripts', 999);
function dequeue_frontpage_scripts()
{
  if (is_front_page()) {
    wp_deregister_script('new-royalslider-main-js');
    wp_dequeue_script('new-royalslider-main-js');

    wp_deregister_script('recaptcha_v3_script');
    wp_dequeue_script('recaptcha_v3_script');

    wp_deregister_script('metroTween');
    wp_dequeue_script('metroTween');

    wp_deregister_script('metroPackery');
    wp_dequeue_script('metroPackery');

    wp_deregister_script('metroJS');
    wp_dequeue_script('metroJS');

    wp_deregister_script('gforms_character_counter');
    wp_dequeue_script('gforms_character_counter');

    wp_deregister_script('new-royalslider-main-js');
    wp_dequeue_script('new-royalslider-main-js');

    wp_deregister_style('recaptcha_v3_style');
    wp_dequeue_style('recaptcha_v3_style');

    wp_deregister_script('flexslider_js');
    wp_dequeue_script('flexslider_js');

    wp_deregister_style('di-srp-layout-stylesheet');
    wp_dequeue_style('di-srp-layout-stylesheet');

    wp_deregister_style('new-royalslider-core-css');
    wp_dequeue_style('new-royalslider-core-css');

    wp_deregister_style('inventory-css');
    wp_dequeue_style('inventory-css');
  }
}
