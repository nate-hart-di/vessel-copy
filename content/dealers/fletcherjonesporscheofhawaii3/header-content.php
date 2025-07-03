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

<?php if (!function_exists('get_header_bottom')):
  function get_header_bottom($id = null)
  {
    ob_start(); ?>
  <div class="sub-header-info row" <?= $id != null ? "id=\"" . $id . "\"" : '' ?>>
  	<div class="container-fluid">
  		<div class="row">
  			<div class="col-sm-6">
  				<span class="glyphicon glyphicon-earphone"></span>
  				<span class="dealer-phone sales">
  					Sales: <?= get_option('di_phone_sales') ?>
  				</span>
  				<span class="dealer-phone">
  					Service: <?= get_option('di_phone_service') ?>
  				</span>
  				<span class="dealer-phone">
  					Parts: <?= get_option('di_phone_parts') ?>
  				</span>
  			</div>
  			<div class="col-sm-6">
  				<span class="dealer-address">
  					<a trid="9b72518c6e9241d583447e" trc target="_blank" itemprop="directions" href="<?php echo get_option(
         'di_google_map',
       ); ?>" data-gtm-event="desktopHeaderMapLink">
  						<span class="addressfocus"><span class="glyphicon glyphicon-map-marker"></span> <?php echo get_option(
          'di_street_address',
        ); ?> • <?php echo get_option('di_city'); ?>, <?php echo get_option('di_state'); ?> <?php echo get_option('di_zipcode'); ?></span>
  					</a>
  				</span>
  			</div>
  		</div>
  	</div>
  </div>

  <?php return ob_get_clean();
  }
endif; ?>

<div id="header" class="menu-top hidden-xs">
	<div id="header-top">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<a trid="a2ea629655e84f1aaec356" trc class="menu-toggle menu" data-gtm-event="desktopHeaderMenuOpen"><span class="glyphicon glyphicon-align-justify"></span> <span class="menu-label">MENU</span></a>
				</div>
				<div class="col-sm-6 no-padding">
					<div class="logo" itemscope itemtype="http://schema.org/Organization">
						<a trid="d0ee25dab1f545dab3a6a0" trc itemprop="url" href="<?php echo home_url(); ?>"><img itemprop="logo" src="/wp-content/plugins/vessel/content/dealers/fletcherjonesporscheofhawaii/images/logo.jpg" alt="<?php echo get_bloginfo(
  'title',
); ?>"></a>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="hours-info-right">
    				<?php if (is_active_sidebar('holiday-hours')): ?>
  					<a trid="117716e85a38481cad6fd9" trc data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="Special Hours">
  					  Special Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
  					</a>
    				<?php dynamic_sidebar('holiday-hours'); ?>
  				<?php else: ?>
  					<span>
					    Sales: <?php echo date('D'); ?> <?php echo do_shortcode(
   '[di_display_open_hours departments="Sales" class=dynamic-hours]',
 ); ?>
  					</span>
					  <span>
					    Service: <?php echo date('D'); ?> <?php echo do_shortcode(
   '[di_display_open_hours departments="Service" class=dynamic-hours]',
 ); ?>
					  </span>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
  <?php echo get_header_bottom('header-bottom'); ?>
</div>

	<div id="mini-header" class="hidden-xs <?= DIFunctions::is_vehicle_page() ? 'open' : '' ?>">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<a trid="400083ffdac949728a212b" trc class="menu-toggle menu"><span class="glyphicon glyphicon-align-justify"></span> <span class="menu-label">MENU</span></a>

					<?php
     $conditionals = [
       'page_id' => get_the_ID(),
       'is_vehicle_page' => DIFunctions::is_vehicle_page(),
       'is_inventory_page' => DIFunctions::is_inventory_page(),
     ];
     do_action('before_mini_header_nav', $conditionals);
     ?>

					<?php if (!DIFunctions::is_vehicle_page()): ?>
						<div class="navbar">
							<div class="navbar-inner">
								<?php $defaults = [
          'theme_location' => 'simple-main-menu',
          'container' => false,
          'menu_class' => 'nav',
          'echo' => true,
          'fallback_cb' => 'wp_page_menu',
          'depth' => 3,
          'walker' => '',
        ]; ?>
								<div class="nav_section">
									<?php wp_nav_menu($defaults); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php
     do_action('after_mini_header_nav', $conditionals);
     echo get_header_bottom();
     ?>

				</div>
			</div>
		</div>
	</div>

	<div id="menu-overlay" class="hidden-xs">
		<div id="header-vertical">
			<a id="menu-close" class="menu" data-gtm-event="desktopHeaderMenuClose"><span class="glyphicon glyphicon-remove"></span><span class="menu-label">CLOSE</span></a>
			<div class="navbar vertical">
				<div class="navbar-inner">
					<?php $defaults = [
       'theme_location' => 'main-menu',
       'container' => false,
       'menu_class' => 'nav',
       'echo' => true,
       'fallback_cb' => 'wp_page_menu',
       'depth' => 3,
       'walker' => new wp_bootstrap_navwalker(),
     ]; ?>
					<div class="nav_section">
						<?php wp_nav_menu($defaults); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_scoped_template_part('partials/actionbars/button', 'sidebar', [
  'buttons' => [
    [
      'label' => 'New Vehicles',
      'link' => '/new-vehicles/',
      'icon' => 'fa-automobile',
      'gtm_event' => 'desktopButtonSidebarNew',
    ],
    [
      'label' => 'Pre-Owned',
      'link' => '/used-vehicles/',
      'icon' => 'fa-tag',
      'gtm_event' => 'desktopButtonSidebarUsed',
    ],
    [
      'label' => 'Lease Today',
      'link' => '/current-offers/',
      'icon' => 'fa-usd',
      'gtm_event' => 'desktopButtonSidebarLease',
    ],
    [
      'label' => 'Schedule Service',
      'link' => '/schedule-service/',
      'icon' => 'fa-wrench',
      'gtm_event' => 'desktopButtonSidebarService',
    ],
    [
      'label' => 'Schedule Test Drive',
      'link' => '#scheduleTestDrive',
      'type' => 'overlay',
      'icon' => 'fa-calendar-o',
      'gtm_event' => 'desktopButtonSidebarTestDrive',
    ],
    [
      'label' => 'Get Pre-Approved',
      'link' => '/apply-for-financing/',
      'icon' => 'fa-calculator',
      'gtm_event' => 'desktopButtonSidebarFinancing',
    ],
  ],
  'position' => 'left',
]); ?>

<div class="toolbar-overlays">
  <div id="scheduleTestDrive" class="tool-overlay targetOverlay" style="display: none;">
		<div class="overlay-container">
			<h2>SCHEDULE TEST DRIVE</h2>
			<span class="close-overlay"><i class="fa fa-close"></i></span>
			<div class="overlay-content">
				<?php gravity_form('Schedule Test Drive', false, false, false, '', false, 10); ?>
			</div>
		</div>
	</div>
</div>

<div class="visible-xs">
	<?php get_template_part('partials/headers/mobile/header', 'mobilebasic'); ?>
</div>

<div class="visible-xs">
	<?php get_scoped_template_part('partials/navigations/offcanvas', 'nav', ['theme_location' => 'main-menu']); ?>
</div>
