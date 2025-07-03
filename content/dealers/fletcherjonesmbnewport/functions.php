<?php

// ACTIONS
add_action('im_keyword_search_replace_array', 'inventory_search_synonyms');
add_action('vehicle_pre_save', 'dealer_theme_inventory_cleanup');
add_action('inventory_search_object_pre_find', 'search_terms_alias');
add_action('wp_footer', 'c_class_countdown',99);
//add_action('wp_footer','lightning_vehicle_finder');

add_action('content_after_eqs', function(){ echo '<div class="ev-model-range">Range: 350<sup>†</sup> miles</div>'; });
add_action('content_after_eqb', function(){ echo '<div class="ev-model-range">Range: 245<sup>†</sup> miles</div>'; });
add_action('content_after_eqs_suv', function(){ echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>'; });
add_action('content_after_eqe', function(){ echo '<div class="ev-model-range">Range: 305<sup>†</sup> miles</div>'; });
add_action('content_after_eqe_suv', function(){ echo '<div class="ev-model-range">Range: 279<sup>†</sup> miles</div>'; });

add_action('vrp_listview_pricing_bottom_text', 'vrp_inquire_cta');
add_action('hotwheels_below_cta_box','vdp_inquire_cta');
add_action('vrp_listview_pricing_bottom_text', 'pricing_bottom_text_customization');
add_action('wp_footer','vdp_lease_offer_js');
add_action('get_vehicle_array','cpo_pdf_urls');
add_action('vdp_pricing_bottom_text','vdp_pricing_locked_pricing_text',11,1);
add_action('vrp_listview_pricing_bottom_text','locked_pricing_vehicle_text');
add_action('init', 'register_shortcodes');
add_action('init', 'add_categories_to_pages');
add_filter('acf/get_field_group', 'show_categories_on_di_composer_pages');

// FILTERS
add_filter('google_font_list', 'enqueue_google_fonts');
add_filter('adf_vendor_id', 'shift_vendor_id', 10, 2);
add_filter('vdp_video_position', 'vdp_video_index_position', 10, 2);
add_filter('di_flexslider_lazy_load', 'lazy_load_flexslider_images');
add_filter('im_vrp_main_cta', 'swap_out_vrp_used_cta', 5);
add_filter('im_vdp_main_cta', 'swap_out_vdp_used_cta');
add_filter('algolia_inventory_fields', 'algolia_enable_partial_vins');
add_filter('algolia_pre_save_objects', 'algolia_partial_vins_to_index', 10, 2);
add_filter('get_vehicle_array','change_carfar_logo',99,1);
add_filter('comment_moderation_recipients', 'add_additional_notification_email', 11, 2);
add_filter('comment_notification_recipients', 'add_additional_notification_email', 11, 2);
add_filter( 'comment_form_defaults', 'comment_form_text');
add_filter('di_hotwheels_gallery_path','hot_wheels_path');
add_filter('vehicle_classes_attribute', 'add_class_to_specific_models', 10, 3);
add_filter('vehicle_classes_attribute', 'add_class_to_locked_pricing_vehicles', 10, 3);
add_filter('vehicle_classes_attribute', 'add_class_to_in_transit_vehicles', 10, 3);
add_filter('vehicle_classes_attribute', 'add_class_to_previous_loaner_vehicles', 10, 3);
add_filter('option_algolia_last_inv_update', '__return_false');
//add_filter('im_vdp_main_cta', 'c_class_lock_in_price_cta');
add_filter('wp_head', 'flip_chromedata_images');
//add_filter('disable_conversations', 'disable_conversations_globally', 999);
add_filter('di_common_svg_dirs','custom_svgs', 20, 1);
function custom_svgs($dirs){
  return array_merge($dirs,array(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/fletcher') );
}

// INCLUDES


//disabled due to client not using mb trim/model at this time
// include_once(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/oem/mbusa/mbusa-functions.php');
include_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/partials/hours/closed-hours-text/closed-hours-text.php';

// SIDEBARS

//=====================================================
// FUNCTIONS ADDED FOR NEW DESKTOP REDESIGN 06/20
//=====================================================
function scroll_reveal() {
    wp_enqueue_script( 'scrollreveal', plugin_dir_url( __FILE__ ) . '/js/min/scrollreveal.min.js', array( 'jquery' ), '', true );
}
add_action('wp_enqueue_scripts', 'scroll_reveal');


// Async Google font loader
function enqueue_google_fonts($fonts)
{
    $fonts[] = 'Montserrat:300,400,500,700,800';
    $fonts[] = 'Playfair+Display:400,700i';
    return $fonts;
} // eof: enqueue_google_fonts()



// Shift integration / customization
function shift_vendor_id($val, $form = null)
{
        return '05101';
} // eof: shift_vendor_id()

//FD #13289
function inventory_search_synonyms($keywords_list)
{
    $keywords_list[] = array(
        'find' => ' class',
        'replace' => '-class'
    );
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

//    ===============================================================================
//    Functions from their old site
//    ===============================================================================

function dealer_theme_inventory_cleanup($vehicle) {
 //show PANORAMA SUNROOF in packages filter
    if (!empty($vehicle->premium_options) && !empty($vehicle->packages) ) {
        if (in_array('Panorama Sunroof', $vehicle->packages) === false) {
            $has_panorama_sunroof = array_filter($vehicle->premium_options, function ($o) {
                return stripos($o, 'PANORAMA SUNROOF') !== false;
            });

            if (!empty($has_panorama_sunroof)) {
                $vehicle->packages[] = 'Panorama Sunroof';
            }
        }

        $packages = array(
        'PREMIUM 1 PACKAGE' => array(
            'PREMIUM 1 PACKAGE',
            'PREMIUM PACKAGE',
            'PREMIUM I PACKAGE'
        ),
        'PREMIUM 2 PACKAGE' => array(
            'PREMIUM 2 PACKAGE',
            'PREMIUM PACKAGE II'
        )
           );

        foreach ($packages as $package_name => $keywords) {
            $vehicle->packages = array_map(function ($p) use ($keywords, $package_name) {
                return in_array($p, $keywords) !== false ? $package_name : $p;
            }, $vehicle->packages);
        }
    }


    //Remove Rear Seat Image from
    if ($vehicle->type == 'New' && $vehicle->model == 'AMG® GT' && $vehicle->body =='Coupe' && $vehicle->year == 2017) {
        if (isset($vehicle->images)) {
            foreach ($vehicle->images as $index => $image) {
                if (stripos($image, 'dea98cb32104a729a34d68de0eca4127') !== false) {
                    unset($vehicle->images[$index]);
                }
            }
        }
    }

    // SC43108 - remove Multimedia Package from ! 2017 E-Class, issue w/ 3-year update in description
    if (!($vehicle->model == 'E-Class' && $vehicle->year == 2017) && is_array($vehicle->packages)) {
        $packages = $vehicle->packages;
        foreach ($packages as $key => $package) {
            if (stripos($package, 'Navigation Map Updates') !== false) {
                unset($packages[$key]);
            }
        }
        $vehicle->packages = $packages;
    }

    /** SC110608 - adding custom 'retired_courtesy_vehicle' vehicle variable */
    $firstChar = substr($vehicle->stock, 0, 2);
    $lastChar  = substr($vehicle->stock, -1);

    if ($firstChar === 'NL' && preg_match('/[0-9]/',$lastChar) === 1) {
        $vehicle->retired_courtesy_vehicle = true;
    }
    /** end SC110608 */
}

// Index a list of Partial VINs for the vehicle.
function algolia_enable_partial_vins($fields)
{
    // For handling Model/Trim combos (GT S)
    if (!in_array('search_title', $fields)) {
        array_unshift($fields, 'search_title');
    }

    if (!in_array('partial_vins', $fields)) {
        $fields[] = 'partial_vins';
    }
    return $fields;
}

// Build the list of Partial VINs to be indexed.
function algolia_partial_vins_to_index($objects, $indexName)
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

function is_stock_prefix($str)
{
    $str = strtolower($str);
    if (substr($str, 0, 1) == 'p') return true;
    if (substr($str, 0, 1) == 'n') return true;
    if (substr($str, 0, 2) == 'mp') return true;
    return false;
}

function search_terms_alias($s){

	/* @var InventorySearch $s */

	if(method_exists($s,'where') && ! empty($s->search_term))
	{
		$search_term = $s->search_term;

		if (!is_stock_prefix($search_term) && preg_match('/([a-zA-Z]{1,3})(?:\s|-)?(\d{2,3})/',$s->search_term,$matches))
		{
			//searching for Ford trucks?
			if(strtoupper($matches[1]) == 'F')
				return;

			$search_term = str_replace($matches[0],'',$s->search_term);
			$model = sprintf('%s%s',
				$matches[1],
				strlen($matches[1]) === 1 || strtoupper($matches[1]) === 'SL' ? '-class' : ''
			);
			$trim = sprintf('%s %d',$matches[1],$matches[2]);
		}
        elseif(stripos($search->search_term,'class') !== false)
            {
                $model = null;
                $modified_search_term = preg_replace_callback('/(?<=\s|^)(?<model>[a-zA-Z]{1,3})(?:\s{1,}|-)class(?=\s|$)/i',function($matches) use(&$model){
                    $model = sprintf('%s%s',
                        strtoupper($matches['model']),
                        strlen($matches['model']) == 1 ? '-Class' : ''
                    );

                    return '';
                },$search->search_term);
            }
        elseif($s->isSearchingFor('amg gt',false) || $s->isSearchingFor('gt amg',false))
        {
            $search_term = str_ireplace(['amg gt','gt amg'],'',$s->search_term);
            $model = ['AMG® GT','AMG GT'];
        }
        elseif($s->isSearchingFor('gt s',false) || $s->isSearchingFor('gts',false))
        {
			$search_term = str_ireplace(['gt s','gts'],'',$s->search_term);
            $trim = ['AMG® GT S','AMG GT S'];
        }

        if(empty($model) && empty($trim))
            return;

		if( ! empty($model))
        {
			$s->where('model',
                is_string($model) ? '=' : 'IN',
                $model
            );
        }

        if( ! empty($trim))
        {
            $s->where('trim',
                is_string($trim) ? 'LIKE' : 'IN',
                $trim
            );
        }

        $s->findByKeyword( trim($search_term) );

	}

}

function add_additional_notification_email($emails, $comment_id) {
  $emails[] = 'kperez@fletcherjones.com';
  return $emails;
}

function c_class_countdown() {

    if( $_SERVER['REQUEST_URI'] == '/mercedes-benz-c-class-overview/') :

        $search = new InventorySearch();
        $search->type = array("New");
        $search->model = array("c-class");
        $search->find();
        $vehicleTotal = $search->num_results();
        ?><div id="c-class-countdown" class="hidden-xs">
            <a class="fa fa-times c-class-countdown-close" href="#" aria-label="Close"></a>
            <p>
                <div class="c-class-count"><span><?php echo $vehicleTotal; ?></span> C-Classes to Choose From!</div>
            </p>
        </div>
        <a trid="8231b3620aa04ea0baaf88" trc class="c-class-countdown-sm inactive" href="#"><span><?php echo $vehicleTotal; ?></span> Available!</a><?php
    endif;
};

function comment_form_text($defaults) {
  $defaults['title_reply'] = "Share Your Thoughts";
  return $defaults;
};

//00103505 - CPO PDF URLS
function cpo_pdf_urls($vehicle) {

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
};

function vdp_lease_offer_js() {
    global $inventoryFrontend;
    if( array_key_exists('vehicle', $inventoryFrontend->data) ){
        $vehicle = $inventoryFrontend->data['vehicle'];

        if (($vehicle['retired_courtesy_vehicle'] == true) || ($vehicle['type'] === 'New')) {
            ?>
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
            <?php
        }
    }
};

function hot_wheels_path($path) {
    return 'partials/vdp/project-hotwheels/vehicle-gallery-condensed';
};

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

add_filter('di_back_button_text', function($title, $postID){
    global $inventoryFrontend;
    if(DIFunctions::is_vehicle_page() ){
        $vehicle = $inventoryFrontend->data['vehicle'];
        if( array_key_exists('next_to_new', $vehicle) && $vehicle['next_to_new'] == 'true' ){
            $title = 'Next to New Vehicles';
        }
    }
    return $title;
},99,2);

add_filter('di_back_button_link',function($link,$postID){
    global $inventoryFrontend;
    if(DIFunctions::is_vehicle_page() ){
        $vehicle = $inventoryFrontend->data['vehicle'];
        if( array_key_exists('next_to_new', $vehicle) && $vehicle['next_to_new'] == 'true' ){
            $link = '/used-vehicles/next-to-new-vehicles/';
        }
    }
    return $link;
},99,2);


// *************************************************************************************************
//  VRP
// *************************************************************************************************

//Change VRP and VDP CTA labels to "GET E-PRICE"
function swap_out_vrp_used_cta($cta_buttons)
{
    global $inventoryFrontend;

    //if the same label applies to both CPO and used vehicles use this instead
    if ($inventoryFrontend->data['vehicle']['type'] !== 'New' && $inventoryFrontend->data['vehicle']['our_price'] == 0) {
        $cta_buttons[$inventoryFrontend->data['vehicle']['type']]['listview']['label'] = 'GET E-PRICE';
        $cta_buttons[$inventoryFrontend->data['vehicle']['type']]['listview']['form_id'] = '1';
        $cta_buttons[$inventoryFrontend->data['vehicle']['type']]['gridview']['label'] = 'GET E-PRICE';
        $cta_buttons[$inventoryFrontend->data['vehicle']['type']]['gridview']['form_id'] = '1';
    }
    return $cta_buttons;
}

function swap_out_vdp_used_cta($cta_buttons)
{
    global $inventoryFrontend;

    if ($inventoryFrontend->data['vehicle']['type'] !== 'New' && $inventoryFrontend->data['vehicle']['our_price'] == 0) {
        $cta_buttons['used']['label'] = 'GET E-PRICE';
        $cta_buttons['used']['form_id'] = '1';
    }
    return $cta_buttons;
}

/*
* return true if type is NOT new and NOT in modelList
*/
function shouldShowEPrice($modelname,$type){

    $modelname = strtolower($modelname);
    //hacky hashmap for 1-to-1 searching
    $modelToIgnoreALL = [];

    $modelToIgnoreNew = ['g-class'=>'g-class','s-class'=>'s-class','amg'=>'amg','sl-class'=>'sl-class'];

    $modelToIgnoreUsed = [];

    if( array_key_exists($modelname, $modelToIgnoreALL) ){
        return false;
    }
    else if($type == 'New'){
        //just new
        if( array_key_exists($modelname, $modelToIgnoreNew) ){
            return false;
        }
    }
    else{
        //just used
        if( array_key_exists($modelname, $modelToIgnoreUsed) ){
            return false;
        }
    }
    return true;
};
function pricing_bottom_text_customization() {
    global $inventoryFrontend;
    /***********************************
    *   ONLY NEW VEHICLES
    ***********************************/
    if( $inventoryFrontend->vehicle->type == 'New' ){
        //End of year disclaimer
        if( is_in_end_of_year_window() && eoy_model_check(strtolower($inventoryFrontend->vehicle->model)) && $inventoryFrontend->vehicle->year == 2018 ): ?>
            <div id="eoy-disclaimer">2 Month Payment Waiver!*</div><?php
        endif;
        //EoF End of year disclaimer

        // Lease offer CTA
        ?><a trid="734c207449db4a73a9680d" trc href="#gravity-form-101" id="lease-for-less-cta" class="button-form block button primary-button fancy" data-form-id="101" data-vehicle='<?php echo json_encode($inventoryFrontend->data['vehicle']['json'], JSON_FORCE_OBJECT); ?>'>Get Your Lease Offer Now</a>
        <?php
        add_form_vrp( get_form_id('Get Your Lease Offer Now') );
        //EoF Lease Offer CTA

    }// EoF New Vehicles VRP
    //used c-class
    /*
    if( $inventoryFrontend->vehicle->type == 'Used' || $inventoryFrontend->vehicle->type == 'Certified Used' ){
        if( $inventoryFrontend->vehicle->model == 'C-Class' ){
            ?><a trid="087ddd6ebf0645d5b6988a" trc href="#gravity-form-139" id="lock-in-price-cta" class="button-form block button cta-button fancy" data-form-id="139" data-vehicle='<?php echo json_encode($inventoryFrontend->data['vehicle']['json'], JSON_FORCE_OBJECT); ?>'>Lock in Price</a>
            <?php
            add_form_vrp( get_form_id('Lock in Price') );
        }
    }
    */
    /***********************************
    *   DEFAULT - SHOWS ON ALL VRP
    ***********************************/
    if( shouldShowEPrice($inventoryFrontend->vehicle->model, $inventoryFrontend->vehicle->type) ) : ?>
        <a trid="7177584b2f3e41fdb1ddce" trc href="#gravity-form-1" id="get-eprice-cta" class="true button-form button cta-button block fancy button-form" data-form-id="1" data-vehicle='<?php echo json_encode($inventoryFrontend->data['vehicle']['json'], JSON_FORCE_OBJECT); ?>'>Get E-Price</a>
    <?php endif; ?>
    <a trid='4052756466de449fbff3ad' trc class='button primary-button block finance-link' href='/apply-for-financing/'>Get Pre-Approved</a><?php
};
function change_carfar_logo($vehicle){
  //  if( array_key_exists('history_report_logo', $vehicle) && !empty( $vehicle['history_report_logo'] ) ){
    //    if( array_key_exists('alt',$vehicle['history_report_logo']) && ($vehicle['history_report_logo']['alt'] == 'CarFax Report') ){
      //      $vehicle['history_report_logo']['img'] = '/wp-content/themes/DealerInspireDealerTheme/images/carfax_one_owner.png';
      //  }
   // }
};


//00196195 - Add class to new 2018's for their 'locked' pricing
function add_class_to_locked_pricing_vehicles($classes, $view, $vehicle) {
    if ($vehicle['type'] =='New' && $vehicle['year'] == '2018' ) {
        $classes[] = 'locked_pricing_vehicle';
    }
    return $classes;
}
function add_form_vrp($id){
    add_filter('im_vrp_gravity_forms', function($vrp_forms) use( $id){
        foreach($vrp_forms as $form){
            if($form == $id){
                return $vrp_forms;
            }
        }
        array_push( $vrp_forms, $id );

        return $vrp_forms;
    },999999,1);
}

function get_form_id($title)
{
    $forms = GFAPI::get_forms();
    $form_id = 1;
    foreach($forms as $i => $form)
    {
        if($form['title'] == $title) {
            $form_id = $form['id'];
        }
    }
    return $form_id;
}

//00062845 - Add inquire CTA to GT & G-Class
function vrp_inquire_cta() {
    $frontend = $GLOBALS['inventoryFrontend'];
    $veh_model = strtolower($frontend->vehicle->model);
    if
    ( (strtolower($frontend->vehicle->type )== 'new')
        && ($veh_model == ('g-class')
        || $veh_model == 's-class'
        || $veh_model == 'amg'
        || $veh_model == 'sl-class')): ?>
        <div id="inquire-button">
            <a trid="680fe246429c4c34805098" trc href="#inquire-modal" class="inquire button cta-button lightbox fancybox">Inquire</a>
            <div id="inquire-modal" style="display: none;">
                <?php gravity_form(88, true, false, false, '', false); ?>
            </div>
        </div>
    <?php endif;
}

function vdp_inquire_cta() {
    $frontend = $GLOBALS['inventoryFrontend'];

    $veh_model = strtolower($frontend->vehicle->model);

    if
    ( ($frontend->vehicle->type == 'new')
        && $veh_model == ('g-class')
        || $veh_model == 's-class'
        || $veh_model == 'amg'
        || $veh_model == 'sl-class'): ?>

        <div id="inquire-button">
            <a trid="52dec22e167c47b29983bb" trc href="#inquire-modal" class="inquire button cta-button lightbox fancybox">Inquire</a>
            <div id="inquire-modal" style="display: none;">
                <?php gravity_form(88, true, false, false, '', false); ?>
            </div>
        </div>
    <?php endif;
}

//00062845 - Add class to GT & G-Class to hide the main CTA
function add_class_to_specific_models($classes, $view, $vehicle) {
    if($vehicle['type'] =='New'){
        if ($vehicle['model'] == 'S-Class' || strtolower($vehicle['model']) == 'g-class' || $vehicle['model'] == 'AMG® GT') {
            $classes[] = 'hide-the-main-cta';
        }
    }
    return $classes;
}

function c_class_lock_in_price_cta($cta_buttons)
{
    global $inventoryFrontend;

    if ($inventoryFrontend->data['vehicle']['type'] !== 'New' && $inventoryFrontend->data['vehicle']['model'] == 'C-Class') {
        $cta_buttons['used']['label'] = 'Lock In Price';
        $cta_buttons['used']['form_id'] = get_form_id('Lock in Price') ;
    }
    return $cta_buttons;
}

function lightning_vehicle_finder(){
    ?><script>
    document.addEventListener('lightning-vrp-did-change', function(event) {
        if( event.detail.totalVehicles == 0){
            document.dispatchEvent(new Event("lightning-vrp-no-vehicles",{bubbles:true, cancelable: false}));
            window.l_vrp_did_change = true;
          //  document.getElementById('no-results-message').appendChild(document.getElementById('lvrp-vehicle-finder-toggle'));
            document.getElementById('no-results-message').insertBefore(document.getElementById('lvrp-vehicle-finder-image'),document.getElementById('no-results-message').childNodes[0]);
          //  document.getElementById('lvrp-vehicle-finder-toggle').classList.remove('hidden');
            document.getElementById('lvrp-vehicle-finder-image').classList.remove('hidden');

        }
        else{
            window.l_vrp_did_change = false;
            var finderToggle = document.getElementById('lvrp-vehicle-finder-toggle');
            if( !finderToggle.classList.contains('hidden') ){
                finderToggle.classList.add('hidden');
            }
        }
    });

    </script><?php
    global $post;
    if( get_post_meta($post->ID,'_wp_page_template',true) == 'templates/page-lightning.php'){
        ?><div id="lightning-vehiclefinder" class="hidden modal fade" role="dialog">
          <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?php gravity_form(get_form_id('Vehicle Finder Service'), true, false, false, '', false); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<a trid="0b1ddeec1f6d490b9c4193" trc href="#" class="button primary-button hidden" id="lvrp-vehicle-finder-toggle" data-toggle="modal" data-target="#lightning-vehiclefinder">Vehicle Finder</a>
<div id="lvrp-vehicle-finder-image" class="hidden" style="padding-bottom: 10px"><img src="/wp-content/plugins/vessel/content/shared/images/vehicle-finder-image.jpg" alt="Vehicle Finder" /></div>
<?php
    }
}

function flip_chromedata_images(){
    if(!IMFunctions::is_vdp() && !IMFunctions::is_vrp() && !DIFunctions::is_lightning_inventory_page()){
        return;
    }
    $style = <<<STYLE
<style>
    #lvrp-results-wrapper img[src*="chromedata"],
    #results-page .vehicle img[src*="chromedata"],
    #lvrp-results-wrapper .hit-image-wrap img[src*="chromedata"],
    #vehicleDetails .gallery-wrap .swiper-slide:first-child img[src*="chromedata"]{
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
        filter: FlipH;
        -ms-filter: "FlipH";
    }
</style>
STYLE;

    echo $style;
}

//CREATE mobile footer nav menu
register_nav_menus( array(
    'mobile-footer-menu' => 'Mobile Footer Menu',
    'mobile-menu' => 'Mobile Menu',
    'mobile-header-menu' => 'Mobile Header Menu',
) );


//CREATE MOBILE CTA CAROUSEL SHORTCODE
function mobile_carousel() {
  ob_start();
  include(plugin_dir_path(__FILE__).'/partials/mobile-carousel.php');
  return ob_get_clean();
}

//CREATE MOBILE SINGLE CTA SHORTCODE
function mobile_cta() {
  ob_start();
  include(plugin_dir_path(__FILE__).'/partials/mobile-cta.php');
  return ob_get_clean();
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
                        <span class="post-image"><a trid="eaf44afc5e6b4f818bc17f" trc href="<?= get_permalink() ?>"><?= get_the_post_thumbnail( $id, array('auto',50)) ?></a></span>
                    <?php } ?>
                    <h3><a trid="ea28ac46638f4cfeae5d72" trc href="<?= get_permalink() ?>"><?= get_the_title() ?></a></h3>
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


//REGISTER SHORTCODES
function register_shortcodes(){
    add_shortcode('category-header', 'category_header');
  add_shortcode('mobile-carousel', 'mobile_carousel');
  add_shortcode('mobile-cta', 'mobile_cta');
  add_shortcode('show-posts', 'fj_show_posts');
}

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

function disable_conversations_globally($bool){
    global $post;
    // grab the service page post object
    $pages = ['service','conversations'];

    foreach( $pages as $page ){
        // grab the parts page post object
        $service_page = get_page_by_path( $page );
        // set the service page ID
        $service_page_id = $service_page->ID;
        // combine both IDs in an array for easier checking
        $page_id_array = array( $service_page_id );

    }

    // check if current page is in list of pages, as well as any child pages
    if(
        isset( $post->ID ) &&
            (
                in_array( $post->ID, $page_id_array ) ||
                $post->post_parent && in_array( $post->post_parent, $page_id_array )
            )
    ){
        return false;
    }
    return $bool;
}

add_filter( 'body_class', function ( $classes ) {
    global $inventoryFrontend;

    if (DIFunctions::is_vehicle_page() === true && $inventoryFrontend->vehicle['next_to_new'] && $inventoryFrontend->vehicle['api_id'] == 'FJMotorcarscode9') {
      $classes[] = 'previous-loaner-vehicle';
    }

    return $classes;
});


add_filter('inventory-display-vrp-sorter', function($sorts) {
    $sorts['my_custom_sort_index'] = [
      'name' => 'In-Transit Last',
      'userSortDisplay' => 'In-Transit Last',
      'rankings' => [
        [
          'key' => 'In_Transit', // The key on the vehicle object to sort by
          'direction' => 'asc' // Whether to sort in asc or desc order
        ]
      ]
    ];

    return $sorts;
});

add_action('pre_wp_head', function(){ ?>
<link href='https://di-uploads-pod3.dealerinspire.com' rel='preconnect' crossorigin>
<link rel="preload" as="image" href="https://di-uploads-pod3.dealerinspire.com/fletcherjonesmbnewport/uploads/2019/09/Mobile-Site-Home-Page-Tile-v2-New-2.jpg" />
<link rel="preload" as="font" type="font/woff2" href="/wp-content/themes/DealerInspireCommonTheme/includes/fonts/fontawesome-webfont.woff2?v=4.7.0" crossorigin="anonymous">

<?php });

function add_class_to_in_transit_vehicles($classes, $view, $vehicle) {
    if ( str_contains('FJMotorcarsNewporttransit,FJMotorcarsusedinprogress',$vehicle['api_id']) ) {
        $classes[] = 'in-transit-vehicle';
    }
    return $classes;
}

function add_class_to_previous_loaner_vehicles($classes, $view, $vehicle) {
    if ( $vehicle['previous_loan'] == 'Previous Loaner' ) {
        $classes[] = 'previous-loaner-vehicle';
    }
    return $classes;
}


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

add_action('navigation_right',function(){
    ob_start();
    include(plugin_dir_path(__FILE__).'partials/language-toggle.php');
    echo ob_get_clean();
  });
