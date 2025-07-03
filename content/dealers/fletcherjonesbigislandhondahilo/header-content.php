<script type="text/javascript">
	jQuery(document).ready(function($){
		if( $(window).width() > 767 ) {
			setTimeout(function(){
				$(".search-fields select").selectpicker({dropupAuto: false});
				$("body").live('search_filters_rendered',function(){
					$(".search-fields select").selectpicker('refresh');
				});
			},200);
		}
	});
</script>

<?php if(!function_exists('get_header_bottom')):
  function get_header_bottom($id = null) {
    ob_start(); ?>
  <div class="sub-header-info row" <?= ($id != null) ? "id=\"".$id."\"" : "" ?>>
    <div class="dealer-phone">
        <div class="phone-item">
            Hilo Sales: <?= get_option('di_phone_sales') ?>
        	<br/>
        	Hilo Service: <?= get_option('di_phone_service') ?>
        </div>
        <div class="phone-item">
        	Kona Sales: <?= get_option('di_phone_bodyshop') ?>
        	<br/>
        	Kona Service: <?= get_option('di_phone_collisioncenter') ?>
        </div>
    </div>
    <span class="dealer-address">
    	<a trid="2f66afdd224f471688e739" trc target="_blank" itemprop="directions" href="https://www.google.com/maps/place/Big+Island+Honda+Hilo/@19.7023523,-155.067196,17z/data=!3m1!4b1!4m2!3m1!1s0x79524b6c893380c5:0xdb432e5b8127c35d" data-gtm-event="desktopHeaderMapLink">
    		<span class="addressfocus"><i class="fa fa-map-marker"></i> 124 Wiwoole St &bull; Hilo, HI 96720</span>
    	</a>
    	<a trid="c3c928ed85ad4019a23da6" trc target="_blank" itemprop="directions" href="//maps.google.com/?q=75-5608+Kuakini+Hwy+Kailua-Kona,+HI+96740" data-gtm-event="desktopHeaderMapLink">
    		<span class="addressfocus"><i class="fa fa-map-marker"></i> 75-5608 Kuakini Hwy &bull; Kailua-Kona, HI 96740</span>
    	</a>
    </span>
  </div>
  <?php return ob_get_clean();
  }
endif ?>

	<div id="header" class="menu-top hidden-xs">
		<div id="header-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3">
						<a trid="8c4449cdf2464596b0679d" trc class="menu-toggle menu" data-gtm-event="desktopHeaderMenuOpen"><span class="glyphicon glyphicon-align-justify"></span> <span class="menu-label">MENU</span></a>
					</div>
					<div class="col-sm-6 no-padding">
						<div class="logo" itemscope itemtype="http://schema.org/Organization">
							<a trid="5fd45792c40747b186a50a" trc itemprop="url" href="<?php echo home_url(); ?>"><img itemprop="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="<?php echo get_bloginfo('title'); ?>"></a>
                            <?php if (get_field('vessel_header_image', 'option')): ?>
                                <img id="vessel-header-img" src="<?= get_field('vessel_header_image', 'option'); ?>" alt="Custom Header Image">
                            <?php endif; ?>
                        </div>
					</div>
    				<?php if(is_active_sidebar("holiday-hours-hilo") || is_active_sidebar("holiday-hours-kona")): ?>
  				<div class="col-sm-3">
  					<div class="hours-info-right">
    					<a trid="823298970d0e4ffc9f0c47" trc data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours-hilo" data-modal-class="" data-modal-title="Special Hours">
    					  Hilo Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
    					</a>
    					<a trid="a4ae0c81c0c74304aa1e04" trc data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours-kona" data-modal-class="" data-modal-title="Special Hours">
    					  Kona Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
    					</a>
              <?php

                dynamic_sidebar("holiday-hours-hilo");
                dynamic_sidebar("holiday-hours-kona");

              ?>
  					</div>
  				</div>
  				<?php else: ?>
					<div class="col-sm-3 dealer-hours">
  					<a trid="c49d41a95f924da9a4303d" trc data-toggle="modal" data-target="#DIModal" data-modal-content="#open-hours" data-modal-title="Today's Department Hours">
  					  Today's Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
  					</a>
  					<div id="open-hours" style="display:none">
    					<div>
      					<span>Hilo Sales: <?php echo date('D'); ?> <?= do_shortcode('[di_display_open_hours departments="Hilo Sales" class=dynamic-hours]') ?></span>
      					<span>Hilo Service: <?php echo date('D'); ?> <?= do_shortcode('[di_display_open_hours departments="Hilo Service" class=dynamic-hours]') ?></span>
    					</div>
    					<div>
      					<span>Kona Sales: <?php echo date('D'); ?> <?= do_shortcode('[di_display_open_hours departments="Kona Sales" class=dynamic-hours]') ?></span>
      					<span>Kona Service: <?php echo date('D'); ?> <?= do_shortcode('[di_display_open_hours departments="Kona Service" class=dynamic-hours]') ?></span>
    					</div>
  					</div>
					</div>
					<?php endif ?>
				</div>
			</div>
		</div>
    <?php echo get_header_bottom("header-bottom") ?>
	</div>

	<div id="mini-header" class="hidden-xs <?= ( DIFunctions::is_vehicle_page() ) ? 'open' : ''; ?>">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<a trid="519fb2ddbc4343d7b0bacc" trc class="menu-toggle menu" data-gtm-event="desktopHeaderMenuOpen"><span class="glyphicon glyphicon-align-justify"></span> <span class="menu-label">MENU</span></a>

					<?php
						$conditionals = array(
							'page_id'			=>	get_the_ID(),
							'is_vehicle_page' 	=> 	DIFunctions::is_vehicle_page(),
							'is_inventory_page'	=>	DIFunctions::is_inventory_page()

						);
						do_action( 'before_mini_header_nav', $conditionals );
					?>

					<?php if( !DIFunctions::is_vehicle_page() ) : ?>
						<div class="navbar">
							<div class="navbar-inner">
								<?php $defaults = array(
								'theme_location'  => 'simple-main-menu',
								'container'       => false,
								'menu_class'      => 'nav',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'depth'           => 3,
								'walker'          => ''
								); ?>
								<div class="nav_section">
									<?php wp_nav_menu( $defaults); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php do_action( 'after_mini_header_nav', $conditionals );
  					echo get_header_bottom() ?>

				</div>
			</div>
		</div>
	</div>

	<div id="menu-overlay" class="hidden-xs">
		<div id="header-vertical">
			<a id="menu-close" class="menu" data-gtm-event="desktopHeaderMenuClose"><span class="glyphicon glyphicon-remove"></span><span class="menu-label">CLOSE</span></a>
			<div class="navbar vertical">
				<div class="navbar-inner">
					<?php $defaults = array(
						'theme_location'  => 'main-menu',
						'container'       => false,
						'menu_class'      => 'nav',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'depth'           => 3,
						'walker' 					=> new wp_bootstrap_navwalker()
					); ?>
					<div class="nav_section">
						<?php wp_nav_menu( $defaults ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_scoped_template_part('partials/actionbars/button', 'sidebar',
    array('buttons' => array(
        array(
            'label'            => 'New Vehicles',
            'link'            => '/new-vehicles/',
            'icon'            => 'fa-automobile',
            'gtm_event'    => 'desktopButtonSidebarNew'
        ),
        array(
            'label'            => 'Pre-Owned',
            'link'            => '/used-vehicles/',
            'icon'            => 'fa-tag',
            'gtm_event'    => 'desktopButtonSidebarUsed'
        ),
        array(
            'label'            => 'Lease Today',
            'link'            => '/current-offers/',
            'icon'            => 'fa-usd',
            'gtm_event'    => 'desktopButtonSidebarLease'
        ),
        array(
            'label'            => 'Schedule Service',
            'link'            => '/schedule-service/',
            'icon'            => 'fa-wrench',
            'gtm_event'    => 'desktopButtonSidebarService'
        ),
        array(
            'label'            => 'Schedule Test Drive',
            'link'            => '#scheduleTestDrive',
            'type'            => 'overlay',
            'icon'            => 'fa-calendar-o',
            'gtm_event'    => 'desktopButtonSidebarTestDrive'
        ),
        array(
            'label'            => 'Get Pre-Approved',
            'link'            => '/apply-for-financing/',
            'icon'            => 'fa-calculator',
            'gtm_event'    => 'desktopButtonSidebarFinancing'
        )
    ),
    'position' => 'left')); ?>

<div class="toolbar-overlays">
  <div id="scheduleTestDrive" class="tool-overlay targetOverlay" style="display: none;">
		<div class="overlay-container">
			<h2>SCHEDULE TEST DRIVE</h2>
			<span class="close-overlay"><i class="fa fa-close"></i></span>
			<div class="overlay-content">
				<?php gravity_form( 'Schedule Test Drive', false, false, false, '', false, 10); ?>
			</div>
		</div>
	</div>
</div>

<div class="visible-xs">
	<?php  get_shared_mobile_template('header-mobilebasic'); ?>
</div>

<div class="visible-xs">
	<?php get_shared_mobile_template('header-mobilebasic'); ?>
</div>

<div class="visible-xs">
    <?php get_scoped_template_part('partials/navigations/offcanvas','nav', array( 'theme_location' => 'main-menu' )); ?>
</div>

<div id="mobile-phone-picker" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Choose Your Location</h4>
      </div>
      <div class="modal-body">
        <span class="hilo-phone">
         Hilo Sales: <a trid="e3afbd3dc2e64317aa738c" trc data-phone="Sales"href="tel:8083699917">(808) 369-9917</a>
        </span>
		<span class="hilo-phone">
		Hilo Service: <a trid="c411135c1df44944ae8258" trc data-phone="Service" href="tel:8082010505">(808) 201-0505</a>
        </span>
        <span class="kona-phone">
         Kona Sales: <a trid="a7b484c6564f4c19babf97" trc data-phone="Sales" href="tel:8084270882">(808) 427-0882</a>
        </span>
        <span class="kona-phone">
         Kona Service: <a trid="443b56f1b1f142468531d3" trc data-phone="Service" href="tel:8082010393">(808) 201-0393</a>
        </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="mobile-directions-picker" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Choose Your Location</h4>
      </div>
      <div class="modal-body">
        <span class="hilo-address">
        Honda Hilo: <a trid="5413b892062c4927a09a36" trc class="button primary-button" href="https://www.google.com/maps/place/Big+Island+Honda+Hilo/@19.7023473,-155.067196,17z/data=!3m1!4b1!4m2!3m1!1s0x79524b6c893380c5:0xdb432e5b8127c35d">Get Directions</a>
        </span>
        <span class="kona-address">
        Honda Kona: <a trid="4335819d0b3a40fca25735" trc class="button primary-button" href="https://www.google.com/maps/place/Big+Island+Honda+Service/@19.6419665,-156.0003586,17z/data=!3m1!4b1!4m2!3m1!1s0x79540dd9412d1e9d:0x35beddf229ac767b">Get Directions</a>
        </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
get_scoped_template_part(
    'partials/translate/google', 'translate',
    array(
        'mobile' => 'true'
    )
);
?>