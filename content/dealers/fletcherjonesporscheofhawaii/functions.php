<?php

// ACTIONS
add_action('wp_enqueue_scripts', 'load_child_scripts');
add_action('wp_print_scripts', 'override_js');
add_action( 'init', 'register_shortcodes');

// FILTERS
add_filter('vdp_link_url_variables', 'dealer_theme_vdp_url_keys');
add_filter('google_font_list', 'dealer_theme_google_fonts');
add_filter('di_hotwheels_gallery_path', function ($path) {
    return 'partials/vdp/project-hotwheels/vehicle-gallery-condensed';
});

// INCLUDES

// add make-specific vehicle styles
function load_child_scripts()
{
    if (function_exists('load_vehicle_sprites')) {
        load_vehicle_sprites(array(
           'porsche-menu'
        ));
    }

    wp_register_style('swiper-css','https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css');
    wp_enqueue_style('swiper-css');

    wp_register_script('swiper-js',get_template_directory_uri() . '/includes/js/swiper/swiper.jquery.min.js', ['jquery'], null, true);
    wp_enqueue_script('swiper-js');

    wp_register_style('porschefont',get_template_directory_uri() . '/css/dealer-groups/porsche/porsche-fonts.css');
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
    return array(
        'type',
        'year',
        'make',
        'model',
        'trim',
        'drivetrain',
        'body',
        'vin'
    );
}

//Shared Functions
include_once(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/porsche/porsche-functions.php');

//CREATE FULL MAP SHORTCODE
function full_map() {
  ob_start();
  get_template_part('/partials/dealer-groups/porsche/map-row');
  return ob_get_clean();
}

//REGISTER SHORTCODES
function register_shortcodes(){
  add_shortcode('full-map', 'full_map');
}

add_filter('di_shiftdigital_form_mapping', function($formMapping){
    $formMapping[3] = ['shift_id' => 481,'abort_email'=>false,'custom'=>false];
    $formMapping[22] = ['shift_id' => 479,'abort_email'=>true,'custom'=>false];
    unset($formMapping['14']);
    unset($formMapping['15']);
    unset($formMapping['16']);
    return $formMapping;
});

// Legacy Form Migration Shift Mappings Admin Notice
add_action( 'admin_notices', function(){
    $screen = get_current_screen();
    if ($screen->id != 'dealer-inspire_page_dealerinspire-shift-digital') return;

    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'This site has a special form mapping for Shift Digital. It does not use the standard 16 forms.', 'dealer-theme' ); ?></p>
    </div>
    <?php
});
