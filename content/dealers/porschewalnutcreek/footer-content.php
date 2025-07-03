<footer id="footer">

	<div class="footer-top hidden-xs section-porsche">
		<div class="container-wide">
			<div class="row">
				<div class="col-sm-12">
					<div class="footer-top-inner">
						<?php do_action('footer_left_quick_links'); ?>
						<h2 class="section-title">
							Quick Links
						</h2>
						<?php do_action('footer_right_quick_links'); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<ul class="prefooter-widgets">
					<?php dynamic_sidebar('Footer Horizontal Sidebar'); ?>
				</ul>
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container-wide">

			<div class="footer-social">
				<div class="footer-social-left">
					<h2>Connect With Us</h2>
				</div>
				<div class="footer-social-right">
					<div class="social" data-testid="social">
						<?php get_template_part('partials/social/links', 'iconfont'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-content">
		<div class="container-wide">
			<div class="row">
				<div class="col-md-4 col-sm-12 footer-left">
					<div class="copyright">
						Copyright &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
					</div>
					<div class="location">
						<?php echo get_option('di_street_address'); ?> <?php echo get_option('di_city'); ?>, <?php echo get_option(
  'di_state',
); ?> <?php echo get_option('di_zipcode'); ?>
					</div>
				</div>
				<div class="col-md-4 col-sm-12 footer-middle">
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
				<div class="col-md-4 col-sm-12 footer-right">
					<span class="di-version">
						Advanced Automotive Dealer Websites by <a trid="bf150642fb264cd6a1c854" trc href="https://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
					</span>
				</div>
			</div>
		</div>
	</div>

</footer>