<?php


add_filter('google_font_list', function($fonts) {
    $fonts[] = 'Lato:100,300,400,500,700';
    return $fonts;
});

function override_js()
{
    wp_dequeue_script('custom');
}
add_action('wp_print_scripts', 'override_js');

register_sidebars(1,array(
	'name'          => 'Phone Tab',
	'id'            => "phone-tab",
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<span class="widgettitle">',
	'after_title'   => '</span>' ));

function print_vehicle_location($text, $v){
  echo '<div style="font-size:18px;">'.$v['Location'].'</div>';
}

add_filter('vdp_print_address', 'print_vehicle_location', 2, 10);

// Create link for contact mobile tab
if (class_exists('DIMobileTab_Link')){
	class DIMobileTab_ContactLink extends DIMobileTab_Link {
			protected $link = '/contact-us/';
			protected $glyph = 'earphone';
			protected $path = 'link';
			protected $target = '_self';

		public function get_label(){
			return __('Contact');
		}
	}
}

require_once(WP_CONTENT_DIR . "/themes/DealerInspireDealerTheme/includes/php/FJAuto_Homepage.php");

require_once __DIR__ . '/../../../../../themes/DealerInspireCommonTheme/includes/plugins/HomepageBackgroundImageOverrides/HomepageBackgroundImageOverrides.php';
(new \DICommonTheme\HomepageBackgroundImageOverrides())
  ->setMainBackgroundImageMobile('#videobanner > #videooverlay');
register_sidebars(1,array(
    'name'          => 'Locations Tab',
    'id'            => "locations-tab",
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '<span class="widgettitle">',
    'after_title'   => '</span>' ));

add_action( 'wp_enqueue_scripts', 'my_deregister_javascript', 99999999999999999 );

function my_deregister_javascript() {
    if ( is_front_page() ) {
        wp_dequeue_script( 'di-dealer-places-map' );
        wp_deregister_script( 'di-dealer-places-map' );

        wp_dequeue_script( 'google-maps-api' );
        wp_deregister_script( 'google-maps-api' );
    }
}

/** SC00584652 - Remove inventory_sitemap from FJ main landing page */
add_action('wpseo_sitemap_index', function($sitemap_index){
    if (strpos($sitemap_index, 'inventory_sitemap') === false) {
        return $sitemap_index;
    }

    $pattern = <<<PATTERN
[<sitemap>
<loc>(.*)/dealer-inspire-inventory/inventory_sitemap</loc>
<lastmod>(.*)</lastmod>
</sitemap>
]
PATTERN;

    $sitemap_index = preg_replace($pattern, '', $sitemap_index);

    return $sitemap_index;
}, 11, 1);
/** end SC00584652 */