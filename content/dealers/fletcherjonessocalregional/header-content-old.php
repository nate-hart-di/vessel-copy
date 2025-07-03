<div id="header">
    <div class="header-top">
        <div class="quicklinks" >
        <?php $defaults = [
          'theme_location' => 'quick-links',
          'container' => '',
          'container_class' => '',
          'container_id' => '',
          'menu_class' => '',
          'menu_id' => '',
          'echo' => true,
          'fallback_cb' => false,
          'before' => '',
          'after' => '',
          'link_before' => '',
          'link_after' => '',
          'items_wrap' => '<ul id="%1$s">%3$s</ul>',
          'depth' => 1,
          'walker' => '',
        ]; ?>
        <?php wp_nav_menu($defaults); ?>
        </div>
    </div>
    <div class="header-bottom">
        <div class="header-left">
        	<div class="logo" itemscope itemtype="http://schema.org/Organization">
        		<a trid="3fdb241caf8f4382a4a411" trc itemprop="url" href="<?php echo home_url(); ?>"><img itemprop="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png?ver=<?php echo filemtime(
  get_stylesheet_directory() . '/images/logo.png',
); ?>" alt="<?php echo get_bloginfo('title'); ?>"></a>
                <?php if (get_field('vessel_header_image', 'option')): ?>
                    <img id="vessel-header-img" src="<?= get_field(
                      'vessel_header_image',
                      'option',
                    ) ?>" alt="Custom Header Image">
                <?php endif; ?>
        	</div>
        </div>
        <div class="header-mid">
            <div class="menu-bar">
                <div id="main-navbar" class="navbar flex hidden-sm hidden-xs">
                    <div class="navbar-inner">
                        <div class="nav_section">
                            <ul id="menu-top-menu" class="nav">
                                <?php
                                $items = wp_get_nav_menu_items('main-menu');
                                foreach ($items as $i => $menu_item) {

                                  $class = $menu_item->classes['0'];
                                  $link = '';
                                  $additionalClasses = '';
                                  $label =
                                    $menu_item->attr_title != ''
                                      ? str_replace(' Vehicles', '', $menu_item->attr_title)
                                      : str_replace(' Vehicles', '', $menu_item->title);
                                  if ($class == '' || in_array('hide-submenu', $menu_item->classes)) {
                                    $link = '<a trid="d07e5b0c6c584a78b0ea76" trc href="' . $menu_item->url . '">';
                                    $link = $link . $label . '</a>';
                                    // $additionalClasses = in_array("hide-submenu", $menu_item->classes) ? 'hide-submenu' : '';
                                  } else {
                                    $link = '<a trid="7f86da423c504af6a5b3f5" trc>' . $label . '</a>';
                                  }
                                  ?>
                                <li class="menu-item <?php echo implode(' ', $menu_item->classes); ?>"> 
                                    <?php echo $link; ?>
                                    <?php if ($class != '' || in_array('hide-submenu', $menu_item->classes)): ?>
                                    <div class="header-dropdown dropdown-full <?php echo $class; ?>">
                                        <div class="header-dropdown-container">
                                            <div class="menu-navigation">

                                                <h2> <?= $menu_item->attr_title != ''
                                                  ? $menu_item->attr_title
                                                  : $menu_item->title ?> </h2>
                                                <?php if (is_active_sidebar($class . '-menu-sidebar')) {
                                                  dynamic_sidebar(ucfirst($class) . ' Menu Sidebar');
                                                } ?>
                                            </div>

                                            <div class="menu-image-sidebar">
                                                <?php
                                                $menuad = get_field($class . '_menu_ad', 3);
                                                $menuadlink = get_field($class . '_menu_ad_link', 3);

                                                if (!empty($menuad)): ?>

                                                <a trid="be9f2f90dc2b4a48bef4b2" trc href="<?php echo $menuadlink; ?>">
                                                    <img src="<?php echo $menuad['url']; ?>" alt="<?php echo $menuad[
  'alt'
]; ?>" />
                                                </a>

                                            <?php endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </li>
                            <?php
                                }
                                ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="header-right">
        <?php
        $nav_image = get_field('header_nav_image', 'option');
        $nav_image_link = get_field('header_nav_image_link', 'option');
        if ($nav_image): ?>
                <div class="header-ad-image">
                    <a trid="a9dedea7255647c5a9fc00" trc href="<?php echo $nav_image_link; ?>" >
                        <img src="<?php echo $nav_image['url']; ?>" alt="<?php echo $nav_image['alt']; ?>" />
                    </a>
                </div>
                <?php endif;
        ?>
        <a trid="095e4763162d4f3bbfdf2b" trc id="mobile-menu-toggle" class="menu-hamburger visible-sm visible-xs" data-side="right" data-container="mobile-menu" data-gtm-event="mobileHeaderHamburger">
            <i class="fa fa-bars"></i>
        </a>
        </div>
    </div>
    <div id="mobile-menu" class="mobile-nav-menu sidebar-navigation-enabled" style="display: none;">
        <div class="menu-row">
            <div class="menu-span">
                <div class="navbar">
                    <div class="navbar-inner">
                        <?php $nav_menu_settings = [
                          'theme_location' => isset($theme_location) ? $theme_location : 'mobile-menu',
                          'container' => false,
                          'menu_class' => isset($menu_class) ? $menu_class : 'nav',
                          'echo' => true,
                          'fallback_cb' => 'wp_page_menu',
                          'depth' => isset($depth) ? $depth : 3,
                          'walker' => isset($walker) ? $walker : new wp_bootstrap_navwalker(),
                        ]; ?>
                        <div class="nav_section">
                            <?php DIFunctions::nav_menu($nav_menu_settings, 'mobile'); ?>
                        </div>
                        <?php do_action('after_mobile_menu'); ?>
                        <?php apply_filters('after_offcanvas_mobile_nav', ''); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fixed-top-spacer hidden-sm hidden-xs">
</div>


<div id="sidr-desktop-locations" class="mobile-nav-menu sidebar-navigation-enabled" style="display: none;">
	<div class="menu-row">
		<div class="menu-span">
			<?php if (is_active_sidebar('locations-tab')) {
     dynamic_sidebar('Locations Tab');
   } ?>
		</div>
	</div>
</div>

<div id="menu-overlay">
	<div class="overlay-container">
        <span class="menu-close-overlay">
     	   <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close-button.png" alt="Close" />
        </span>
		<div class="overlay-content">
		</div>
	</div>
</div>

<div id="norcal-overlay" class="hidden-all">
    <h2>Northern California</h2>
    <div class="vehicle-card">
        <a trid="4f62b15145ba4cdcaf4914" trc href="/new-vehicles/northern-california/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/buy.jpeg" alt="Buy" />
        </a>
        <a trid="5ed624d5562642c29d1607" trc href="/new-vehicles/northern-california/" class="button primary-button block">
         Buy
        </a>
    </div>
    <div class="vehicle-card">
        <a trid="8b390732d85e4e3b99905a" trc href="/service/">
            <img src="/wp-content/plugins/vessel/content/dealers/fletcherjonessocalregional/images/service.jpg" alt="Service" />    
        </a>
        <a trid="b7ccedab11d840d9bea6f2" trc href="/service/" class="button primary-button block">
    	 Service
        </a>
    </div>
</div>

<div id="socal-overlay" class="hidden-all">
    <h2>Southern California</h2>
    <div class="vehicle-card">
        <a trid="6e47be9c832c49edb82f01" trc href="/new-vehicles/southern-california/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/socal-buy.jpg" alt="Buy" />
        </a>
        <a trid="2e7f3cc95b25445d90c28a" trc href="/new-vehicles/southern-california/" class="button primary-button block">
         Buy
        </a>
    </div>
    <div class="vehicle-card">
        <a trid="fc067b55f06a4dd08dfdd6" trc href="/service/">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/service.jpeg" alt="Service" />            
        </a>
        <a trid="4e697cc36b114077a126ef" trc href="/service/" class="button primary-button block">
         Service
        </a>
    </div>
</div>



<div id="both-new-overlay" class="hidden-all">
    <h2>New Vehicles</h2>
    <div class="vehicle-card">
        <a trid="ae934f5209244cd09b6b0a" trc href="/new-vehicles/northern-california/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/new-norcal.jpg" alt="Buy" />
        </a>
        <a trid="4ed671f4456747e09f3e4a" trc href="/new-vehicles/northern-california/" class="button primary-button block">
        Northern California
        </a>
    </div>
    <div class="vehicle-card">
        <a trid="21fbf41945c04de9800f68" trc href="/new-vehicles/southern-california/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/new-socal.jpg" alt="Service" />
        </a>
        <a trid="21fcef3cb76948a0af009f" trc href="/new-vehicles/southern-california/" class="button primary-button block">
         Southern California
        </a>
    </div>
</div>


<div id="both-used-overlay" class="hidden-all">
    <h2>Used Vehicles</h2>
    <div class="vehicle-card">
        <a trid="aa834fbfb8f140519d5dca" trc href="/used-vehicles/northern-california/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/preowned-norcal.jpg" alt="Preowned NorCal Vehicles" />
        </a>
        <a trid="cf93b2cf7c104a37abad3f" trc href="/used-vehicles/northern-california/" class="button primary-button block">
         Northern California
        </a>
    </div>
    <div class="vehicle-card">
        <a trid="8d2c4703d5b842dcaa2c43" trc href="/used-vehicles/southern-california/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/preowned-socal.jpg" alt="Preowned SoCal Vehicles" />
        </a>
        <a trid="8009b28929f544be8905a7" trc href="/used-vehicles/southern-california/" class="button primary-button block">
         Southern California
        </a>
    </div>
</div>


<div id="about-overlay" class="hidden-all">
    <h2>Learn More</h2>
    <div class="vehicle-card">
        <a trid="6e0ea2b254824dee979bd2" trc href="/contact-news/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-left.jpg" alt="About Left Image" />
        </a>
        <a trid="c469f78cf1cc4869857b4b" trc href="/contact-news/" class="button primary-button block"> Contact & News </a>
    </div>
    <div class="vehicle-card">
        <a trid="7f6e15555afe4d628bd455" trc href="/fj-careers/" class="">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-right.jpg" alt="About Right Image" />
        </a>
        <a trid="3ac53b57f54e45ceb25ce8" trc href="/fj-careers/" class="button primary-button block"> Legacy & Careers </a>
    </div>
</div>