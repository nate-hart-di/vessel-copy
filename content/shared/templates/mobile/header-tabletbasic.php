<?php /*
integrated header and navigation
*/
$link = get_option('di_mobile_header_link');
$phone_link = (isset($phone_link) && !empty($phone_link)) ? $phone_link : false;
$map_link = (isset($map_link) && !empty($map_link)) ? $map_link : false;
?>

<div id="tablet-basic-header" class="menu-top">
    <div class="tablet-header-content">
        <a trid="be859d1cf7c74eeeaabd23" trc class="mobile-menu-toggle menu-hamburger" href="#mobile-nav-menu" data-gtm-event="tabletHeaderHamburger">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-label">MENU</span>
        </a>
        <span class="logo" itemscope itemtype="http://schema.org/Organization">
    <a trid="c994248dc00842c1860825" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="tabletHeaderLogo">
      <img itemprop="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-head-mobile.png" alt="<?php echo get_bloginfo('title'); ?>">
    </a>
    <?php if (get_field('vessel_header_image', 'option')): ?>
        <img id="vessel-header-img" src="<?= get_field('vessel_header_image', 'option'); ?>" alt="Custom Header Image">
    <?php endif; ?>
  </span>

        <?php do_action( 'before_tablet_menu_icons', get_the_ID() ); ?>

        <div class="info">
            <ul>
                <li>

                    <?php if($phone_link) { ?>
                    <a trid="4e7ccd5c8177406d98f5e4" trc href="<?php echo $phone_link;?>" data-gtm-event="tabletHeaderPhone">
                        <?php } else {
                        $phone = get_option('di_phone');
                        if(empty($phone)) {
                            $phone = get_option('di_phone_sales');
                        } ?>
                        <a trid="c2ab08d9cc0746b0b9c80f" trc data-phone="Sales" itemprop="phone" href="tel:<?php echo str_replace(array(" ","-","(",")","."),"",$phone); ?>" rel="nofollow" data-gtm-event="tabletHeaderPhone">
                            <?php } ?>
                            <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><span class="text"><?php echo get_option('di_phone'); ?></span>
                        </a>
                </li>
                <li>
                    <?php if($map_link) {?>
                    <a trid="ace78e8c54df4531b6eec8" trc href="<?php echo $map_link;?>" data-gtm-event="tabletHeaderDirections">
                        <?php } else { ?>
                        <a trid="ba138d1cc7254bb6adbfbe" trc target="_blank" itemprop="directions" href="<?php echo get_option('di_google_map'); ?>" data-gtm-event="tabletHeaderDirections">
                            <?php } ?>

                            <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span><span class="text">Get Directions</span>
                        </a>
                </li>
            </ul>
        </div>

        <?php do_action( 'after_tablet_menu_icons', get_the_ID() ); ?>

        <?php
        //kept for backwards compatibility
        ob_start();
        if (class_exists('DIContactAtOnce') && DIContactAtOnce::get()->is_enabled() && DIContactAtOnce::get()->is_placement_set('mobile')): ?>
            <span class="mobile-chat" data-gtm-event="tabletHeaderChat">
    <?php DIContactAtOnce::get()->chatbutton('<img src="'.get_stylesheet_directory_uri().'/images/mobile-chat.png" alt="Find Us">', '', TRUE); ?>
  </span>
        <?php endif;
        $mobile_chat_code = ob_get_contents();
        ob_end_clean();

        //The new code
        echo apply_filters('mobilechat', $mobile_chat_code,array(
            'chat'=>array('container_class'=>'visible-xs visible-sm mobile-chat', 'html_button'=>'<span class="glyphicon glyphicon-comment" aria-hidden="true"></span><span class="icon-label">CHAT</span>'),
            'text'=>array('container_class'=>'visible-xs mobile-text', 'html_button'=>'span class="glyphicon glyphicon-phone" aria-hidden="true"></span><span class="icon-label">TEXT</span>')
        ));
        ?>
    </div>
</div>

<div class="fixed-top-spacer"></div>
<?php do_action('tablet_after_header') ?>
