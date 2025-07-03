<div id="footer" class="">
	<div class="container-wide">
		<div class="row">
            <div class="col-xs-12 give-way">
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
					Copyright &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
				</span>
				<span>Advanced Automotive Dealer Websites by <a trid="c78a209655814cab872270" trc href="http://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a></span>
			</div>
		</div>
	</div>
</div>

<div id="floating-social-icons">
    <?php
    $social = [
      'facebook' => '',
      'twitter' => '',
      'google' => '',
      'instagram' => '',
      'linkedin' => '',
      'yelp' => '',
      'youtube' => '',
    ];
    show_social_icons($social);
    ?>
</div>
