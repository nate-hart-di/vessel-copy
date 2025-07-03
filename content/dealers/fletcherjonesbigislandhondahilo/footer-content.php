<div id="prefooter" class="bgimagerow hidden-xs">
  <div class="container-wide">
    <div class="row">
      <div class="col-sm-12">
        <ul class="prefooter-widgets">
          <?php if (is_active_sidebar('pre-footer')) {
            dynamic_sidebar( 'Pre Footer' );
          } ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<div id="footer">
  <div class="container-wide">
    <div class="row">

      <div class="col-sm-3 footer-left hidden-xs">
        <a trid="4fdabf31790b481297674e" trc href="<?php echo get_bloginfo('url'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer-left-logo.png" alt="<?php echo get_bloginfo('title'); ?>" /></a>
      </div>

      <div class="col-sm-6 footer-middle">
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
        <span class="copyright">
          Copyright &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
        </span>
        <span class="di-version">
          Advanced Automotive Dealer Websites by <a trid="ffb5281b552d411c85d2bc" trc href="http://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a> <?php echo (defined('ENVIRONMENT') && constant('ENVIRONMENT') != 'production') ? constant('DI_VERSION') : ''; ?>
        </span>
      </div>

      <div class="col-sm-3 footer-right hidden-xs">
        <a trid="d207c7d44c6947bc9d9ec7" trc href="<?php echo get_bloginfo('url'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/footer-right-logo.png" alt="<?php echo get_bloginfo('title'); ?>" /></a>
      </div>

    </div>
  </div>
</div>
