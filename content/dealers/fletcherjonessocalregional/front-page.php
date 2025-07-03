<?php /*
	Home page of the site
*/

$feature_button_text = get_field('button_text', 'option');
$feature_button_color = get_field('button_color', 'option');
$fj_blue = '#0059a8';
$button_link = get_field('button_link', 'option');
?>

<?php if (get_field('override_videobanner')) { ?>
<div id="override_videobanner" data-acf="override_videobanner" data-acf-location="Homepage">
  <?php the_field('override_videobanner_content'); ?>
</div>
<?php } else { ?>

<?php if (get_field('header_banner')): ?>
    <div class="row">
    <div class="col-sm-12 overlay-title">
        <div class="bannerAnnaoucement hidden-xs">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo get_field('header_banner'); ?>
                    </div>
                </div>
            </div>
        </div>            
    </div>
</div>
 <?php endif; ?>

    <div id="desktop-cta" class="tool-overlay open hidden-xs hidden-sm">
                        <div class="overlay-container">
                            <div class="overlay-content">
                                <div class="container-fluid">
                                    <div class="row">
                                    <div class="dealerList">

                                        <?php
                                        $brands = get_terms([
                                          'taxonomy' => 'dealer_cat',
                                        ]);

                                        if (count($brands) > 0):
                                          foreach ($brands as $brand):

                                            $brand_name = $brand->name;
                                            $brand_slug = $brand->slug;
                                            $brand_location_list = [];
                                            $args = [
                                              'post_type' => 'dealers',
                                              'posts_per_page' => -1,
                                              'dealer_cat' => $brand_slug,
                                            ];
                                            $dealers = get_posts($args);
                                            ?>

                                                <div id="loc-<?= $brand_slug ?>" class="center brand-wrapper matchable-heights">
                                                    <div class="loc-brand-logo">
                                                        <img src="<?= get_stylesheet_directory_uri() ?>/images/<?= $brand_slug ?>-logo.png" alt="<?= $brand_name ?> Logo" />
                                                    </div>
                                                    <?php foreach ($dealers as $dealer):

                                                      $post_id = $dealer->ID;

                                                      extract([
                                                        'name' => get_the_title($post_id),
                                                        'url' => get_field('_dealer_website_url', $post_id),
                                                        'phone' => get_field('_dealer_sales_phone', $post_id),
                                                        'service' => get_field('_dealer_service_phone', $post_id),
                                                        'address' => str_replace(
                                                          '|',
                                                          '<br />',
                                                          get_field('_dealer_address', $post_id),
                                                        ),
                                                        'city' => get_field('_dealer_address_map', $post_id),
                                                      ]);
                                                      if (isset($city['address'])) {
                                                        $city = explode(',', $city['address']);
                                                        $city = $city[1]; //index of city name
                                                        if (strpos($city, 'Costa Mesa') !== false) {
                                                          $city = 'Newport Beach';
                                                        }
                                                      }
                                                      ?>
                                                        <div class="popover-wrapper <?php echo str_replace(
                                                          ' ',
                                                          '_',
                                                          $name,
                                                        ); ?>">
                                                            <h3 > <a trid="396c14ec0cfa43aba9d059" trc href="<?= $url ?>"><?php echo $city; ?> </a></h3>

                                                            <div class="info-box dealer-<?= count($dealers) ?>">


                                                                <div class="single-dealer" >
                                                                    <a trid="b2175ae696044750b1765b" trc class="info-link" href="<?= $url ?>" target="_blank">
                                                                        <h3 > <?php echo $name; ?> </h3>

                                                                        <div class="address">
                                                                            <?=
                                                                            $address

                                                                            //Koral was here
                                                                            if ($name === 'Audi Beverly Hills') {
                                                                              echo '<br/> <br/>' .
                                                                                'Service: 2340 S. Fairfax Ave.' .
                                                                                '<br/>' .
                                                                                'Los Angeles, CA 90016';
                                                                            }
                                                                            ?>
                                                                        </div>

                                                                        <div class="sales">
                                                                            Sales: <?= $phone ?>
                                                                        </div>

                                                                        <div class="service">
                                                                            Service: <?= $service ?>
                                                                        </div>
                                                                    </a>

                                                                    <a trid="1964ac4f9fe94225965360" trc class="view-link" href="<?= $url ?>" target="_blank">Visit Site <i class="fa fa-angle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    endforeach; ?>
                                                </div>

                                            <?php
                                          endforeach;
                                        endif;
                                        ?>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<div id="videobanner" class="modfull-home">
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
            <div class="videooverlay-contentwrapper hidden-xs hidden-lg">
                <div class="videooverlay-content">

                    <div id="intro-overlay" class="tool-overlay open">
                        <div class="overlay-container">
                            <div class="overlay-content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <?php
                                        $brands = get_terms([
                                          'taxonomy' => 'dealer_cat',
                                        ]);

                                        if (count($brands) > 0):
                                          foreach ($brands as $brand):

                                            $brand_name = $brand->name;
                                            $brand_slug = $brand->slug;
                                            $brand_location_list = [];
                                            $args = [
                                              'post_type' => 'dealers',
                                              'posts_per_page' => -1,
                                              'dealer_cat' => $brand_slug,
                                            ];
                                            $dealers = get_posts($args);
                                            ?>

                                                <div id="loc-<?= $brand_slug ?>" class="col-sm-<?= 12 /
  count($brands) ?> center brand-wrapper matchable-heights">
                                                    <div class="loc-brand-logo">
                                                        <img src="<?= get_stylesheet_directory_uri() ?>/images/<?= $brand_slug ?>-logo.png" alt="<?= $brand_name ?> Logo" />
                                                    </div>
                                                    <?php foreach ($dealers as $dealer):

                                                      $post_id = $dealer->ID;

                                                      extract([
                                                        'name' => get_the_title($post_id),
                                                        'url' => get_field('_dealer_website_url', $post_id),
                                                        'phone' => get_field('_dealer_sales_phone', $post_id),
                                                        'service' => get_field('_dealer_service_phone', $post_id),
                                                        'address' => str_replace(
                                                          '|',
                                                          '<br />',
                                                          get_field('_dealer_address', $post_id),
                                                        ),
                                                        'city' => get_field('_dealer_address_map', $post_id),
                                                      ]);
                                                      if (isset($city['address'])) {
                                                        $city = explode(',', $city['address']);
                                                        $city = $city[1]; //index of city name
                                                        if (strpos($city, 'Costa Mesa') !== false) {
                                                          $city = 'Newport Beach';
                                                        }
                                                      }
                                                      ?>
                                                        <div class="popover-wrapper <?php echo str_replace(
                                                          ' ',
                                                          '_',
                                                          $name,
                                                        ); ?>">
                                                            <h3 > <a trid="a0333f323c8b41fc86d99a" trc href="<?= $url ?>"><?php echo $city; ?> </a></h3>

                                                            <div class="info-box dealer-<?= count($dealers) ?>">


                                                                <div class="single-dealer" >
                                                                    <a trid="a33225c7271b419d960fab" trc class="info-link" href="<?= $url ?>" target="_blank">
                                                                        <h3 > <?php echo $name; ?> </h3>

                                                                        <div class="address">
                                                                            <?=
                                                                            $address

                                                                            //Koral was here
                                                                            if ($name === 'Audi Beverly Hills') {
                                                                              echo '<br/> <br/>' .
                                                                                'Service: 2340 S. Fairfax Ave.' .
                                                                                '<br/>' .
                                                                                'Los Angeles, CA 90016';
                                                                            }
                                                                            ?>
                                                                        </div>

                                                                        <div class="sales">
                                                                            Sales: <?= $phone ?>
                                                                        </div>

                                                                        <div class="service">
                                                                            Service: <?= $service ?>
                                                                        </div>
                                                                    </a>

                                                                    <a trid="397fb3788c144954885e51" trc class="view-link" href="<?= $url ?>" target="_blank">Visit Site <i class="fa fa-angle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    endforeach; ?>
                                                </div>

                                            <?php
                                          endforeach;
                                        endif;
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="mobile-overlay-buttons" class="row visible-xs">
                <div class="col-sm-12">
                    <a href="#" class="button secondary-button mobile-overlay-cta"
                       data-target="#DIModal" data-toggle="modal" data-modal-title="Mercedes-Benz Locations" data-modal-content="#loc-mercedes-benz"
                    >Mercedes-Benz Locations</a>
                    <a href="#" class="button secondary-button mobile-overlay-cta"
                       data-target="#DIModal" data-toggle="modal" data-modal-title="Audi Locations" data-modal-content="#loc-audi"
                    >Audi Locations</a>
                    <a href="#" class="button secondary-button mobile-overlay-cta"
                       data-target="#DIModal" data-toggle="modal" data-modal-title="Porsche Locations" data-modal-content="#loc-porsche"
                    >Porsche Locations</a>
                </div>

            </div>

            <?php if (get_field('featurebtn', 'option')): ?>
            <div class="row">
                <div class="col-sm-12">
                    <a trid="29572a34574349afbcd245" trc style="margin-top: 15px; padding: 25px; background: <?= !empty(
                      $feature_button_color
                    )
                      ? $feature_button_color . '!important;'
                      : $fj_blue . '!important;' ?>"
                        class="button secondary-button <?= glow() ? 'button-radioactive' : '' ?>"
                       data-gtm="desktop.homepage.btn.etron" href="<?= !empty($button_link)
                         ? $button_link
                         : '/current-offers/' ?>"><?= !empty($feature_button_text)
  ? $feature_button_text
  : 'Why FJ' ?></a>
                </div>
            </div>
            <?php endif; ?>
		</div>

        <?= get_field('overlay_text') ? get_field('overlay_text') : '' ?>

    </div>

      <?php if (get_field('bottom_text')): ?>
          <div class="videooverlay-buttons hidden-xs">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-sm-8 col-sm-offset-2 event">
                      </div>
                  </div>
              </div>
          </div>
      <?php endif; ?>



  </div>

</div>

<?php } ?>
