<footer id="footer" class="footerRow">
	<!-- Include Mobile Redev #mobileHours section on the footer -->
	<?php get_shared_homepage_template('hours-mobile-footer'); ?>

	<section class="footerBottom">
		<div class="container-wide">
            <a trid="f40b2d68684141a1a3630e" trc class="link__logo" href="<?php echo home_url(); ?>">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png?ver=<?php echo filemtime( get_stylesheet_directory().'/images/logo.png');?>"  alt="%%di_name%%">
            </a>
            <div class="social" data-testid="social">
                <?php get_template_part('partials/social/links', 'iconfont'); ?>
            </div>
			<div id="disclaimer">
			<p>Number One Claim based on Calendar Year 1999 - 2024, per MBUSA Nation New Vehicle Sales Reporting.</p>
            <p>Number One Claim based on Audi USA New Sales Results 12/31/24.</p>
			</div>
			<div class="infoWrapper">
				<div class="infoWrapper__copyright">
					<?= __("Copyright", "dealertheme"); ?> &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
				</div>
				<div class="infoWrapper__menu">
					<?php $defaults = array(
						'theme_location'	=> 'footer-menu',
						'container'		=> '',
						'container_class' => '',
						'container_id'	=> '',
						'menu_class'		=> '',
						'menu_id'			=> '',
						'echo'			=> true,
						'fallback_cb'		=> 'wp_page_menu',
						'before'			=> '',
						'after'			=> '',
						'link_before'		=> '',
						'link_after'		=> '',
						'items_wrap'		=> '<ul id="%1$s">%3$s</ul>',
						'depth'			=> 0,
						'walker'			=> ''
					); ?>
					<?php wp_nav_menu( $defaults ); ?>
				</div>
				<div class="infoWrapper__di">
					<?= __("Advanced Automotive Dealer Websites by", "dealertheme"); ?> <a trid="1777b7b5c043403abeedb9" trc href="https://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
				</div>
			</div>
            <a trid="f490d3bb21d14990bbd08f" trc class="button email-button text-center hidden-xs" type="button" href="/email-us/">Sign Up for Email Updates</a>
		</div>
	</section>

</footer>
