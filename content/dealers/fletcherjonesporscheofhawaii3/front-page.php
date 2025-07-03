<?php
/*
  Home page of the site
*/
?>

<div class="visible-xs">   	<!-- DEFAULT MOBILE HOMEPAGE -->
  <?php if (is_active_sidebar('holiday-hours')): ?>
  <div id="openhoursbar" class="container">
  	<div class="row">
  		<div class="col-xs-12">
  			<span class="dynamic-hours seasonal-hours">
					<a trid="1d6eddce63d54e1487ff9b" trc class="white" href="javascript:void(0)" data-toggle="modal" data-target="#DIModal" data-modal-content="#holiday-hours" data-modal-class="" data-modal-title="<?= get_option(
       'di_name',
     ) ?> Holiday Hours">
					  Holiday Hours <i class="fa fa-clock-o fa-lg fa-fw"></i>
					</a>
  			</span>
  	  </div>
    </div>

  </div>
  <?php else: ?>
   <?php get_scoped_template_part('partials/homepage/mobile/open', 'hours', []); ?>
  <?php endif; ?>
</div>
<?php get_scoped_template_part('partials/dealer-groups/fletcherjones/home', 'videobanner', []); ?>

<a trid="4356c66ea4c14593a9ece8" trc href="#belowvideo" class="striped-icon divider scroll hidden-xs hidden-sm" data-scrollto="#belowvideo"><i class="fa fa-chevron-down"></i></a>

<a trid="e666623590b24e759f599a" trc class="row-anchor" name="belowvideo"></a>

<div id="ctaRow" class="hidden-xs">
  <div class="container-wide">
    <div class="row">
      <div class="col-sm-3 col-xs-6">
        <a trid="12fc10cffaf04e9a943ade" trc class="ctabox newvehicles" href="/new-vehicles/" data-gtm-event="desktopCTANewVehicles">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-newvehicles.jpg" alt="New Inventory">
          <h2>New<br />Vehicles</h2>
          <div class="ctabox-overlay">
            <span class="ctabox-linktext">View Inventory <i class="fa fa-angle-double-right"></i></span>
          </div>
        </a>
      </div>
            <div class="col-sm-3 col-xs-6">
        <a trid="8822a535908643dc98a00a" trc class="ctabox usedvehicles" href="/used-vehicles/" data-gtm-event="desktopCTAUsedVehicles">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-usedvehicles.jpg" alt="Used Inventory">
          <h2>Pre-Owned<br />Vehicles</h2>
          <div class="ctabox-overlay">
            <span class="ctabox-linktext">View Inventory <i class="fa fa-angle-double-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-sm-3 col-xs-6">
        <a trid="8ea7d85d00314cf7985f76" trc class="ctabox offers" href="/current-offers/" data-gtm-event="desktopCTAOffers">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-offers.jpg" alt="Current Offers">
          <h2>Current<br />Offers</h2>
          <div class="ctabox-overlay">
            <span class="ctabox-linktext">View Offers <i class="fa fa-angle-double-right"></i></span>
          </div>
        </a>
      </div>
      <div class="col-sm-3 col-xs-6">
        <a trid="ca1621843c2a4ee791b20a" trc class="ctabox scheduleservice" href="/service/schedule-service/" data-gtm-event="desktopCTAScheduleService">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-service.jpg" alt="Schedule Service">
          <h2>Schedule<br />Service</h2>
          <div class="ctabox-overlay">
            <span class="ctabox-linktext">Schedule Service <i class="fa fa-angle-double-right"></i></span>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>

<div id="ctaRow-mobile" class="visible-xs">
  <a trid="035e64c243ee4330af364e" trc class="ctabox newvehicles" href="/new-vehicles/" data-gtm-event="mobileCTANewVehicles">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-newvehicles-mobile.jpg" alt="New Inventory">
    <h2>New<br />Vehicles</h2>
    <span class="ctabox-linktext">View Inventory <i class="fa fa-angle-double-right"></i></span>
  </a>
  <a trid="956552ced1724731b3aa17" trc class="ctabox usedvehicles" href="/used-vehicles/" data-gtm-event="mobileCTAUsedVehicles">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-usedvehicles-mobile.jpg" alt="Used Inventory">
    <h2>Pre-Owned<br />Vehicles</h2>
    <span class="ctabox-linktext">View Inventory <i class="fa fa-angle-double-right"></i></span>
  </a>
  <a trid="3529708c64714254b858e6" trc class="ctabox offers" href="/current-offers/" data-gtm-event="mobileCTAOffers">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-offers-mobile.jpg" alt="Current Offers">
    <h2>Current<br />Offers</h2>
    <span class="ctabox-linktext">View Offers <i class="fa fa-angle-double-right"></i></span>
  </a>
  <a trid="0837995a96d94f6682eeb2" trc class="ctabox scheduleservice" href="/service/schedule-service/" data-gtm-event="mobileCTAScheduleService">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ctabox-service-mobile.jpg" alt="Schedule Service">
    <h2>Schedule<br />Service</h2>
    <span class="ctabox-linktext">Schedule Now <i class="fa fa-angle-double-right"></i></span>
  </a>
</div>

<div class="hidden-xs">
	<?php get_template_part('partials/dealer-groups/fletcherjones/home-fullpageslider'); ?>
</div>

<?php
$youtube = get_field('featured_video_id');
if (!empty($youtube)): ?>
<div id="youtube-row" class="hidden-xs">
  <div class="container-wide">
    <div class="row">
      <div class="col-md-10 col-sm-offset-1">
        <div class="embed-responsive embed-responsive-16by9">
          <?php
  //this way the person entering the video doesn't have to remember to add the parameters on to the end of the vid embed url. wmode is vital for ie9, and the others mimic the look of the mock-up
  ?>
              <iframe width="560" height="315" data-src="https://www.youtube.com/embed/<?php echo $youtube; ?>?wmode=transparent&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif;
?>

<div id="storyRow">
  <div class="container-wide">
    <div class="row">
      <div class="col-sm-6">
        <div class="storycontent">
          <h2>THE FLETCHER JONES LEGACY</h2>

          <p class="hidden-xs">Since 1946 Fletcher Jones has been the premier luxury automobile dealer group in the United States and has been credited with pioneering the revolutionary approach of treating clients as honored guests.</p>

          <a trid="b064495a2eb6487783bcd3" trc class="button primary-button" href="/about-us/" data-gtm-event="legacyReadMore">READ MORE</a>
          <img class="visible-xs" src="<?php echo get_stylesheet_directory_uri(); ?>/images/fletcherjones-mobile.png" alt="Fletcher Jones Jr" />

        </div>
      </div>
	    <div class="hidden-xs col-sm-4 col-sm-offset-2 fletcher">
	      <img src="/wp-content/themes/DealerInspireDealerTheme/images/fletcherjones.png" alt="Fletcher Jones Portrait" />
	    </div>
    </div>
  </div>
</div>


<?php get_template_part('partials/homepage/homecontent-getdirections'); ?>
