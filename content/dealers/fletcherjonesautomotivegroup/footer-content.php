<div class="hidden-xs">
	<?php
// get_template_part('partials/prefooters/footer','threefifthstwofifths');
?>
</div>

<div id="footer">
	<div class="container-wide">
		<div class="row">
		
			<div class="col-sm-12 footer-middle">				
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
				<span class="copyright">
					Copyright &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo(
   'name',
 ); ?> | Advanced Automotive Dealer Websites by <a trid="5abaf275ba114587a100ad" trc href="http://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
				</span>
			</div>
		</div>
	</div>
</div>