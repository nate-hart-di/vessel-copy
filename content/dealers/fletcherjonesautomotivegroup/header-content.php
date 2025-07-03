<div class="hidden-sm hidden-xs">
    <div id="header" class="menu-top">
        <div class="header-top">
            <div class="logo" itemscope itemtype="http://schema.org/Organization">
                <a trid="9b442ce997754573b9c18a" trc itemprop="url" href="<?php echo home_url(); ?>">
                    <img itemprop="logo" data-original="<?php 
                    if (get_field("vessel_main_logo", "options")) {
                        $image = get_field("vessel_main_logo", "options");
                        echo $image['url'];
                    } else {
                        echo '/wp-content/plugins/vessel/content/dealers/' . get_option('di_slug') . '/images/logo-head.png'  ?>" alt="<?php echo get_bloginfo('title'); 
                    }
                    ?>">
                </a>
                
            </div>
            <div id="main-navbar" class="navbar flex">
                <div class="navbar-inner">
                    <div class="nav_section">
                        <ul id="menu-top-menu" class="nav">
                            <?php
                            $items = wp_get_nav_menu_items('main-menu');
                            foreach($items as $i => $menu_item) {
                                $class = $menu_item->classes['0'];
                                ?>
                                <?php if($menu_item->menu_item_parent == 0) : ?>
                                    <li class="menu-item"><a trid="448273214c0b46a091f812" trc <?php if($class == '' || in_array("hide-submenu", $menu_item->classes)) : ?>href="<?= $menu_item->url ?>"<?php endif; ?>><?php echo str_replace(" Vehicles", "", $menu_item->title); ?></a>
                                        <?php if($class != '' || in_array("hide-submenu", $menu_item->classes)) : ?>
                                            <div class="header-dropdown dropdown-full">
                                                <div class="header-dropdown-container">
                                                    <div class="menu-navigation">

                                                        <h2> <?= $menu_item->attr_title != '' ? $menu_item->attr_title : $menu_item->title; ?> </h2>
                                                        <?php if (is_active_sidebar($class.'-menu-sidebar')) {
                                                            dynamic_sidebar( ucfirst($class).' Menu Sidebar' );
                                                        } ?>
                                                    </div>

                                                    <div class="menu-image-sidebar">
                                                        <?php

                                                        $menuad = get_field($class . '_menu_ad', 3);
                                                        $menuadlink = get_field($class . '_menu_ad_link', 3);

                                                        if(!empty($menuad)): ?>

                                                            <a trid="7ec57c54790b4f2ab6c766" trc href="<?php echo $menuadlink; ?>">
                                                                <img data-original="<?php echo $menuad['sizes']['large']; ?>" alt="<?php echo $menuad['alt']; ?>" />
                                                            </a>

                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
            </div>
            
                <?php if (get_field('header_nav_image', 'option')): ?>
                    <a trid="3e87b18b59c848ed91c0fc" trc href="<?php echo get_field('header_nav_image_link', 'option'); ?>"><img id="vessel-header-img" data-original="<?= get_field('header_nav_image', 'option')['url']; ?>" alt="Custom Header Image"></a>
                <?php endif; ?>
						<a trid="e4551a8c77334f20946aa1" trc id="desktop-locations-toggle" data-side="right" data-container="sidr-desktop-locations" class="locations-toggle menu hidden-xs">Locations <span class="glyphicon glyphicon-map-marker"></span></a>
				</div>
    </div>
    <div class="fixed-top-spacer"></div>
</div>

<?php get_shared_template('homepage/button-overlay'); ?>



<div id="hidden-div" style="display:none;" class="clearfix">

    <div id="saleshours" class="col-md-12">
        <?php
        echo do_shortcode('[dealer_info show_phones="false" show_heading="false" departments="Sales" full_day_string="true" ]');
        ?>
    </div>

    <div id="servicehours" class="col-md-12">

        <?php
        // Testing for Service or Service & Parts
        $hourscheck = DIHoursShortcode::get_day_specific_hours('Service & Parts', 'Monday');
        $hoursheading = "Service & Parts";
        if(empty($hourscheck)) {
            $hourscheck = DIHoursShortcode::get_day_specific_hours('Service', 'Monday');
            $hoursheading = "Service";
        }
        ?>
        <?php
        echo do_shortcode('[dealer_info show_phones="false" show_heading="false" departments="'.$hoursheading.'" full_day_string="true" ]');
         ?>
    </div>
</div>

<div class="visible-sm visible-xs">
  <div id="tablet-mobile-header">
		<a trid="3298045af85445b0879c18" trc id="desktop-menu-toggle" data-side="left" data-container="sidr-desktop-content" class="menu-toggle menu" data-gtm-event="desktopHeaderMenuOpen"><span class="glyphicon glyphicon-align-justify"></span><span class="glyphicon glyphicon-remove"></span>  <span class="menu-label hidden-xs">MENU</span></a>
		<div class="logo" itemscope itemtype="http://schema.org/Organization">
			<a trid="40e851dc8e24431ebc1876" trc itemprop="url" href="<?php echo home_url(); ?>"><img itemprop="logo" id="main-logo" class="hidden-xs" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="<?php echo get_bloginfo('title'); ?>"><img itemprop="logo" class="hidden-sm" id="main-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-head-mobile.png" alt="<?php echo get_bloginfo('title'); ?>"></a>
		</div>

		<div class="text-right">
      <a trid="27de70081d81450d8a01e3" trc id="mobile-locations-toggle" data-side="right" data-container="sidr-desktop-locations"><span class="directions-icon glyphicon glyphicon-map-marker"></span></a>
		</div>
  </div>
</div>

<?php get_scoped_template_part('partials/navigations/offcanvas','nav', array( 'flyout_id' => 'sidr-desktop-content', 'theme_location' => 'main-menu' )); ?>


<div id="sidr-desktop-locations" class="mobile-nav-menu sidebar-navigation-enabled" style="display: none;">
    <div class="menu-row">
        <div class="menu-span">
            <?php if (is_active_sidebar('locations-tab')) {
                dynamic_sidebar( 'Locations Tab' );
            } ?>
        </div>
    </div>
</div>
