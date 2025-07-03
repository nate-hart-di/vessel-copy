<?php /*
	Basic Mobile Header - Optional Icon Labels
	$phone_numbers = array('Sales' => array('option_slug' => 'di_phone_sales', 'gtm_event' => 'mobileHeaderPhoneSales', 'fa_icon' => 'fa-tags' ));
*/
$link = get_option('di_mobile_header_link');
$showtitle = get_option('di_show_header_titles',false);

$phone_numbers = (isset($phone_numbers) && !empty($phone_numbers)) ? $phone_numbers : false;

$phone_link = (isset($phone_link) && !empty($phone_link)) ? $phone_link : false;
$map_link = (isset($map_link) && !empty($map_link)) ? $map_link : false;
$mobile_menu_toggle_attrs  = (isset($mobile_menu_toggle_attrs ) && !empty($mobile_menu_toggle_attrs )) ? $mobile_menu_toggle_attrs  : false;
?>


<div class="menu-top <?php echo $showtitle ? ' with-labels' : ''; ?>">
    <a trid="51e0fc4e2d1746cd8e17b0" trc class="mobile-menu-toggle menu-hamburger" href="#mobile-nav-menu" data-gtm-event="mobileHeaderHamburger" <?php if($mobile_menu_toggle_attrs ){ echo $mobile_menu_toggle_attrs; } ?> >
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-label">MENU</span>
    </a>
    <span class="logo" itemscope itemtype="http://schema.org/Organization">
		<a trid="aa2a4d72bd83497b9e8256" trc itemprop="url" href="<?php echo home_url(); ?>" data-gtm-event="mobileHeaderLogo">
			<img itemprop="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-head-mobile.png" alt="<?php echo get_bloginfo('title'); ?>">
		</a>
        <?php if (get_field('vessel_header_image', 'option')): ?>
            <img id="vessel-header-img" src="<?= get_field('vessel_header_image', 'option'); ?>" alt="Custom Header Image">
        <?php endif; ?>
	</span>

    <?php do_action( 'before_mobile_menu_icons', get_the_ID() ); ?>

    <span class="menu-phone">
		<?php if($phone_link) { ?>
        <a trid="149bf3e987974872a662d7" trc href="<?php echo $phone_link;?>" data-gtm-event="mobileHeaderPhone">
		<?php } else {
        $phone = get_option('di_phone');
        if(empty($phone)) {
            $phone = get_option('di_phone_sales');
        } ?>
            <a trid="32dcceb33be047fc9c369d" trc data-phone="Sales" itemprop="phone" href="tel:<?php echo str_replace(array(" ","-","(",")","."),"",$phone); ?>" rel="nofollow" data-gtm-event="mobileHeaderPhone">
		<?php } ?>
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
		</a>
		<span class="icon-label"><?php echo __(apply_filters('header-mobilebasic_call_label','CALL US'),'commontheme'); ?></span>
	</span>

    <span class="menu-directions">
		<?php if($map_link) {?>
        <a trid="6fccc8bae0704906a47916" trc href="<?php echo $map_link;?>" data-gtm-event="mobileHeaderDirections">
		<?php } else { ?>
            <a trid="72f0a6e3b15349daadd93c" trc target="_blank" itemprop="directions" href="<?= ( function_exists('google_map_mobile_link') ) ? google_map_mobile_link() : get_option('di_google_map'); ?>" data-gtm-event="mobileHeaderDirections">
		<?php } ?>
                <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
		</a>
		<span class="icon-label"><?php echo __(apply_filters('header-mobilebasic_directions_label','FIND US'),'commontheme'); ?></span>
	</span>

    <?php do_action( 'after_mobile_menu_icons', get_the_ID() ); ?>

    <?php
    //kept for backwards compatibility
    ob_start();
    if (DIContactAtOnce::get()->is_enabled() && DIContactAtOnce::get()->is_placement_set('mobile')): ?>
        <span class="mobile-chat" data-gtm-event="mobileHeaderChat">
		<?php DIContactAtOnce::get()->chatbutton('<img src="'.get_stylesheet_directory_uri().'/images/mobile-chat.png" alt="Find Us">', '', TRUE); ?>
	</span>
    <?php endif;
    $mobile_chat_code = ob_get_contents();
    ob_end_clean();

    echo apply_filters('mobilechat', $mobile_chat_code,array(
        'chat'=>array('container_class'=>'visible-xs visible-sm mobile-chat', 'html_button'=>'<span class="glyphicon glyphicon-comment" aria-hidden="true"></span><span class="icon-label">CHAT</span>'),
        'text'=>array('container_class'=>'visible-xs mobile-text', 'html_button'=>'<span class="glyphicon glyphicon-phone" aria-hidden="true"></span><span class="icon-label">TEXT</span>')
    ));
    ?>
</div>

<?php if($phone_numbers): ?>

    <div id="pickNumberMobile">

        <?php foreach($phone_numbers as $dept => $phone):
            $number = get_option($phone['option_slug']) ?>

            <div class="option">
                <a trid="a2b27e90d71649259f396a" trc data-phone="<?= $dept ?? 'Sales' ?>" itemprop="phone" href="tel:<?= str_replace(array(" ","-","(",")","."),"",$number); ?>" rel="nofollow" data-gtm-event="<?= $phone['gtm_event'] ?>">Call <?= $dept ?? 'Sales' ?> <i class="fa <?= $phone['fa_icon'] ?>"></i></a>
            </div>

        <?php endforeach ?>

    </div>

    <script type="text/javascript">
      jQuery(document).ready(function($) {
        $(".menu-phone a").attr("href","#");
        // open sales/service number box
        $('.menu-phone').click(function(e) {
          $("#pickNumberMobile").stop(true, true).slideToggle();
          e.stopPropagation();
        });

        // closes sales/service dropdown number box when clicking anywhere outside of box for mobile users
        $(document).click(function () {
          $("#pickNumberMobile:visible").stop(true, true).slideUp();
        });
      });
    </script>

<?php endif ?>

<div class="fixed-top-spacer"></div>
