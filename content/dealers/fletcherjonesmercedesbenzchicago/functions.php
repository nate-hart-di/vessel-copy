<?php
// Actions
add_action('wp_enqueue_scripts', 'load_child_scripts');
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
add_filter('vdp_video_position', 'vdp_video_index_position', 10, 2);
add_filter('di_flexslider_lazy_load', 'lazy_load_flexslider_images');
add_filter('vehicle_pre_save', 'generateCustomShortCode', 10, 1);
add_filter('di_common_svg_dirs', 'custom_svgs', 20, 1);
add_filter('acf/get_field_group', 'show_categories_on_di_composer_pages');
add_filter('main_site_schema', 'replaceMainSiteSchema');

function custom_svgs($dirs)
{
  return array_merge($dirs, [WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher']);
}

// Raw File Includes

//Include MB USA functions file to solve issue with VRP search - problem: searching for GLC300 vs GLC 300 yielded different results
require_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/mbusa/mbusa-functions.php';
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/partials/hours/closed-hours-text/closed-hours-text.php';

// FUNCTIONS

//=====================================================
// FUNCTIONS ADDED FOR NEW DESKTOP REDESIGN 06/20
//=====================================================
function scroll_reveal()
{
  wp_enqueue_script('scrollreveal', plugin_dir_url(__FILE__) . '/js/min/scrollreveal.min.js', ['jquery'], '', true);
}
add_action('address_label', function () {
  ?>
    <b>Sales</b><br/>
    <?php
});
add_action('wp_enqueue_scripts', 'scroll_reveal');
function add_address()
{
  ?>
    <br/><b>Service</b><br/>949 North Elston Avenue, Suite 2 <br/>Chicago, IL, 60642
<?php
}
add_action('more_address_info', 'add_address', 10);
function add_directions()
{
  ?>
    <select id="select-location" class="selectBtn">
		<option value=''>Select Location</option>
		<option value='1520 W. North Avenue, Chicago, IL 60642'>Our Sales Location</option>
		<option value='949 N. Elston Avenue, Suite 2 Chicago, IL, 60642'>Our Service Location</option>
	</select>
    <script>
    jQuery("#select-location").change(function () {
        var x = jQuery(this).val();
        jQuery("#insert-location").val(x);
    });
    </script>
<?php
}
add_action('more_directions_info', 'add_directions', 10);
//=====================================================
// FUNCTIONS ADDED FOR NEW DESKTOP REDESIGN 06/20 - END
//=====================================================

/* Mobile Redevelopments 04/20 */
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

//FD #13289
function inventory_search_synonyms($keywords_list)
{
  $keywords_list[] = [
    'find' => ' class',
    'replace' => '-class',
  ];
  return $keywords_list;
} // eof: inventory_search_synonyms()

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

function generateCustomShortCode($vehicleObj)
{
  /** @var vehicle $vehicleObj */

  if ($vehicleObj->type == 'New') {
    return $vehicleObj;
  }

  $stockNumber = $vehicleObj->stock;
  if (preg_match('/^L.*[^aA]$/', $stockNumber)) {
    $vehicleObj->retired_courtesy_vehicle = 'true';
  }

  return $vehicleObj;
}

// Add button to executive inventory
add_action('vrp_listview_pricing_bottom_text', 'add_metris_cta');
add_action('pre_vdp_cta', 'add_metris_cta');

function add_metris_cta()
{
  global $inventoryFrontend;

  if (array_key_exists('vehicle', $inventoryFrontend->data)) {
    $vehicle = $inventoryFrontend->data['vehicle'];

    if ($vehicle['retired_courtesy_vehicle'] == true) {
      ob_start(); ?>

            <a trid="672486a97b254a8f82c1e2" trc href="#gravity-form-60" class="button block cta-button lease-for-less button-primary fancy">Click Here For Your Lease For Less Offer</a>

            <?php echo ob_get_clean();
    }
  }
}

add_action('wp_footer', function () {
  global $inventoryFrontend;

  if (array_key_exists('vehicle', $inventoryFrontend->data)) {
    $vehicle = $inventoryFrontend->data['vehicle'];
    $form_id = 60;
    echo sprintf(
      '<div id="gravity-form-%d" class="hidden-all metris-form">%s</div>',
      $form_id,
      gravity_form(
        $form_id,
        'Lease For Less',
        apply_filters('show_gravity_form_description_on_vdp', false),
        false,
        is_object($vehicle) ? $vehicle['json'] : $vehicle,
        false,
        1000,
        false,
      ),
    );
  }
});

add_action('vrp_listview_pricing_bottom_text', function () {
  global $inventoryFrontend;

  //Black Friday
  if (is_in_black_friday_window()): ?>

        <div id="bf-disclaimer"><?= $inventoryFrontend->data['vehicle']->{locked_pricing} ?></div>

    <?php endif;
});

add_action(
  'department_hours_closed_text',
  function ($m, $d, $day) {
    return 'Closed this ' . $day;
  },
  9,
  3,
);

add_action('bottom_mobile_content_tab', function () {
  ?>
    <div class="carWashHrs">
            <?php echo do_shortcode(
              '[di_display_open_hours departments="Preferred Owners Car Wash" class=dynamic-hours]',
            ); ?>
    </div>
    <?php
});

do_action('do_di_weather_script');

// SC 00461479 - Use MSRP as the algolia search price
add_filter('algolia_price_field', function ($val) {
  return 'msrp';
});

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
                        <span class="post-image"><a trid="6078622f4cf24a588785d5" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail(
  $id,
  ['auto', 50],
) ?></a></span>
                    <?php }
                    ?>
                    <h3><a trid="3d1398a22b574ca9842be4" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
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

add_action('before_fj_header_v2_address', function () {
  if (get_field('fj_service_street_address', 'option')) {
    echo 'Sales: ';
  }
});

add_action('after_fj_header_v2_address', function () {
  if (get_field('fj_service_street_address', 'option')) {
    $address =
      '<span>|</span>Service: <a trid="a8ac1d74736245ed915776" trc target="_blank" itemprop="directions" href="%s">%s • %s</a>';
    echo sprintf(
      $address,
      get_field('fj_service_google_map', 'option'),
      get_field('fj_service_street_address', 'option'),
      get_field('fj_service_city_state_zip', 'option'),
    );
  }
});

if (function_exists('acf_add_local_field_group')):
  acf_add_local_field_group([
    'key' => 'group_62e0191cef229',
    'title' => 'Service Address',
    'fields' => [
      [
        'key' => 'field_62e01a4941d41',
        'label' => 'Service Address',
        'name' => 'fj_service_street_address',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      [
        'key' => 'field_62e01ac641d42',
        'label' => 'City, State Zip',
        'name' => 'fj_service_city_state_zip',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
      [
        'key' => 'field_62e01adc41d43',
        'label' => 'Google Map',
        'name' => 'fj_service_google_map',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ],
    ],
    'location' => [
      [
        [
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'acf-options-vessel-settings',
        ],
      ],
    ],
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ]);
endif;

// Dequeue Yoast SEO Plugin Schema
function bybe_remove_yoast_json($data)
{
  $data = [];
  return $data;
}
add_filter('wpseo_json_ld_output', 'bybe_remove_yoast_json', 10, 1);
