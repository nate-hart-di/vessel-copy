<div class="hidden-xs">
	<?php // get_template_part('partials/prefooters/footer','threefifthstwofifths'); ?>
</div>

<div id="footer">
	<div class="container-wide">
		<div class="row">

			<div class="col-sm-3 footer-left footer-middle hidden-xs">
				<?php $defaults = array(
					'theme_location'  => 'footer-menu',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul id="%1$s">%3$s</ul>',
					'depth'           => 0,
					'walker'          => ''
				); ?>
				<?php wp_nav_menu( $defaults ); ?>
			</div>

			<div class="col-sm-6 footer-middle">
				<span class="copyright">
                <h2>This footer brought to you by Vessel!</h2>
					Copyright &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
				</span>
			</div>

			<div class="col-sm-3 footer-right hidden-xs">
				<span class="di-version">
					Advanced Automotive Dealer Websites by <a trid="96977b7f91bc49ee801079" trc href="https://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
				</span>
			</div>

		</div>
	</div>
</div>
