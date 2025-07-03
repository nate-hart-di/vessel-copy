<?php /*
	Home page of the site
*/

$feature_button_text = get_field('button_text', 'option');
$feature_button_color = get_field('button_color', 'option');
$fj_blue = '#0059a8';
$button_link = get_field('button_link', 'option');

?>

<div class="visible-xs">
    <div class="overlay-title">
        <?php /* get_template_part('partials/homepage/personalizer-key'); */ ?>
    </div>
        
    <div class="mobile-cta">
        <?php
        if( have_rows( 'mobile_ctas' ) ):
        while ( have_rows( 'mobile_ctas' ) ) : the_row();

        $ctaImage       = get_sub_field( 'image' );
        $ctaLink        = get_sub_field( 'link' );
        $ctaLinkTitle   = get_sub_field( 'button_text' );
        $ctaLinkBG   	= get_sub_field( 'button_background' );
        $ctaLinkColor   	= get_sub_field( 'button_color' );
        ?>

        <div class="ctaItem">
            <img src="<?= $ctaImage['sizes']['large']; ?>" alt="<?= $ctaImage['alt']; ?>" />
            <a trid="e1ee27c0eeab446ab19908" trc href="<?= $ctaLink; ?>" class="button mobile-button" style="background-color:<?= $ctaLinkBG; ?>;color:<?= $ctaLinkColor; ?> !important"><?= $ctaLinkTitle; ?></a>
        </div>

        <?php endwhile; endif; ?>
    </div>

    <div id="mobile-subscribe">
        <?php echo do_shortcode('[gravityform id="153" title="false" description="true"]'); ?>
    </div>
</div>


<div id="videobanner" class="modfull-home hidden-xs">
    <?php get_template_part('partials/sliders/video_fullheight'); ?>
    <div class="gridwrap hidden-sm hidden-xs"> </div>
    <div id="videooverlay">
        <div class="center">
            <div class="row">
                <div class="col-sm-12 overlay-title">
                    <?php get_template_part('partials/homepage/personalizer-key'); ?>
                </div>
                <?php the_field('bottom_text'); ?>
            </div>
            <?php get_homepage_countdown(); ?>

            <div class="container-fluid main-cta-container">
                <div class="videooverlay-contentwrapper hidden-xs">
                    <div class="videooverlay-content">
                        <div class="col-xs-12">
                            <div class="cta-buttons">
                                <?php echo the_field('cta_buttons'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 <a trid="ac625d87a7204397976c57" trc href="/vegas-pre-owned-hispanohablantes/" id="spanishButton">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sehabla.png" alt="Se Habla Español" />
</a>
