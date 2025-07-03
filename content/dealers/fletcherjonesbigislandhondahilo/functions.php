<?php
add_filter('algolia_vehicle_types', 'set_algolia_vehicle_types');

// add make-specific vehicle styles
function load_child_scripts() {
  if (function_exists('load_vehicle_sprites')) {
    load_vehicle_sprites(array(
      'honda-menu'
    ));
  }

}
add_action('wp_enqueue_scripts', 'load_child_scripts');

add_filter('google_font_list', function($fonts) {
    $fonts[] = 'Lato:300,400,700';
    return $fonts;
});

function override_js()
{
  wp_dequeue_script('custom');
}
add_action('wp_print_scripts', 'override_js');

//require_once(WP_CONTENT_DIR . "/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/shared-functions.php");
//FJ_Functions::instance();

function get_site_link_for_dealership( $vehicle )
{
	if(is_object($vehicle)) {
		$api_id = $vehicle->api_id;
	}
	else {
		$api_id = $vehicle['api_id'];
	}

	if ( empty($api_id) )
	{
		return false;
	}

	$urls = array(
		'FJHondaHilo' => array("name" => "Big Island Honda Hilo", "phone" => get_option('di_phone_sales')),
		'FJHondaKona' => array("name" => "Big Island Honda Kona", "phone" => get_option('di_phone_fax'))
	);

	return array_key_exists($api_id, $urls) ? $urls[$api_id] : false;
}

add_filter('im_filter_vdp_mainvehicleheaderbox_end', function ( $value, $vehicle )
{
	if ( isset($vehicle['dealer_name']) && !empty($vehicle['dealer_name']) )
	{
		return "<div class='popover-container'><a trid='ee1efb1553cb491d9a2e82' trc role='button' data-toggle='popover' data-trigger='click' data-placement='top' href='#dealer-location-popover' class='btn btn-small btn-default' id='dealer-location-popover-trigger' rel='button'><span class='popover-trigger-label'>Location: </span>{$vehicle['dealer_name']}</a></div>";
	}
}, 10, 2);

add_action('vdp_modals', function ( $vehicle )
{ ?>
	<?php if ( isset($vehicle['dealer_name']) && !empty($vehicle['dealer_name']) ): ?>
	<?php $address = $vehicle['address']; ?>
	<?php $locality = $vehicle['city'] . ', ' . $vehicle['state'] . ' ' . $vehicle['zipcode']; ?>
	<?php $phone = $vehicle['phone']; ?>
	<?php $google_url = '//www.google.com/maps/dir/current+location/' . urlencode( $address . ' ' . $locality ); ?>
	<div id="dealer-location-popover" class="hidden">
		<div class="row location-popover-wrap">
			<div class="col-md-7">
				<span class="dealer-name"><?php echo $vehicle['dealer_name']; ?></span>

			<?php if ( !empty($address) ): ?>
				<span class="dealer-address">
					<a trid="e29a17c48b7247188f33c6" trc href="<?php echo $google_url; ?>" target="_blank" title="View Directions"><?php echo $address . '<br>' . $locality; ?></a>
				</span>
			<?php endif; ?>
			</div>

			<div class="col-md-5">
			<?php if ( !empty($phone) ): ?>
				<span class="dealer-phone"><?php echo $phone; ?></span>
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
<?php });

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

add_filter('vrp_sorting_options_array', function($options) {
  foreach($options as $option => $data) {
    if($data['key'] == "images")
      unset($options[$option]);

  }
  return $options;
}, 10, 1);


require_once __DIR__ . '/../../../../../themes/DealerInspireCommonTheme/includes/plugins/HomepageBackgroundImageOverrides/HomepageBackgroundImageOverrides.php';
(new \DICommonTheme\HomepageBackgroundImageOverrides())
  ->setMainBackgroundImageMobile('#videobanner');

  /**
 * Set the algolia vehicle make so only Honda can be searched
 *
 * Case: #00050773
 *
 * @param [type] $types
 * @return void
 */
function set_algolia_vehicle_types($types)
{
  return array(array('type:New', 'type:Used'), 'make:Honda');
}

add_action('vrp_listview_pricing_bottom_text', function() {
    global $inventoryFrontend;

    //End of year disclaimer
    if (is_in_end_of_year_window()
        && $inventoryFrontend->vehicle->api_id === 'FJHondaHilo'
        && DIFunctions::is_inventory_page('new')
        && $inventoryFrontend->vehicle->year == 2018): ?>

        <div id="eoy-disclaimer">$750 Below MSRP!*</div>

    <?php endif;
});