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
        <div class="row">
            <div class="social" data-testid="social">
                <?php get_scoped_template_part('partials/social/links', 'iconfont', [
                  'sorting' => 'facebook,twitter,instagram,youtube-play',
                ]); ?>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-12 visible-xs">
            <div class="footer-middle">

                <img id="footer-tristar" data-original="<?php echo '/wp-content/plugins/vessel/content/shared/images/logos/footer-tristar.png'; ?>">

                <div class="mobile-menu">
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
                    <span class="di-version hidden-xs">
                        Advanced Automotive Dealer Websites by <a trid="5f0cb128fdee4b1ab54202" trc href="http://www.dealerinspire.com" target="_blank">Dealer&nbsp;Inspire</a> <?php echo defined(
                          'ENVIRONMENT',
                        ) && constant('ENVIRONMENT') != 'production'
                          ? constant('DI_VERSION')
                          : ''; ?>
                    </span>
                </div>

                <a trid="248f2825a7554f168a7140" trc href="/new-vehicles/amg/">
                    <img data-original="/wp-content/plugins/vessel/content/shared/images/logos/amg-footer.png" alt="AMG" id="footer-amg">
                </a>
            </div>
        </div>
    </div>
</div>