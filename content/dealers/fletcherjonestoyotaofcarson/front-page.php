<?php /*
    Home page of the site
*/ get_header(); ?>

 	
<main id="main-content">

    <div class="visible-xs">
        <!-- DEFAULT MOBILE HOMEPAGE -->
        <?php get_template_part('partials/homepage/mobile/open-hours'); ?>
    </div>
    <section id="homepage-section hero-section">
        <?php echo do_shortcode('[di-slider name="Toyota-1920x614"]'); ?>
        <div class="row pzRow">
            <div class="col-sm-12">
                <?php get_template_part('partials/homepage/personalizer-key'); ?>
            </div>
        </div>
    </section>
    <?php get_template_part('partials/dealer-groups/toyota/toyotaexample2/cta-row'); ?>
    <?php do_action('di_toyota_section', 'model-row-3'); ?>

    <?php
// *************************************************************************************************
//	Content Row
// *************************************************************************************************
?>

    <section  class="blockSection contentRow">
        <div class="container-wide topWrapper">
            <h2 class="blockSection__heading"><?= __('Why Choose Fletcher Jones', 'dealertheme') ?></h2>
        </div>
        <div class="container-wide bottomWrapper">
            <div class="row contentOuter">
			    <div class="ctaCarousel swiper-container">
				    <div class="swiper-wrapper">
                        <?php if (have_rows('content9_row')):
                          $count = 1;

                          while (have_rows('content9_row')):

                            the_row();

                            $contentimage = get_sub_field('content9_image');
                            $contenttitle = get_sub_field('content9_title');
                            $contenttext = get_sub_field('content9_text');
                            ?>

                            <div class="contentItem swiper-slide contentItem-<?= $count ?>">
                                <div class="contentItem__image">
                                    <picture>
                                        <img
                                            src="<?php echo $contentimage['sizes']['thumbnail']; ?>"
                                            alt="<?php
                            // No Alt text because the image is decorative
                            ?>"
                                            width=""
                                            height="100" />
                                    </picture>
                                </div>
                                <div class="contentItem__title">
                                    <h3><?= $contenttitle ?></h3>
                                </div>
                                <div class="contentItem__text">
                                    <?= $contenttext ?>
                                </div>
                            </div>

                        <?php $count++;
                          endwhile;
                        endif; ?>
                    </div>
			    </div>
            </div>
            <div class="blockSection__navigation ctaWrapper__navigation">
                <div trid="e25507197cea4cedbc6417" trc class="swiper-button-prev cta swiper-button-black"></div>
                <div trid="6d53ec361bb349958f9cbb" trc class="swiper-button-next cta swiper-button-black"></div>
            </div>
            <div class="blockSection__cta bottomWrapper__buttonWrap">
			    <a trid="e6a19ffbb5da448ea43af9" trc href="<?php the_field(
         'content9_link_url',
       ); ?>" class="button primary-button" <?php if (
  get_field('open_in_new_tab') == true
) { ?> target="_blank" <?php } ?>><?php the_field('content9_link_text'); ?></a>
		    </div>
        </div>
    </section>


    <?php
// *************************************************************************************************
//	Content Service Row
// *************************************************************************************************
//	:: NOTES ::
//	USING ACF'S (DEFAULT TEXT FILLED OUT)
//	SERVICE LINK ONLY SHOWS IF SERVICE LINK IS FILLED OUT.
?>

    <section id="serviceRow" class="serviceRow blockSection">
        <div class="container-wide">
            <h2 class="blockSection__heading"><?php echo get_field('service_header') ?: 'Service Your Vehicle'; ?></h2>
            <h3 class="blockSection__sub"><?php echo get_field('service_subheader') ?:
              'Our trained staff can fix or repair your car and get you back on the road. '; ?></h3>

            <?php if (have_rows('service_buttons')): ?>

                <div class="serviceRow__buttons">

                    <?php while (have_rows('service_buttons')):

                      the_row();
                      $service_link_text = get_sub_field('service_link_text');
                      $service_link = get_sub_field('service_link');
                      ?>
                        <a trid="b36a8b153d5146bda3809f" trc href="<?php echo $service_link; ?>" class="button primary-button custom-button"><?php echo $service_link_text; ?></a>
                    <?php
                    endwhile; ?>

                </div>

            <?php endif; ?>

            <div class="serviceRow__imageWrap">
                <div class="serviceRow__imageWrap--1 lazy-background hidden-sm hidden-xs" style="background-image: url('<?php // Checking for ACF, then DT image, then defaults to AWS image if others do not exist
                if (get_field('service_row_image')):
                  echo get_field('service_image_1');
                elseif (
                  file_exists(
                    DI_ROOT . '/dealer-inspire/wp-content/themes/DealerInspireDealerTheme/images/bg-service-1.jpg',
                  )
                ):
                  echo get_stylesheet_directory_uri(); ?>/images/bg-service-1.jpg<?php
                else:
                  echo 'https://dealerinspire-shared-assets.s3.amazonaws.com/public/oem/toyota/template2/bg-service-1.jpg';
                endif; ?>');">
                </div>
                <div class="serviceRow__imageWrap--1 lazy-background visible-sm visible-xs" style="background-image: url('<?php // Checking for ACF, then DT image, then defaults to AWS image if others do not exist
                if (get_field('service_row_image')):
                  echo get_field('service_image_1');
                elseif (
                  file_exists(
                    DI_ROOT .
                      '/dealer-inspire/wp-content/themes/DealerInspireDealerTheme/images/bg-service-1-mobile.jpg',
                  )
                ):
                  echo get_stylesheet_directory_uri(); ?>/images/bg-service-1-mobile.jpg<?php
                else:
                  echo 'https://dealerinspire-shared-assets.s3.amazonaws.com/public/oem/toyota/template2/bg-service-1.jpg';
                endif; ?>');">
                </div>
            </div>
        </div>
    </section>

    <?php
    // *************************************************************************************************
    //	CTA Row
    // *************************************************************************************************

    $cta_1_image = get_field('first_cta_background_image');
    $cta_1_image_mobile = get_field('first_cta_background_image_mobile');

    $cta_3_image = get_field('third_cta_background_image');
    $cta_3_image_mobile = get_field('third_cta_background_image_mobile');

    $cta_4_image = get_field('fourth_cta_background_image');
    $cta_4_image_mobile = get_field('fourth_cta_background_image_mobile');
    ?>

    <section class="ctaRow blockSection">
        <div class="container-wide">
            <div class="row">
                <div class="col-sm-12 col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box small">
                                        <a trid="31f204b848a54de98fdac1" trc href="<?= the_field(
                                          'first_cta_button_link',
                                        ) ?>" class="" data-is_cta="<?= the_field('first_cta_is_cta') ?>">
                                            <div class="box__image">
                                                <picture>
                                                    <source
                                                        media="(max-width: 767px)"
                                                        srcset="<?php echo $cta_1_image_mobile
                                                          ? $cta_1_image_mobile['sizes']['smallBB']
                                                          : $cta_1_image['sizes']['mediumBB']; ?> 767w">
                                                    <img
                                                        src="<?php echo $cta_1_image['sizes']['mediumBB']; ?>"
                                                        alt="<?php
// No alt text - image is decorative
?>"
                                                        loading="lazy"
                                                        width="670"
                                                        height="250" />
                                                </picture>
                                            </div>
                                            <div class="box__info">
                                                <div class="box__info--title">
                                                    <h3>
                                                        <?= the_field('first_cta_title') ?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box wide">
                                <a trid="3d7d779102824ae1bc7765" trc href="<?= the_field(
                                  'third_cta_button_link',
                                ) ?>" class="" data-is_cta="<?= the_field('third_cta_is_cta') ?>">
                                                <?= the_field('third_cta_button_title') ?>
                                    <div class="box__image">
                                        <picture>
                                            <source
                                                media="(max-width: 767px)"
                                                srcset="<?php echo $cta_3_image_mobile
                                                  ? $cta_3_image_mobile['sizes']['mediumBB']
                                                  : $cta_3_image['sizes']['mediumBB']; ?> 767w">
                                            <img
                                                src="<?php echo $cta_3_image['sizes']['mediumBB']; ?>"
                                                alt="<?php
// No alt text - image is decorative
?>"
                                                loading="lazy"
                                                width="670"
                                                height="250" />
                                        </picture>
                                    </div>
                                    <div class="box__info">
                                        <div class="box__info--title">
                                            <h3>
                                                <?= the_field('third_cta_title') ?>
                                            </h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-12 col-sm-6">
                    <div class="box big">
                        <a trid="a428aad5818241eb9f1a63" trc href="<?= the_field(
                          'fourth_cta_button_link',
                        ) ?>" class="" data-is_cta="<?= the_field('fourth_cta_is_cta') ?>">
                                        <?= the_field('fourth_cta_button_title') ?>
                            <div class="box__image">
                                <picture>
                                    <source
                                        media="(max-width: 767px)"
                                        srcset="<?php echo $cta_4_image_mobile
                                          ? $cta_4_image_mobile['sizes']['mediumBB']
                                          : $cta_4_image['sizes']['mediumBB']; ?> 767w">
                                    <img
                                        src="<?php echo $cta_4_image['sizes']['mediumBB']; ?>"
                                        alt="<?php
// No alt text - image is decorative
?>"
                                        loading="lazy"
                                        width="670"
                                        height="465" />
                                </picture>
                            </div>
                            <div class="box__info">
                                <div class="box__info--title">
                                    <h3>
                                        <?= the_field('fourth_cta_title') ?>
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <?php get_template_part('partials/dealer-groups/toyota/toyotaexample2/reviews-row'); ?>
    <?php get_template_part('/partials/dealer-groups/toyota/toyotaexample3/seo-row'); ?>
    <?php get_template_part('/partials/dealer-groups/toyota/toyotaexample3/map-row'); ?>

</main>

<?php get_footer(); ?>
