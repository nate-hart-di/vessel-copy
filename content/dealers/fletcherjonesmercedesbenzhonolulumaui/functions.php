<?php
add_filter('acf/get_field_group', 'show_categories_on_di_composer_pages');

add_filter('di_common_svg_dirs','custom_svgs', 20, 1);
function custom_svgs($dirs){
    return array_merge($dirs,array(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher') );
}

add_action('wp_enqueue_scripts', function() {
    if (function_exists('load_vehicle_sprites')) {
        load_vehicle_sprites(array(
            'mercedes-menu',
            'sprinter-menu'
        ));
    }

});

add_action('content_after_eqs', function(){ echo '<div class="ev-model-range">Range: 350<sup>†</sup> miles</div>'; });
add_action('content_after_eqb', function(){ echo '<div class="ev-model-range">Range: 245<sup>†</sup> miles</div>'; });
add_action('content_after_eqs_suv', function(){ echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>'; });
add_action('content_after_eqe', function(){ echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>'; });
add_action('content_after_eqe_suv', function(){ echo '<div class="ev-model-range">Range: 279<sup>†</sup> miles</div>'; });

add_filter('google_font_list', function($fonts) {
    $fonts[] = 'Lato:100,300,400,700,900';
    return $fonts;
});

add_filter('script_loader_tag',function($tag) {
    // array of scripts to defer
    $scripts_to_defer = array();
    foreach($scripts_to_defer as $defer_script) {
        if(true == strpos($tag, $defer_script ))
            $tag = str_replace( ' src', ' defer="defer" src', $tag );
    }
    // array of scripts to async
    $scripts_to_async = array();
    foreach($scripts_to_async as $async_script) {
        if(true == strpos($tag, $async_script ))
            $tag = str_replace( ' src', ' async="async" src', $tag );
    }
    return $tag;
}, 10, 2);

add_action('init', 'add_categories_to_pages');

add_action('wp_print_scripts', function() {
    wp_dequeue_script('custom');
});

add_action('vehicle_pre_save', function($vehicle) {
    if($vehicle->type != "New") {
        $last_digit = substr($vehicle->our_price, -1);
        $end_digits = array(2,3);

        if(in_array($last_digit, $end_digits))
            $vehicle->special_field_1 = "S";

    }
    if(!in_array($vehicle->model,['Sprinter Crew Van', 'Sprinter Cargo Van','Sprinter Cargo Vans','Sprinter Minivan','Sprinter Passenger Van','Sprinter Passenger Vans','Sprinter Crew Vans','Sprinter Cab Chassis','Metris Cargo Van','Metris Cargo Vans','Metris Minivan','Metris Passenger Van','Metris Passenger Vans','Metris Crew Vans','Metris Cab Chassis']))
        return $vehicle;


    $real_images = array_filter($vehicle->images, function ($image_url) {

        return isStockImage($image_url) === false;

    });
	$vehicle->setImages($real_images);

	$thumbnail = empty($real_images) ? InventorySettings::get('im_placeholder_image') : $real_images[0];
    $vehicle->setThumbnails([$thumbnail]);

    return $vehicle;
}, 1, 1);
function isStockImage($image_url)
{
    return preg_match('/stock|media.carbook|carshot|d31ufzz2yw5eti\.cloudfront\.net|stock-images|chrome|media.chromedata.com/i', $image_url) > 0;
}

// Index a list of Partial VINs for the vehicle.
add_filter('algolia_inventory_fields', function($fields) {
    if(!in_array('partial_vins', $fields)) {
        $fields[] = 'partial_vins';
    }
    return $fields;
});

// Build the list of Partial VINs to be indexed.
add_filter('algolia_pre_save_objects', function($objects, $indexName) {
    $filtered_objects = array();

    if(stripos($indexName, 'inventory') === FALSE) {
        return $objects;
    }

    foreach($objects as $v) {
        $partial_vins = array();
        for($a = 8; $a <= strlen($v['vin']); $a++) {
            $partial_vins[] = substr($v['vin'], $a * -1);
        }
        $v['partial_vins'] = $partial_vins;
        $filtered_objects[] = $v;
    }

    return $filtered_objects;
}, 10, 2);

add_filter('algolia_inventory_synonyms', function($syns) {
    $syns[] = array('GT S','GTS');
    return $syns;
});

// disabled due to client currently not using mb model/trim
// include_once(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/mbusa/mbusa-functions.php');

add_filter('vrp_sorting_options_array', function($options) {
    foreach($options as $option => $data) {
        if($data['key'] == "images")
            unset($options[$option]);

    }
    return $options;
}, 10, 1);

add_action('vrp_listview_pricing_bottom_text', function() {
    global $inventoryFrontend;

    //End of year disclaimer
    if (is_in_end_of_year_window()
        && eoy_model_check(strtolower($inventoryFrontend->vehicle->model))
        && DIFunctions::is_inventory_page('new')
        && $inventoryFrontend->vehicle->year == 2018): ?>

        <div id="eoy-disclaimer">2 Month Payment Waiver!*</div>

    <?php endif;
});

/* Mobile Redevelopments */
// CREATE mobile footer nav menu
register_nav_menus( array(
    'mobile-footer-menu' => 'Mobile Footer Menu',
    'mobile-header-menu' => 'Mobile Header Menu',
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
add_action( 'init', 'register_shortcodes');

//=====================================================
// FUNCTIONS ADDED FOR NEW DESKTOP REDESIGN 06/20
//=====================================================
function scroll_reveal() {
    wp_enqueue_script( 'scrollreveal', plugin_dir_url( __FILE__ ) . '/js/min/scrollreveal.min.js', array( 'jquery' ), '', true );
}
add_action('wp_enqueue_scripts', 'scroll_reveal');


//======================================================
// OVERWRITE LEAD ROUTING TO DELAER ONLY FOR ALL FORMS
//======================================================
function mb_shift_override($formMapping)
{
    foreach( $formMapping as $form_id=>$mapping ){
        $formMapping[ $form_id ] = ['shift_id' => '', 'abort_email' => false, 'custom' => false];
    }
    return $formMapping;
}

add_filter('di_shiftdigital_form_mapping', 'mb_shift_override', 99999, 1);

function mb_shift_notes($notes)
{
    $notes[] = "All forms are overridden to be Dealer";
    return $notes;
}

add_filter('di_shift_digital_dealer_form_functionality_changes', 'mb_shift_notes', 11, 1);

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
                        <span class="post-image"><a trid="4b26cfec27514b0882606c" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail( $id, array('auto',50)) ?></a></span>
                    <?php } ?>
                    <h3><a trid="c6c14278735e429e8c2d7a" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
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

add_action('mb_additional_phone_number', function(){
    ?>
        |<span class="phone"> Parts: <?php echo do_shortcode('[di_phone option_key="parts" format="withparens" clickable="true"]'); ?> </span>
    <?php
});

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