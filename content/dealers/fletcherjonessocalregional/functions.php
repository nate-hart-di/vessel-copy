<?php

//  ACTIONS
add_action('init', 'fj_register_shortcodes');
add_action('acf/init', 'register_blog_css_fields');
add_action('wp_footer','di_archives_shortcode_js',10);
add_action('wp_enqueue_scripts', 'load_child_scripts');
add_action('vehicle_pre_save', 'add_horsepower_to_inventory', 100, 1);
add_action('vehicle_pre_save', 'add_trademark_to_amg', 11, 1);
add_action('vdp_modals', 'add_location_info_to_vdps');
add_action('wp_print_scripts', 'override_js');
add_action('wp_head', 'header_blog_css', 10);
add_action('get_vehicle_array',function($vehicle){
	//Case #00042739 - Only show packages that have a price
	$vehicle['factory_options'] = array_filter($vehicle['factory_options'],function($option){
		return ! empty($option['price']);
	});
	
	return $vehicle;
});

//  FILTERS
add_filter('google_font_list', 'dealer_theme_google_fonts');
add_filter('vdp_print_address', 'print_vehicle_location', 2, 10);
add_filter('dealer_listing_cta_labels', 'add_apply_today_cta_label', 10, 1);
add_filter('dealer_listing_output', 'modify_listing_output', 10, 2);
add_filter('im_filter_vdp_mainvehicleheaderbox_end', 'add_popover_to_vdp', 10, 2);
add_filter('di_hotwheels_gallery_path', 'vdp_gallery_path');
add_filter('di_hotwheels_show_lightbox_gallery', 'turn_off_lightbox_on_hotwheels');

//  SHORTCODES
function fj_register_shortcodes()
{    
    add_shortcode('di_get_archives','di_get_archives_shortcode');
    add_shortcode('show-posts', 'fj_show_posts');
}

// add make-specific vehicle styles
function load_child_scripts()
{
    wp_register_style('swiper-css', get_template_directory_uri() . '/includes/js/swiper/swiper.min.css');
    wp_enqueue_style('swiper-css');
    wp_register_script('swiper-js', get_template_directory_uri() . '/includes/js/swiper/swiper.jquery.min.js', ['jquery'], null, true);
    wp_enqueue_script('swiper-js');

}

function dealer_theme_google_fonts($fonts)
{
    $fonts[] = 'Lato:100,300,400,500,700';
    $fonts[] = 'Montserrat:ital,300,400,500,700,800';
    return $fonts;
}

function override_js()
{
    wp_dequeue_script('custom');
}

register_sidebars(1,array(
	'name'          => 'Locations Tab',
	'id'            => "locations-tab",
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<span class="widgettitle">',
	'after_title'   => '</span>' ));

register_sidebars(1,array(
	'name'          => 'Phone Tab',
	'id'            => "phone-tab",
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<span class="widgettitle">',
	'after_title'   => '</span>' ));
	
register_sidebar(array(
    'name'  => 'New Vehicle Menu',
    'id'    => "new-menu-sidebar",
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<span class="widgettitle">',
    'after_title'   => '</span>' )
);

register_sidebar(array(
    'name'  => 'Pre-Owned Vehicle Menu',
    'id'    => "used-menu-sidebar",
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<span class="widgettitle">',
    'after_title'   => '</span>' )
);

register_sidebar(array(
    'name'  => 'Special Offers Sidebar',
    'id'    => "special-menu-sidebar",
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<span class="widgettitle">',
    'after_title'   => '</span>' )
);

register_sidebar(array(
    'name'  => 'Fiannce Menu',
    'id'    => "finance-menu-sidebar",
    'before_widget' => '<div class="widget">',
    'after_widget'    => '</div>',
    'before_title'    => '<span class="widgettitle">',
    'after_title'     => '</span>' )
);

register_sidebar(array(
    'name'  => 'Service Menu',
    'id'    => "service-menu-sidebar",
    'before_widget' => '<div class="widget">',
    'after_widget'    => '</div>',
    'before_title'    => '<span class="widgettitle">',
    'after_title'     => '</span>' )
);

register_sidebar(array(
    'name'	=> 'About Menu',
    'id'    => "about-menu-sidebar",
    'before_widget' => '<div class="widget">',
    'after_widget'    => '</div>',
    'before_title'    => '<span class="widgettitle">',
    'after_title'     => '</span>' )
);

register_nav_menus( array(
  'quick-links'=>'Quick Links'
));


function print_vehicle_location($text, $v)
{
  echo '<div style="font-size:18px;">'.$v['Location'].'</div>';
}


// Create link for contact mobile tab
if (class_exists('DIMobileTab_Link')){
	class DIMobileTab_ContactLink extends DIMobileTab_Link {
			protected $link = '/contact/';
			protected $glyph = 'earphone';
			protected $path = 'link';
			protected $target = '_self';

		public function get_label(){
			return __('Contact');
		}
	}
}

function add_horsepower_to_inventory($vehicle)
{
  // Set horsepower to vehicle data for use on the front end (FD#25929)
  $vehicle->horsepower = "";
  if(isset($vehicle->tech_options) && !empty($vehicle->tech_options)) {
    $tech_opts = $vehicle->tech_options;
    $has_horsepower = false;
    foreach($tech_opts as $option) {
      if(stripos(strtolower($option), "horsepower") !== false) {
        $has_horsepower = $option;
      }
    }
    if($has_horsepower !== false) {
      $horsepower = explode(":", $has_horsepower);
      $horsepower = explode("@", $horsepower[1]);
      $horsepower = trim($horsepower[0]);
      $vehicle->horsepower = $horsepower;
    }
  }
	$apiID = $vehicle->api_id;
	$location = get_site_link_for_dealership($vehicle);
	if($apiID == 'FJAudiBeverlyHills') {
		$vehicle->VRP_link = '<a trid="d15f5067030d47a58a6993" trc target="_new" class="vehicle-location-link" href="'. rtrim($location['url'], "/").'/all-inventory/index.htm?search='.$vehicle->vin.'">'.$location['name'].'<br/>'.$location['phone'].'</a>';
	}
	else {
		$vehicle->VRP_link = '<a trid="440c3723ca624d66bb98fe" trc target="_new" class="vehicle-location-link" href="'.rtrim($location['url'], '/').'/new-vehicles/#action=im_ajax_call&perform=get_results&show_all_filters=true&vin[]='.$vehicle->vin.'">'.$location['name'].'<br/>'.$location['phone'].'</a>';
	}
}

function add_trademark_to_amg($vehicle)
{
	foreach(['model','trim'] as $keys)
	{
		if( preg_match("/amg(?:\s|$)/i", $vehicle->$keys ) === 1 )
		{
			$vehicle->$keys = preg_replace("/(amg)(?:\s|$)/i", "$1® ", $vehicle->$keys);
		}
	}
}

function get_site_link_for_dealership( $vehicle ) 
{
	if(is_object($vehicle)) {
		$api_id = $vehicle->api_id;
	}
	else {
		$api_id = $vehicle['api_id'];
	}
	if ( empty($api_id) || !isset($api_id) ){
        return false;
    }
    $args = array(
        'post_type' => 'dealers',
        'meta_query' => array(
            array(
            'key' => '_dealer_id',
            'value' => $api_id
            ),
        ),
        'posts_per_page' => 1
    );

    $dealer = get_posts($args);

    if(!is_array($dealer) || count($dealer) === 0){
        return false;
    }
    
    $post_id = $dealer[0]->ID;
  
    if(isset($post_id) && !empty($post_id)) {
        return array(
            "name" => get_the_title($post_id),
            "url" => get_field('_dealer_website_url', $post_id),
            "phone" => get_field('_dealer_sales_phone', $post_id),
            "address" => str_replace("|", "<br />", get_field('_dealer_address', $post_id))
        );
    }
    return false;
}

function add_popover_to_vdp( $value, $vehicle ){
	$location = get_site_link_for_dealership($vehicle);

	if ( isset($location['name']) && !empty($location['name']) )
	{
		return "<div class='popover-container'><a trid='da6706c093764698989b81' trc role='button' data-toggle='popover' data-trigger='click' data-placement='top' href='#dealer-location-popover' class='btn btn-small btn-default' id='dealer-location-popover-trigger' rel='button'>{$location['name']}</a></div>";
	}
}

function add_location_info_to_vdps( $vehicle )
{    
    $location = get_site_link_for_dealership($vehicle);
  
	if ( isset($location['name']) ):
	$address = $location['address'];
	$phone = $location['phone'];
	$google_url = '//www.google.com/maps/dir/current+location/' . urlencode( strip_tags($address) ); ?>
	
	<div id="dealer-location-popover" class="hidden">
		<div class="row location-popover-wrap">
			<div class="col-md-7">
				<span class="dealer-name"><?= $location['name']; ?></span>

			<?php if ( !empty($address) ): ?>
				<span class="dealer-address">
					<a trid="4a66ebde03b2417c818a57" trc href="<?= $google_url ?>" target="_blank" title="View Directions"><?= $address ?></a>
				</span>
			<?php endif; ?>
			</div>

			<div class="col-md-5">
			<?php if ( !empty($phone) ): ?>
				<span class="dealer-phone"><?= $phone; ?></span>
			<?php endif; ?>

			<?php if ( $location['url'] !== false && !empty($location['url']) ): ?>
				<a trid="3ee4a3d6b9864930ad8411" trc class="btn btn-sm btn-block btn-primary" target="_blank" href="<?= $location['url']; ?>">Visit Site <i class="fa fa-external-link"></i></a>
			<?php endif; ?>
			</div>
		</div>
	</div>
	<script>
		jQuery(document).ready(function($) {
			$('#dealer-location-popover-trigger').popover({
				// container: 'body',
				content: $('#dealer-location-popover').html(),
				html: true,
				placement: 'top',
				trigger: 'click',
				title: 'Dealership Location Info <a href="#" class="popover-close pull-right" aria-label="Close Popup">&times;</a>'
			}).on('show.bs.popover', function() {
				// Make sure the popover does not overflow the container, but also has enough space for the inner html
				$(this).data('bs.popover').tip().css({'max-width': '90%', 'width': '400px'});
			}).on('shown.bs.popover', function() {
				var self = this;
				// close the popover on close button click
				$(self).data('bs.popover').tip().find('.popover-close').on('click', function (e) {
					e.preventDefault();
					$(self).popover('hide');
				});
			});
		});
	</script>
	<?php endif; ?>
<?php }
  
function add_apply_today_cta_label($labels)
{
  $labels['finance'] = "Apply Today";
  return $labels;
}

/*
 * Grab the xTime URLs from the Collision URL fields
 * on Dealers posts and return as an array with find/add associations
 * @return array if shortcode uses "Service" links, else false
 */
function get_xTime_URLs()
{
    $args = array(
        'post_type' => 'dealers',
        'posts_per_page' => -1
    );
    
    $locations = get_posts($args);
    $xTime = array();
    
    if(!empty($locations) && count($locations) > 0) {
        foreach($locations as $i => $dealer)
        {
            $post_id = $dealer->ID;
            if(get_field('_dealer_collision_url', $post_id)) {
                $xTime[] = array(
                    'find' => 'href="' . get_field('_dealer_service_url', $post_id) . '"',
                    'add' => ' data-mobile-url="' . get_field('_dealer_collision_url', $post_id) . '"'
                );
            }
        }
        return $xTime;
    }
    return false;
} // eof: get_xTime_URLs()

/*
 * Function to append a brief JS to handle the xTime URLs opening on mobile
 * instead of the default service URL in the href attribute
 * @return HTML string
 */
function mobile_xTime_script()
{
    ob_start(); ?>
    <script id="custom-dealer-listing" type="text/javascript">
        jQuery(document).ready(function($){
            if($(window).width() < 768) {
                $('body').on('click', '.dealer-links a[data-mobile-url]', function(e) {
                    e.preventDefault();
                    var url = jQuery(this).data("mobile-url");
                    window.open(url,'_new');
                    return false;
                });   
            }
        });
    </script>
    
    <?php
    $js = ob_get_clean();
    return $js;
} // eof: mobile_xTime_script()

/*
 * Get boolean if current shortcode is using Service links
 * @param $atts the original, unmodified attributes passed to the [dealer_listing] shortcode
 *
 * @return boolean
 */
function query_dealers_atts($atts)
{
    if(is_array($atts)) {
        foreach($atts as $key => $val)
        {
            if(stripos(strtolower($val), 'service') !== false) {
                return true;
            }
        }
        return false;
    }
} // eof: query_dealers_atts()

/*
 * Filter the output on the [dealer_listing /] shortcode
 * @location plugins/di-dealers/di-dealers.php
 *
 * @param $output string of html for full dealer_listing shortcode output
 * @param $atts array attributes passed to the shortcode instance
 *
 * @return string html
 */
function modify_listing_output($output, $atts)
{
    $is_service = query_dealers_atts($atts);
    if(get_xTime_URLs() && $is_service) {
        // The xTime URLs from the dealers posts
        $xTime = get_xTime_URLs();
        // Go through each xTime link found and update the data attributes for mathcing HREFs on the service URL
        foreach($xTime as $link)
        {
            $find = $link['find'];
            $replace = $link['find'] . $link['add'];
            $output = str_replace($find, $replace, $output);
        }
        return $output = $output . mobile_xTime_script();
    }
    return $output;
}

// use "condensed" image gallery on HotWheels VDP

function vdp_gallery_path($path)
{
    $path = 'partials/vdp/project-hotwheels/vehicle-gallery-condensed';
    return $path;
}

function turn_off_lightbox_on_hotwheels($boolean)
{
    $boolean = false;
    return $boolean;
}

/*
    [di_get_archives]
    shortcode takes no inputs yet, outputs archive posts, listed monthly when <1 year old, then yearly 
    requires di_archives_shortcode_js()
*/
function di_get_archives_shortcode ($atts)
{
    $wpdb = $GLOBALS['wpdb'];
    $archive_results_html = '';

    $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date)
    FROM $wpdb->posts WHERE post_status = 'publish'
    AND post_type = 'post' ORDER BY post_date DESC");
    if(isset($years)){
    $archive_results_html .= '<span class="widgettitle" >Archives</span>';
    $archive_results_html .= '<ul>';
    foreach($years as $year) :

    $archive_results_html .= '<li><a trid="89a73c1cb51f4fab91a71c" trc href="#">'.$year.'</a>';

    $is_hidden = (date('Y') == $year) ? '">'  : ' hidden">';

    $archive_results_html.= '<ul class="archive-sub-menu-'.$year.$is_hidden;

        $months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date)
        FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'
        AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");
        foreach($months as $month) :

          $month_link = get_month_link($year, $month);
          $link_date = date( 'F', mktime(0, 0, 0, $month) );
          $archive_results_html .= '<li><a trid="b8cc5b8bb81d48979141ea" trc href="'.$month_link.'"><span>'.$link_date.'</span></a></li>';

        endforeach;

    $archive_results_html.= '</ul>';

    $archive_results_html.= '</li>';

    endforeach;

    $archive_results_html .= '</ul>';
    }
    return $archive_results_html;
}

function di_archives_shortcode_js()
{
    ?>
        <script>
        jQuery(function($){
            $("#di_archives_widget > ul > li > a").click(function(e){
                e.preventDefault();
                var clickedYear = $(this).text();
                var targetSubMenu = ".archive-sub-menu-"+clickedYear;
                $(targetSubMenu).toggleClass("hidden");
            });
        });
        </script>
    <?php
}

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
                'text' => 'light'
            ),
            $atts
        )
    );
    $args = array (
        'post_type' => 'post',
        'posts_per_page' => $posts,
        'orderby' => 'date',
        'order' => 'DESC',
        'category_name' => $category
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        ob_start(); ?>

    <ul class="posts list-unstyled clearfix <?= ($thumbnail =="true" ? 'withThumbnail ' : '') . ($text != "light" ? $text : "") ?>">
        <?php while ($query->have_posts()) : $query->the_post();
            $id = get_the_id(); ?>

            <li class="post">
            <?php if ($date == 'true' && $thumbnail == "false") { ?>
                <span class="post-date"><?= get_the_date() ?></span>
            <?php }
            if ($thumbnail == 'true') { ?>
                <span class="post-image"><a trid="9fc33e24500c4bcf8242e2" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail( $id, array('auto',50)) ?></a></span>
            <?php } ?>
            <h3><a trid="5a6b5f61199b4d59ac626c" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
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
}

function register_blog_css_fields()
{
   if ( function_exists('acf_add_local_field_group') ) {

        $blog_css = array (
        	'key' => 'group_5866e0c85e05e',
        	'title' => 'Custom CSS',
        	'fields' => array (
        		array (
        			'key' => 'field_5866e0db4a639',
        			'label' => 'Blog CSS',
        			'name' => 'blog_css',
        			'type' => 'acf_code_field',
        			'instructions' => 'Place your custom post-related CSS here.	Please be wary of global classes and ID\'s that may be in use in the header and footer DOM on these pages.<br><b>Do not include the &lt;style&gt; tags.</b>',
        			'required' => 0,
        			'conditional_logic' => 0,
        			'wrapper' => array (
        				'width' => '',
        				'class' => '',
        				'id' => '',
        			),
        			'default_value' => '',
        			'placeholder' => '',
        			'mode' => 'css',
        			'theme' => 'monokai',
        		),
        	),
        	'location' => array (
        		array (
        			array (
        				'param' => 'post_type',
        				'operator' => '==',
        				'value' => 'post',
        			),
                ),
                array(
        			array (
        				'param' => 'page_type',
        				'operator' => '==',
        				'value' => 'posts_page',
        			),
        		),
        	),
        	'menu_order' => 0,
        	'position' => 'normal',
        	'style' => 'default',
        	'label_placement' => 'top',
        	'instruction_placement' => 'label',
        	'hide_on_screen' => '',
        	'active' => 1,
        	'description' => '',
        );

        acf_add_local_field_group($blog_css);
    }
}

function header_blog_css()
{
    global $post;
    $css = false;

    if (isset($post) && is_singular('post')) {
        $css = get_field("blog_css", $post->ID);
    } elseif ($_SERVER['REQUEST_URI'] == "/blog/") {
        $blog_page = get_option('page_for_posts');
        $css = get_field('blog_css', $blog_page);
    }
    
    if($css) {
        echo "<style id='custom-blog'>" . $css . "</style>";
    }
    
}

add_filter('comment_moderation_recipients', 'add_additional_notification_email', 11, 2);
add_filter('comment_notification_recipients', 'add_additional_notification_email', 11, 2);
function add_additional_notification_email($emails, $comment_id) {
  $emails[] = 'kperez@fletcherjones.com';
  return $emails;
}

//00062845 - Add inquire CTA to GT & G-Class
add_action('vrp_listview_pricing_bottom_text', 'vrp_inquire_cta');
function vrp_inquire_cta() {
    $frontend = $GLOBALS['inventoryFrontend'];
    if ($frontend->data['vehicle']['model'] == 'G-Class' || $frontend->data['vehicle']['model'] == 'G-CLASS' || $frontend->data['vehicle']['model'] == 'AMG® GT') {
        ?>
<div id="inquire-button">
            <a trid="fd5f3e6744634c1da71ba5" trc href="#inquire-modal" class="inquire button cta-button lightbox fancybox">Inquire</a>
            <div id="inquire-modal" style="display: none;">
                <?php gravity_form(38, true, false, false, '', false); ?>
            </div>
        </div>
        <?php
    }
}
add_action('hotwheels_below_cta_box','vdp_inquire_cta');
function vdp_inquire_cta() {
    $frontend = $GLOBALS['inventoryFrontend'];
    if ($frontend->data['vehicle']['model'] == 'G-Class' || $frontend->data['vehicle']['model'] == 'G-CLASS' || $frontend->data['vehicle']['model'] == 'AMG® GT') {
        ?>
<div id="inquire-button">
            <a trid="0e4afd6fb14d4bcda1b790" trc href="#inquire-modal" class="inquire button cta-button lightbox fancybox">Inquire</a>
            <div id="inquire-modal" style="display: none;">
                <?php gravity_form(38, true, false, false, '', false); ?>
            </div>
        </div>
        <?php
    }
}
//00062845 - Add class to GT & G-Class to hide the main CTA
add_filter('vehicle_classes_attribute', 'add_class_to_specific_models', 10, 3);
function add_class_to_specific_models($classes, $view, $vehicle) {
    if ($vehicle['model'] == 'G-Class' || $vehicle['model'] == 'G-CLASS' || $vehicle['model'] == 'AMG® GT') {
        $classes[] = 'hide-the-main-cta';
    }
    return $classes;
}

//Remove Porsche from /new-vehicles/southern-california/
add_action('wp_head', function() {
    if (IMFunctions::is_vrp() && strpos($_SERVER['REQUEST_URI'], 'southern')) {
        $GLOBALS['posts'][0]->post_title = str_replace('Porsche, ', '', $GLOBALS['posts'][0]->post_title);
        $GLOBALS['posts'][0]->post_title = str_replace('Sprinter', '', $GLOBALS['posts'][0]->post_title);
        $GLOBALS['posts'][0]->post_title = str_replace('Audi,', 'Audi', $GLOBALS['posts'][0]->post_title);
    }
});

// SC 00499523 - Custom search
add_filter('inventory_search_object_pre_find', function ($search) {
    if (!empty($search->search_term) && (strtolower($search->search_term) == 's63' || strtolower($search->search_term) == 's 63')) {
        $search->reset();
        $search->trim = [
            'AMG® GLS 63 4MATIC SUV',
            'AMG® S 63 4MATIC Sedan',
            'AMG® S 63',
            'AMG® GLS 63',
            'AMG® CLS 63 S',
            'AMG® S 63 4MATIC+ Cabriolet',
            'AMG® S 63 4MATIC+ Sedan',
        ];
    }
});

include_once WP_CONTENT_DIR.'/themes/DealerInspireCommonTheme/includes/plugins/InventoryDisplay/SortBuilder.php';

add_filter('inventory-display-vrp-sorter', function($sorts){
    $mapping1 = new SortBuilder_Mapping(1, array('key'=>'make', 'value'=>'Mercedes-Benz'));
    $mapping2 = new SortBuilder_Mapping(1, array('key'=>'make', 'value'=>'Audi'));
    $mapping3 = new SortBuilder_Mapping(1, array('key'=>'make', 'value'=>'Porsche'));

    $group = new SortBuilder_GroupBy('sort_make', 'asc', 2, $mapping1, $mapping2, $mapping3);
    
    $order = new SortBuilder_OrderBy('our_price', 'asc'); 
    
    // Builds a sort, All Buick Enclaves first, then any other Buicks, then all other vehicles, sorted by price from low to high
    $sorts['oem_price_sort'] = SortBuilder_BuildSort("MB/Audi/Porsche First, Priced Low to High", "", $group, $order);
    return $sorts;
});

add_action('wp_footer',function(){
   if(method_exists('\DIFunctions', 'is_vehicle_page') && \DIFunctions::is_vehicle_page()) : ?>
    <div id="schedule-test-drive" class="hidden-all">
        <?= do_shortcode( '[gravityform id="7" name="Schedule Test Drive" title="false" description="true" field_values="model_year={year}&make={make}&model={model}&trim={trim}&vin={vin}&link={link}&stock={stock}&type={type}&our_price={our_price}&original_price={original_price}&dealer_id={dealer_id}" ]' ) ?>
    </div>
    <?php elseif( !is_front_page() ) : ?>
    <div id="schedule-test-drive" class="hidden-all">
        <?= do_shortcode( '[gravityform id="7" name="Schedule Test Drive" title="false" description="true" ]' ) ?>
    </div> <!-- end #schedule-test-drive -->
    <?php endif;
} );

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

    }
}