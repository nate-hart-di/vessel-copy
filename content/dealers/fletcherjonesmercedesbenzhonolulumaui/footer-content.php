<footer id="footer" class="footerRow">
	<!-- Include Mobile Redev #mobileHours section on the footer -->
	<?php get_shared_homepage_template('hours-mobile-footer'); ?>
	<div id="footerMobile" class="footerTop visible-xs">
        <div class="container">
            <div class="row">
                <div class="footerTop__Menu">
                    <?php $defaults = [
                      'theme_location' => 'mobile-footer-menu',
                      'container' => '',
                      'container_class' => '',
                      'container_id' => '',
                      'menu_class' => '',
                      'menu_id' => '',
                      'echo' => true,
                      'fallback_cb' => 'wp_page_menu',
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
        </div>
    </div>

	<section class="footerBottom">
		<div class="container-wide">
            <a trid="3f9aadd67ad04a3ea2206f" trc class="link__logo" href="<?php echo home_url(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="%%di_name%%">
            </a>
            <div class="social" data-testid="social">
                <?php get_template_part('partials/social/links', 'iconfont'); ?>
            </div>
			<div class="infoWrapper">
				<div class="infoWrapper__copyright">
					<?= __('Copyright', 'dealertheme') ?> &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
				</div>
				<div class="infoWrapper__menu">
					<?php $defaults = [
       'theme_location' => 'footer-menu',
       'container' => '',
       'container_class' => '',
       'container_id' => '',
       'menu_class' => '',
       'menu_id' => '',
       'echo' => true,
       'fallback_cb' => 'wp_page_menu',
       'before' => '',
       'after' => '',
       'link_before' => '',
       'link_after' => '',
       'items_wrap' => '<ul id="%1$s">%3$s</ul>',
       'depth' => 0,
       'walker' => '',
     ]; ?>
					<?php wp_nav_menu($defaults); ?>
				</div>
				<div class="infoWrapper__di">
					<?= __(
       'Advanced Automotive Dealer Websites by',
       'dealertheme',
     ) ?> <a trid="728245d4834c4b019815aa" trc href="https://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
				</div>
			</div>
            <a trid="17d0a38815cf4922a821d3" trc class="button email-button text-center hidden-xs" type="button" href="/email-us/">Sign Up for Email Updates</a>
		</div>
	</section>

</footer>
