<?php
// Actions


add_action('im_keyword_search_replace_array', 'inventory_search_synonyms');
add_action('im_vdp_main_cta', 'dealer_theme_used_vdp_cta');
add_action('im_vrp_main_cta', 'dealer_theme_used_vrp_cta');
add_action('vehicle_pre_save', 'dealer_theme_description_space_fix');
add_action('vrp_listview_pricing_bottom_text','end_of_year_disclaimer');
add_action('vrp_listview_pricing_bottom_text','locked_pricing_vehicle_text');
add_action('vdp_pricing_bottom_text','vdp_pricing_locked_pricing_text',11,1);
add_action('vehicle_pre_save', array($this, 'inventory'), 11, 1);
add_action( 'init', 'register_shortcodes');
add_action('init', 'add_categories_to_pages');
add_action('content_after_eqs', function(){ echo '<div class="ev-model-range">Range: 350<sup>†</sup> miles</div>'; });
add_action('content_after_eqb', function(){ echo '<div class="ev-model-range">Range: 245<sup>†</sup> miles</div>'; });
add_action('content_after_eqs_suv', function(){ echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>'; });
add_action('content_after_eqe', function(){ echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>'; });
add_action('content_after_eqe_suv', function(){ echo '<div class="ev-model-range">Range: 279<sup>†</sup> miles</div>'; });

// Filters
add_filter('google_font_list', 'enqueue_google_fonts');
add_filter('algolia_inventory_synonyms', 'homepage_search_synonyms');
add_filter('vdp_video_position', 'vdp_video_index_position', 10, 2);
add_filter('di_flexslider_lazy_load', 'lazy_load_flexslider_images');
add_filter('algolia_pre_save_objects', 'dealer_theme_partial_vins', 10, 2);
add_filter('comment_moderation_recipients', 'add_additional_notification_email', 11, 2);
add_filter('comment_notification_recipients', 'add_additional_notification_email', 11, 2);
add_filter('fletcher_languages', 'add_languages');
add_action('vrp_botttom_of_pricing_top', 'add_metris_cta');
add_filter('vehicle_classes_attribute', 'add_class_to_locked_pricing_vehicles', 10, 3);
add_filter('di_common_svg_dirs','custom_svgs', 20, 1);
add_filter('acf/get_field_group', 'show_categories_on_di_composer_pages');

function custom_svgs($dirs){
  return array_merge($dirs,array(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher') );
}


//=====================================================
// FUNCTIONS ADDED FOR NEW DESKTOP REDESIGN 06/20
//=====================================================
function scroll_reveal() {
    wp_enqueue_script( 'scrollreveal', plugin_dir_url( __FILE__ ) . '/js/min/scrollreveal.min.js', array( 'jquery' ), '', true );
}
add_action('wp_enqueue_scripts', 'scroll_reveal');


//    ===============================================================================
//    Raw File Includes
//    ===============================================================================

// Pull in shared FJ_Functions class
//require_once(WP_CONTENT_DIR.'/themes/DealerInspireCommonTheme/includes/dealer-groups/fletcher-jones/shared-functions.php');
// Create a new instance of the class

/* Mobile Redevelopments */
// CREATE mobile footer nav menu
register_nav_menus( array(
    'mobile-footer-menu' => 'Mobile Footer Menu',
    'mobile-header-menu' => 'Mobile Header Menu',
    'mobile-menu' => 'Mobile Menu'
) );

//CREATE MOBILE CTA CAROUSEL SHORTCODE
function mobile_carousel() {
    ob_start();
    get_shared_mobile_template('mobile-carousel');
    return ob_get_clean();
}

//CREATE MOBILE SINGLE CTA SHORTCODE
function mobile_cta() {
    ob_start();
    get_shared_mobile_template('mobile-cta');
    return ob_get_clean();
}

//REGISTER SHORTCODES
function register_shortcodes(){
  add_shortcode('mobile-carousel', 'mobile_carousel');
  add_shortcode('mobile-cta', 'mobile_cta');
  add_shortcode('show-posts', 'fj_show_posts');
}

// add make-specific vehicle styles
function load_child_scripts()
{
    if (function_exists('load_vehicle_sprites')) {
    }
    wp_enqueue_script('child-script');


    //Loading MB Corpo S font
    wp_register_style('mercedesfont', get_template_directory_uri() . '/css/dealer-groups/mercedes-benz/mercedes-benz-fonts-canada.css');
    wp_enqueue_style('mercedesfont');
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

//FD #13289
function inventory_search_synonyms($keywords_list)
{
    $keywords_list[] = array(
        'find' => ' class',
        'replace' => '-class'
    );
    return $keywords_list;
} // eof: inventory_search_synonyms()

function homepage_search_synonyms($syns)
{
     $syns[] = array('GT S','GTS');
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

function dealer_theme_description_space_fix($vehicle)
{
    # temp fix re #38106
    if (strpos($vehicle->description, 'P latinum') !== false) {
        $vehicle->description = str_replace(array('P latinum', 'E xclusive'), array('Platinum', 'Exclusive'), $vehicle->description);
    }

    /** SC110608 - adding custom 'retired_courtesy_vehicle' vehicle variable */
    $firstChar = substr($vehicle->stock, 0, 1);
    $lastChar  = substr($vehicle->stock, -1);

    if ($firstChar === 'S' && preg_match('/[0-9]/',$lastChar) === 1) {
        $vehicle->retired_courtesy_vehicle = true;
    }
    /** end SC110608 */
}

 //  Change VRP and VDP CTA labels to "GET E-PRICE"
function dealer_theme_used_vrp_cta($cta_buttons)
{
    global $inventoryFrontend;
    //if the same label applies to both CPO and used vehicles use this instead
    if ($inventoryFrontend->data['vehicle']['type'] !== "New"
      &&
      (
        ( !is_numeric($inventoryFrontend->data['vehicle']['our_price']) )
        ||
        ( is_numeric($inventoryFrontend->data['vehicle']['our_price']) && $inventoryFrontend->data['vehicle']['our_price'] == 0)
      )
    ) {
        $cta_buttons[ $inventoryFrontend->data['vehicle']['type'] ]['listview']['label'] = 'GET E-PRICE';
        $cta_buttons[ $inventoryFrontend->data['vehicle']['type'] ]['listview']['form_id'] = '1';
        $cta_buttons[ $inventoryFrontend->data['vehicle']['type'] ]['gridview']['label'] = 'GET E-PRICE';
        $cta_buttons[ $inventoryFrontend->data['vehicle']['type'] ]['gridview']['form_id'] = '1';
    }
    return $cta_buttons;
}

function dealer_theme_used_vdp_cta($cta_buttons)
{
    global $inventoryFrontend;
    if ($inventoryFrontend->data['vehicle']['type'] !== "New"
      &&
      (
        ( !is_numeric($inventoryFrontend->data['vehicle']['our_price']) )
        ||
        ( is_numeric($inventoryFrontend->data['vehicle']['our_price']) && $inventoryFrontend->data['vehicle']['our_price'] == 0)
      )
    ) {
        $cta_buttons['used']['label'] = 'GET E-PRICE';
        $cta_buttons['used']['form_id'] = '1';
    }
    return $cta_buttons;
}

// Build the list of Partial VINs to be indexed.
function dealer_theme_partial_vins($objects, $indexName)
{
    $filtered_objects = array();

    if (stripos($indexName, 'inventory') === false) {
        return $objects;
    }

    foreach ($objects as $v) {
        $partial_vins = array();
        for ($a = 8; $a <= strlen($v['vin']); $a++) {
            $partial_vins[] = substr($v['vin'], $a * -1);
        }
        $v['partial_vins'] = $partial_vins;
        $filtered_objects[] = $v;
    }

    return $filtered_objects;
}

function add_additional_notification_email($emails, $comment_id)
{
    $emails[] = 'kperez@fletcherjones.com';
    return $emails;
}


// SC 00107893 - Set CVV true if stock begins with S and ends with a digit
add_action('vehicle_pre_save', function($vehicle){
    $vehicle->courtesy_vehicles = 'false';
    if(substr($vehicle->stock, 0, 1) === 'S' && ctype_digit(substr($vehicle->stock, -1, 1))){
        $vehicle->courtesy_vehicles = 'true';
    }
    return $vehicle;
});


function add_metris_cta()
{
    global $inventoryFrontend;

    $vehicle = $inventoryFrontend->data['vehicle'];

    if ($vehicle['retired_courtesy_vehicle'] == true || $vehicle['type'] === 'New') {
        ob_start(); ?>

        <a trid="7ca7c119ac114f55965c05" trc href="#" class="button block cta-button lease-for-less button-primary">GET YOUR LEASE OFFER NOW</a>

        <?php echo ob_get_clean();
    }
}


function end_of_year_disclaimer() {
    global $inventoryFrontend;

    //End of year disclaimer
    if (is_in_end_of_year_window()
        && eoy_model_check(strtolower($inventoryFrontend->vehicle->model))
        && DIFunctions::is_inventory_page('new')
        && $inventoryFrontend->vehicle->year == 2018): ?>

        <div id="eoy-disclaimer">2 Month Payment Waiver!*</div>

    <?php endif;
}

/** SC181037: Upload MSRP and CPO Forms to show on VDP */
add_action('get_vehicle_array',function($vehicle) {

    global $wpdb;

    if (IMFunctions::is_vdp())
    {
        foreach (['Carfax', 'CPO', 'MSRP'] as $type)
        {
            $query = <<<SQL
SELECT `guid` FROM `%s`
WHERE `post_type` = 'attachment' and `post_mime_type` = 'application/pdf' and `guid` LIKE '%%%s-%s.pdf'
ORDER BY `ID` DESC
LIMIT 1
SQL;
            $key = sprintf('%s_pdf_url', str_replace('-', '_', strtolower($type)));

            $vehicle->$key = $wpdb->get_var(sprintf($query,
                $wpdb->posts,
                $type,
                strtoupper($vehicle['stock'])
            ));
        }
    }

    return $vehicle;
});

//00196195 - Add class to new 2018's for their 'locked' pricing
function add_class_to_locked_pricing_vehicles($classes, $view, $vehicle) {
    if ($vehicle['type'] =='New' && $vehicle['year'] == '2018' ) {
        $classes[] = 'locked_pricing_vehicle';
    }
    return $classes;
}
//00196195 - Add class to new 2018's for their 'locked' pricing
function locked_pricing_vehicle_text() {
    global $inventoryFrontend;
    if ($inventoryFrontend->vehicle['type'] =='New' && $inventoryFrontend->vehicle['year'] == '2018' ) {
        ?><div class="locked-reveal-text"><span>8% off MSRP on all new 2018 models!</span>
        </div><?php
    }
}

function vdp_pricing_locked_pricing_text($vehicle){
    if ($vehicle['type'] =='New' && $vehicle['year'] == '2018' ) {
        ?><div class="locked-reveal-text"><span>8% off MSRP on all new 2018 models!</span>
        </div><?php
    }
}

add_filter('di_locked_pricing_price_selector', function($price_selectors, $obj) {
    $removeItems = '.new-vehicle #ctabox-pricing';
    if (($key = array_search($removeItems, $price_selectors)) !== false) {
        unset($price_selectors[$key]);
    }
    return $price_selectors;
},99,2);

function inventory($vehicle)
{
    $vehicle->horsepower = "";
    if (isset($vehicle->tech_options) && !empty($vehicle->tech_options))
    {
        $tech_opts = $vehicle->tech_options;
        $has_horsepower = false;
        foreach($tech_opts as $option)
        {
            if (stripos(strtolower($option), "horsepower") !== false)
            {
                $has_horsepower = $option;
            }
        }
        if ($has_horsepower !== false)
        {
            $horsepower = explode(":", $has_horsepower);
            $horsepower = explode("@", $horsepower[1]);
            $horsepower = trim($horsepower[0]);
            $vehicle->horsepower = $horsepower;
        }
    }
    $model = strtolower($vehicle->model);

    $modelArr = explode('-', $model);
    if (strlen($modelArr[0]) == 3 && isset($modelArr[1]) && strtolower($modelArr[1]) == "class" )
        $vehicle->model = $modelArr[0];

    switch($model)
    {
        case "sl":
            $vehicle->model = "SL-Class";
            break;

        case "m":
        case "ml":
        case "ml-class":
            $vehicle->model = "M-Class";
            break;

        case "gl":
            $vehicle->model = "GL-Class";
            break;

        case "b-class":
            $vehicle->chrome_trim = ( empty($vehicle->chrome_trim) ) ? "Electric Drive" : $vehicle->chrome_trim;
            break;
        case "gt":
        case "amg gt":
        case "amg® gt":
            $vehicle->model = "AMG® GT";
            break;
    }

    foreach(['model','trim'] as $keys)
    {
        if( preg_match("/amg(?:\s|$)/i", $vehicle->$keys ) === 1 )
        {
            $vehicle->$keys = preg_replace("/(amg)(?:\s|$)/i", "$1® ", $vehicle->$keys);
        }
    }

    if ($vehicle->make == "Smart") {
        $vehicle->make = "smart";
    }

    if (!class_exists("FJAutogravity") && isset($vehicle->autogravity_json))
        $vehicle->delete_meta("autogravity_json");

}

// SC 00389975 - Remove description from Factory Option 413
add_action('get_vehicle_array', function($vehicle){
    foreach ($vehicle->factory_options as &$factory_option) {
        if ($factory_option['option_code'] !== '413') {
            continue;
        }

        $factory_option['description'] = '';
    }
    return $vehicle;
});

// enable categories on pages
function add_categories_to_pages() {
    register_taxonomy_for_object_type( 'category', 'page' );
   }
   
// Show category taxononomy on di composer pages
function show_categories_on_di_composer_pages($group) {

    if ($group['key'] != 'group_554d290c123aa') {
        return $group;
    }

    $hide_on_screen = $group['hide_on_screen'];
    $group['hide_on_screen'] = array_diff($hide_on_screen, array('categories'));

    return $group;
   }

//Override show posts shortcode
function fj_show_posts( $atts , $content = null )
{
    extract(
        shortcode_atts(
            array(
                'category' => '',
                'posts' => '3',
                'excerpt' => 'true',
                'date' => 'true',
                'thumbnail' => 'false',
                'text' => 'light',
                'post_type' => 'post'
            ),
            $atts
        )
    );
    $args = array (
        'post_type' => explode(',', $post_type),
        'posts_per_page' => $posts,
        'orderby' => 'date',
        'order' => 'DESC',
        'category_name' => $category
    );
    $query = new \WP_Query($args);
    if ($query->have_posts()) {
        ob_start(); ?>

        <ul class="<?= $post_type; ?> posts list-unstyled clearfix <?= ($thumbnail =="true" ? 'withThumbnail ' : '') . ($text != "light" ? $text : "") ?>">
            <?php while ($query->have_posts()) : $query->the_post();
                $id = get_the_id(); ?>

                <li class="post">
                    <?php if ($date == 'true' && $thumbnail == "false") { ?>
                        <span class="post-date"><?= get_the_date() ?></span>
                    <?php }
                    if ($thumbnail == 'true') { ?>
                        <span class="post-image"><a trid="d639fdfb7431439aac42a1" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail( $id, array('auto',50)) ?></a></span>
                    <?php } ?>
                    <h3><a trid="6dc7bc5718474250bb6a88" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
                    <?php if ($date == 'true' && $thumbnail == "true") { ?>
                        <span class="post-date"><?= get_the_date() ?></span>
                    <?php }
                    if ($excerpt == 'true') { ?>
                        <p><?= get_the_excerpt() ?></p>
                    <?php } ?>
                </li>
            <?php endwhile; ?>
        </ul>

        <?php
        $output = ob_get_clean();
    } else {
        $output = "<h3>No posts found at this time.</h3>";
    }

    wp_reset_postdata();

    return $output;
} // show_posts shortcode

add_action('wp_enqueue_scripts','dequeue_frontpage_scripts',999);
function dequeue_frontpage_scripts(){
    if ( is_front_page() ) {

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