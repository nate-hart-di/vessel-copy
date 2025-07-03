<div id="footer" class="visible-lg visible-md visible-xl">
	<div class="container-wide">
		<div class="row">
            <div class="col-sm-12 give-way">
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
 ); ?><br />Advanced Automotive Dealer Websites by <a trid="bfb5f14d8a5340868817af" trc href="http://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
				</span>
			</div>
		</div>
	</div>
</div>

<div id="footer" class="visible-sm visible-xs">
    <div class="container-wide">
        <div class="row">
            <div class="col-md-4 col-sm-12 footer-middle">
                <img src="<?= get_stylesheet_directory_uri() ?>/images/fj-mercedes-benz-logo.png" alt="Fletcher Jones Mercedes Benz Logo" />
                <img src="<?= get_stylesheet_directory_uri() ?>/images/fj-used-logo.png" alt="Fletcher Jones Used Cars & Truck Center Logo" />
                <img src="<?= get_stylesheet_directory_uri() ?>/images/fj-imports-logo.png" alt="Fletcher Jones Imports Logo" />
            </div>
            <div class="col-md-4 col-sm-12 give-way">
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
 ); ?><br />Advanced Automotive Dealer Websites by <a trid="1eade55af0794d45816c49" trc href="http://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a>
				</span>
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
