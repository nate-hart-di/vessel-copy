<?php get_scoped_template_part('/partials/dealer-groups/porsche/header','',
    array( 'phone_department' => 'Sales,Service',
    'schedule_service_link'=>'/service/schedule-porsche-service/',
    'navWalker' => new wp_bootstrap_navwalker()
    )
); ?>

<div id="ask-form">
    <span class="ask-question-btn porsche-ask">Ask A Question</span>
    <?= do_shortcode("[gravityform id='16'/]"); ?>
</div>

<div id="search-overlay">
    <div class="overlay-container">
        <span class="close-overlay">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close" />
        </span>
        <div class="overlay-content">
        </div>
        <div class="search-section" style="display:none">
        <?php
            if ($isTemecula)  {
                ?>
                <form action="/" id="searchform" data-testid="searchform" role="search" method="get">
                    <?php echo do_shortcode('[search_inventory name="search" id="search-anything-field" /]');?>
                </form>
                <?php
            } else {
                ?>
                <?php get_scoped_template_part('partials/search/anything', '', isset($anything)?$anything:array()); ?>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<div id="contact-overlay" class="hidden-all">
    <h2> Contact Us </h2>
    <span class="sales-phone">
        <span class="department">Sales:</span> <span id="phonenumber_sales2"><?php echo do_shortcode('[di_phone option_key="sales" format="withparens" clickable="true" classes="phone"]'); ?></span>
    </span>
    <span class="service-phone">
        <span class="department">Service:</span> <span id="phonenumber_service2"><?php echo do_shortcode('[di_phone option_key="service" format="withparens" clickable="true" classes="phone"]'); ?></span>
    </span>
</div>

<div class="visible-sm">
  <?php get_scoped_template_part('partials/headers/tablet/header','tabletbasic',
  array(
    'use_oem_logo_shortcode' => true,
    'oem_no_space' => true,
    'use_dealer_logo' => false,
	'use_dealer_name_text' => true,
    'oem_logo_brand' => "Porsche"
    )); ?>
</div>

<div class="visible-xs">
  <?php get_scoped_template_part('partials/headers/mobile/header','mobilebasic',
  array(
    'use_oem_logo_shortcode' => true,
    'oem_no_space' => true,
    'use_dealer_logo' => false,
	'use_dealer_name_text' => true,
    'oem_logo_brand' => "Porsche"
    )); ?>
</div>

<div class="visible-sm visible-xs">
      <?php get_scoped_template_part('partials/navigations/offcanvas','nav', array( 'theme_location' => 'main-menu' )); ?>
</div>