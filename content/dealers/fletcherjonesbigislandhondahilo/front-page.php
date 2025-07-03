<?php
/*
Home page of the site
*/
?>

<div class="visible-xs">
  <?php if (is_active_sidebar('holiday-hours-hilo') || is_active_sidebar('holiday-hours-kona')): ?>
  <div id="openhoursbar" class="container">
  	<div class="row">
  		<div class="col-xs-12">
  			<span class="dynamic-hours seasonal-hours">
					<a trid="f8d442c0eec94f1396533a" trc class="white" href="javascript:void(0)" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours-hilo" data-modal-class="" data-modal-title="Hilo Holiday Hours">
					  Holiday Hours Hilo <i class="fa fa-clock-o fa-lg fa-fw"></i>
					</a> <br/>
					<a trid="2c7290d72ce2454a84ec8b" trc class="white" href="javascript:void(0)" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours-kona" data-modal-class="" data-modal-title="Kona Holiday Hours">
					  Holiday Hours Kona <i class="fa fa-clock-o fa-lg fa-fw"></i>
					</a>
  			</span>
  	  </div>
    </div>
  </div>

<?php else: ?>
  <?php get_scoped_template_part('partials/homepage/mobile/open', 'hours', [
    'departments' => 'Hilo Sales, Kona Sales',
  ]); ?>
<?php endif; ?>
</div>

<div id="videobanner" class="modfull-home">
  
	<div class="modfull variable hidden-xs">
  	
		<?php get_template_part('partials/sliders/video_fullheight'); ?>
    
	</div>
	
	
	<div id="videooverlay">
	  <div class="videooverlay-content" id="homepage-advanced-search">
	    <div class="row">
	      <div class="col-sm-12">
	        <?php get_scoped_template_part('partials/homepage/personalizer', 'key', []); ?>
	      </div>
            <?php get_homepage_countdown(); ?>
	    </div>

          <?php get_scoped_template_part('partials/search/anything', '', [
            'button_text' => 'Search',
            'search_placeholder' => 'i.e. 2017 Accord, Schedule Service...',
          ]); ?>
          <div class="col-sm-12 overlaybuttons">
              <a trid="70b03458c192489f9bb8ac" trc class="button primary-button" href="/new-vehicles/">New Vehicles</a>             
              <a trid="d694da420dca4981b34c12" trc class="button primary-button" href="/used-vehicles/">Used Vehicles</a>
              <a trid="3361594373dd4062835714" trc class="button primary-button" href="/value-your-trade/">Value Your Trade</a>
          </div>
	  </div>
	  <?php if (get_field('search_usp')) {
     the_field('search_usp');
   } ?>
	</div>
</div>

<?php do_action('fj_below_homepage_video'); ?>

<div id="ctaRow-mobile" class="visible-xs">
<a trid="295588b0b73c4dd1a8dd55" trc class="ctabox newvehicles" href="/new-vehicles/" data-gtm-event="mobileCTANewVehicles">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-newvehicles-mobile.jpg" alt="New Inventory">
  <h2>New<br />Vehicles</h2>
  <span class="ctabox-linktext">View Inventory <i class="fa fa-angle-double-right"></i></span>
</a>
<a trid="fe807d7f58ea4152a1a2ee" trc class="ctabox usedvehicles" href="/used-vehicles/" data-gtm-event="mobileCTAUsedVehicles">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-usedvehicles-mobile.jpg" alt="Used Inventory">
  <h2>Pre-Owned<br />Vehicles</h2>
  <span class="ctabox-linktext">View Inventory <i class="fa fa-angle-double-right"></i></span>
</a>
<a trid="23630653c83145bd93d651" trc class="ctabox financing" href="/apply-for-financing/" data-gtm-event="mobileCTAFinancing">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-financing-mobile.jpg" alt="Apply For Financing">
  <h2>Get<br />Financing</h2>
  <span class="ctabox-linktext">Apply Now <i class="fa fa-angle-double-right"></i></span>
</a>
<a trid="509472f256e4424e9275ad" trc class="ctabox scheduleservice" href="/service/schedule-service/" data-gtm-event="mobileCTAScheduleService">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-service-mobile.jpg" alt="Schedule Service">
  <h2>Schedule<br />Service</h2>
  <span class="ctabox-linktext">Schedule Now <i class="fa fa-angle-double-right"></i></span>
</a>
</div>

<div class="hidden-xs">

<?php get_template_part('partials/dealer-groups/fletcherjones/home-fullpageslider'); ?>

</div>

<div id="storyRow">
<div class="container-wide">
  <div class="row">
    <div class="col-sm-6">
      <div class="storycontent">
        <h2>The Fletcher Jones Legacy</h2>
        <p class="hidden-xs">Since 1946 Fletcher Jones has been the premier luxury automobile dealer group in the United States and has been credited with pioneering the revolutionary approach of treating clients as honored guests.</p>
        <a trid="2441d473a06d48b2b0cc97" trc class="button primary-button" href="/about-us/" data-gtm-event="legacyReadMore">READ MORE</a>
        <img class="visible-xs" src="<?php echo get_stylesheet_directory_uri(); ?>/images/fletcherjones-mobile.png" alt="Fletcher Jones Jr" />
      </div>
    </div>
    <div class="hidden-xs col-sm-4 fletcher">
      <img src="/wp-content/themes/DealerInspireDealerTheme/images/fletcherjones.png" alt="Fletcher Jones Portrait" />
    </div>
  </div>
</div>
</div>
