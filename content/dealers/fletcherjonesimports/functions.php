<?php
// add make-specific vehicle styles
function load_child_scripts()
{
  if (function_exists('load_vehicle_sprites')) {
  }

  wp_enqueue_script('carcodesms', 'https://www.carcodesms.com/widgets/808.js', null, null, true);

  //Loading MB Corpo S font
  wp_register_style(
    'mercedesfont',
    get_template_directory_uri() . '/css/dealer-groups/mercedes-benz/mercedes-benz-fonts-canada.css',
  );
  wp_enqueue_style('mercedesfont');
}

// Actions

add_action('wp_footer', 'add_mixpanel_events');
add_action('gform_after_submission', 'add_mixpanel_form_data', 10, 2);
add_action('im_keyword_search_replace_array', 'inventory_search_synonyms');
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

// Filters
add_filter('google_font_list', 'enqueue_google_fonts');
add_filter('algolia_inventory_synonyms', 'homepage_search_synonyms');
add_filter('vdp_video_position', 'vdp_video_index_position', 10, 2);
add_filter('di_flexslider_lazy_load', 'lazy_load_flexslider_images');
add_filter('di_common_svg_dirs', 'custom_svgs', 20, 1);
add_filter('acf/get_field_group', 'show_categories_on_di_composer_pages');

function custom_svgs($dirs)
{
  return array_merge($dirs, [WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher']);
}

//Includes
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/partials/hours/closed-hours-text/closed-hours-text.php';
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/vrp-vdp-hover/vrp-pricing-overlay.php';

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

function override_js()
{
  wp_dequeue_script('custom');
} // eof: override_js()

function add_mixpanel_events()
{
  if (DIFunctions::is_inventory_page() === true) {
    $output = '';
    $output .= "<script>\n";
    $output .= "jQuery(window).load(function () {\n";
    $output .= "if( typeof mixpanel !== 'undefined' ) {\n";

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
    $output .= "}\n";
    $output .= "}});\n";
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

// Pull in shared FJ_Functions class
//require_once(WP_CONTENT_DIR.'/themes/DealerInspireCommonTheme/includes/dealer-groups/fletcher-jones/shared-functions.php');
// Create a new instance of the class

// disabled due to not using mb trim/models
// include_once(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/mbusa/mbusa-functions.php');

//    ===============================================================================
//    Dealer Specific
//    ===============================================================================

add_action('inventory_search_object_pre_find', function ($search) {
  /* @var InventorySearch $search */
  if (!empty($search->search_term)) {
    if (stripos($search->search_term, 'cabriolet') !== false) {
      $search->search_term = str_replace('cabriolet', '', $search->search_term);
      $search->bodytype = ['Convertible'];
    }
    if (stripos($search->search_term, 'e 300') !== false || stripos($search->search_term, 'e300') !== false) {
      $search->search_term = str_replace(['e', '300'], '', $search->search_term);
      $search->model = ['E-Class'];
      $search->trim = ['E 300 Sport', 'E 300 Luxury'];
    }
  }
});

add_filter('comment_moderation_recipients', 'add_additional_notification_email', 11, 2);
add_filter('comment_notification_recipients', 'add_additional_notification_email', 11, 2);
function add_additional_notification_email($emails, $comment_id)
{
  $emails[] = 'kperez@fletcherjones.com';
  return $emails;
}

//00062845 - Add inquire CTA to GT & G-Class

//00062845 - Add class to GT & G-Class to hide the main CTA
add_filter('vehicle_classes_attribute', 'add_class_to_specific_models', 10, 3);
function add_class_to_specific_models($classes, $view, $vehicle)
{
  if (strtolower($vehicle['model']) == 'g-class' || $vehicle['model'] == 'AMG® GT') {
    $classes[] = 'hide-the-main-cta';
  }
  return $classes;
}

add_filter(
  'im_vrp_filter_array',
  function ($rows, $key) {
    if (strtolower($key) == 'model') {
      foreach ($rows as $model => $value) {
        if (strpos($model, 'Van') !== false) {
          unset($rows[$model]);
          $rows[$model] = $value;
        }
      }
    }
    return $rows;
  },
  10,
  2,
);

// SC 00114851
add_filter('algolia_vehicle_types', function ($types) {
  return [['type:New', 'type:Pre-Owned', 'type:Certified Pre-Owned']];
});

function add_metris_cta()
{
  global $inventoryFrontend;

  $vehicle = $inventoryFrontend->data['vehicle'];

  if ($vehicle['retired_courtesy_vehicle'] == true || $vehicle['type'] === 'New') {
    ob_start(); ?>

        <a trid="f2b17d794be4417eba02b8" trc href="#" class="button block cta-button lease-for-less button-primary">GET YOUR LEASE OFFER NOW</a>

        <?php echo ob_get_clean();
  }
}

add_action('vrp_botttom_of_pricing_top', 'add_metris_cta');

add_action('wp_footer', function () {
  global $inventoryFrontend;

  if (!empty($inventoryFrontend->data) && array_key_exists('vehicle', $inventoryFrontend->data)) {
    $vehicle = $inventoryFrontend->data['vehicle'];

    if ($vehicle['retired_courtesy_vehicle'] == true || $vehicle['type'] === 'New') { ?>
            <script>
              jQuery(document).ready(function($){
                $('#ctabox-lease-now').show();
                $('#ctabox-lease-now').click(function() {
                  $('.shopping-tool.icons-box.lease-box.get-your-lease-offer-now a')[0].click();
                });
              });
            </script>
            <style>
                .shopping-tool.icons-box.lease-box.get-your-lease-offer-now {
                    display: none;
                }
            </style>
            <?php }
  }
});

add_action('vrp_listview_pricing_bottom_text', function () {
  global $inventoryFrontend;

  if (
    is_in_black_friday_window() &&
    DIFunctions::is_inventory_page('new') &&
    $inventoryFrontend->vehicle->year == 2018 &&
    strpos(strtolower($inventoryFrontend->vehicle->model), 'gla') &&
    strpos(strtolower($inventoryFrontend->vehicle->stock), 'cx')
  ): ?>

        <div id="bf-disclaimer">Lease for $299 or 0 down and lease for $399</div>

    <?php elseif (
    is_in_black_friday_window() &&
    DIFunctions::is_inventory_page('new') &&
    $inventoryFrontend->vehicle->year == 2018 &&
    !strpos(strtolower($inventoryFrontend->vehicle->stock), 'cx')
  ): ?>

            <div id="bf-disclaimer">One month Payment Waiver on all 2018 models</div>

        <?php endif;?><a trid='ed3306b7de24484b83cc87' trc class='button primary-button block trade-link' href='/value-your-trade/'>Value Your Trade</a><?php
});

/** SC181037: Upload MSRP and CPO Forms to show on VDP */
add_action('get_vehicle_array', function ($vehicle) {
  global $wpdb;

  if (IMFunctions::is_vdp()) {
    foreach (['Carfax', 'CPO', 'MSRP'] as $type) {
      $query = <<<SQL
      SELECT `guid` FROM `%s`
      WHERE `post_type` = 'attachment' and `post_mime_type` = 'application/pdf' and `guid` LIKE '%%%s-%s.pdf'
      ORDER BY `ID` DESC
      LIMIT 1
      SQL;
      $key = sprintf('%s_pdf_url', str_replace('-', '_', strtolower($type)));

      $vehicle->$key = $wpdb->get_var(sprintf($query, $wpdb->posts, $type, strtoupper($vehicle['stock'])));
    }
  }

  return $vehicle;
});

add_action('get_vehicle_array', 'vrp_features', 99, 1);
function vrp_features($vehicle)
{
  // && is_array($vehicle['features'])
  if (property_exists($vehicle, 'features') && is_array($vehicle['features'])) {
    $temp = implode(', ', $vehicle['features']);
    if (strlen($temp) > 100) {
      $temp = substr($temp, 0, 100);
      $temp .= ' ... <a trid="9bd9ec10a0a848e1a57ce0" trc href="' . $vehicle['link'] . '">[more]</a>';
    }

    $vehicle['vrp_display_features'] = $temp;
  }
}

// SC 00347734 - Remove non Metris or Sprinter models from VRP model filter on Metris and Sprinter Inventory page
add_filter(
  'im_vrp_filter_array',
  function ($rows, $key) {
    global $post;
    if ($post->ID !== 38145 || strtolower($key) !== 'model') {
      return $rows;
    }

    foreach ($rows as $key => $model) {
      if (strpos($model['value'], 'Metris') === false && strpos($model['value'], 'Sprinter') === false) {
        unset($rows[$key]);
      }
    }

    return $rows;
  },
  10,
  2,
);

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
                        <span class="post-image"><a trid="c2bf899c51e7464292eabe" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail(
  $id,
  ['auto', 50],
) ?></a></span>
                    <?php }
                    ?>
                    <h3><a trid="1730276f21674f639f17b7" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
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

/**
 *  SC 00994403 - shared inventory sort
 */
add_action('vehicle_pre_save', function ($vehicle) {
  /** @var \Inventory\Vehicles\Entity\Vehicle $vehicle */
  $vehicle->las_vegas_sort = 99;

  if ($vehicle->getApiId() === 'FJMercedesLasVegas' && substr(strtoupper($vehicle->getStock()), -2) !== 'UX') {
    $vehicle->las_vegas_sort = 1;
  }
});

add_filter('inventory-display-vrp-sorter', function ($sorts) {
  $sorts['las_vegas_first_used'] = [
    'name' => 'Sort by Feed: FJMercedesLasVegas first for stocks ending with UX last',
    'userSortDisplay' => 'By Type',
    'rankings' => [
      [
        'key' => 'las_vegas_sort',
        'direction' => 'asc',
      ],
      [
        'key' => 'our_price',
        'direction' => 'asc',
      ],
    ],
  ];

  return $sorts;
});

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
