<?php /*
	Home page of the site
*/

$feature_button_text = get_field('button_text', 'option');
$feature_button_color = get_field('button_color', 'option');
$fj_blue = '#0059a8';
$button_link = get_field('button_link', 'option');

?>

<?php if(get_field('override_videobanner')) { ?>
<div id="override_videobanner" data-acf="override_videobanner" data-acf-location="Homepage">
  <?php the_field('override_videobanner_content'); ?>
</div>
<?php } else { ?>
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
            <div class="videooverlay-contentwrapper">
                <div class="videooverlay-content">

                    <div id="intro-overlay" class="tool-overlay open">
                        <div class="overlay-container">
                            <div class="overlay-content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <?php
                                        $brands = get_terms(array(
                                            'taxonomy' => 'dealer_cat',
                                            'orderby' => $brands -> term_id,
                                            'order' => 'ASC',
                                        ));
                                                                                
                                        if(count($brands) > 0):
                                            foreach($brands as $brand):
                                                $brand_name = $brand->name;
                                                $brand_slug = $brand->slug;
                                                $brand_location_list = [];
                                                $args = array(
                                                    'post_type' => 'dealers',
                                                    'posts_per_page' => -1,
                                                    'dealer_cat' => $brand_slug,
                                                    'order' => 'ASC'
                                                );
                                                $dealers = get_posts($args); 
                                                
                                                ?>

                                                <div id="loc-<?= $brand_slug ?>" class="col-sm-<?= (12 / (count($brands))) ?> center brand-wrapper matchable-heights">
	                                                
                                                    <?php foreach($dealers as $dealer):
                                                        $post_id = $dealer->ID;

                                                        extract(array(
                                                            "name" => get_the_title($post_id),
                                                            "url" => get_field('_dealer_website_url', $post_id),
                                                            "phone" => get_field('_dealer_sales_phone', $post_id),
                                                            "service" => get_field('_dealer_service_phone', $post_id),
                                                            "address" => str_replace("|", "<br />", get_field('_dealer_address', $post_id)),
                                                            "city" => get_field('_dealer_address_map',$post_id)

															
                                                        ));
                                                        
                                                        $term_id = ($brand->term_id);

														$taxonomy = $brand->taxonomy;
		                                                $term_id = $brand->term_id;
		                                                $termImage = get_field( 'dealer_category_logo', $taxonomy.'_'.$term_id);
														                                                        
                                                        if( isset($city['address']) ){
                                                            $city = explode(',',$city['address']);
                                                            $city = $city[1]; //index of city name
                                                            if($post_id == 166){
		                                                       $city = trim(preg_replace('/\s+/', ' ', $city));
	                                                            if( $city == 'Las Vegas'){
	                                                                $city = "FJ Used Cars";
	                                                            }
	                                                        }
                                                        
	                                                        
                                                        }
                                                    ?>
                                                        <div class="popover-wrapper <?php echo str_replace(" ","_",$name);?>">
	                                                        
	                                                        <div class="loc-brand-logo">
		                                                        <img src="<?php echo esc_url($termImage['url']); ?>" alt="<?php echo esc_attr($termImage['alt']); ?>" />
		                                                       
		                                                    </div>

                                                            <div class="info-box dealer-<?= count($dealers) ?>">


                                                                <div class="single-dealer" >
                                                                    <a trid="b2d935f5f6aa4752a6d674" trc class="info-link" href="<?= $url ?>" target="_blank">
                                                                        <h3 > <?php echo $name; ?> </h3>

                                                                        <div class="address">
                                                                            <?= $address; ?>
                                                                        </div>

                                                                        <div class="sales">
                                                                            Sales: <?= $phone ?>
                                                                        </div>

                                                                        <div class="service">
                                                                            Service: <?= $service ?>
                                                                        </div>
                                                                    </a>

                                                                    <a trid="e79b21ea21c64c8c9b8995" trc class="view-link" href="<?= $url ?>" target="_blank">Visit Site <i class="fa fa-angle-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php endforeach; ?>
                                                </div>

                                            <?php endforeach;
                                        endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
                </div>
            </div>
            
            <div class="fj-additional-ctas"> 
	            <?php
		        if( have_rows('cta-button') ):
				    while ( have_rows('cta-button') ) : the_row();?>
				
				    <a trid="718868424bc74f84b80b64" trc href="<?php the_sub_field('cta-button-link'); ?>" class="button cta-button">
						<?php the_sub_field('cta-button-name'); ?>
					</a>
				
				    <?php endwhile;
				endif;
				?>
				
			</div>

            <?php if (get_field('featurebtn', 'option')): ?>
            <div class="row">
                <div class="col-sm-12">
                    <a trid="3663d8c3290840608b8c57" trc style="margin-top: 15px; padding: 25px; background: <?= (!empty($feature_button_color)) ? $feature_button_color .'!important;' : $fj_blue . '!important;';?>"
                        class="button secondary-button <?= (glow()) ? 'button-radioactive' : ''; ?>"
                       data-gtm="desktop.homepage.btn.etron" href="<?= (!empty($button_link)) ? $button_link : '/current-offers/' ?>"><?= (!empty($feature_button_text) ? $feature_button_text : 'Why FJ') ?></a>
                </div>
            </div>
            <?php endif; ?>
		</div>

        <?= get_field('overlay_text') ? get_field('overlay_text') : "" ?>

    </div>

      <?php if(get_field('bottom_text')): ?>
          <div class="videooverlay-buttons hidden-xs">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-sm-8 col-sm-offset-2 event">
                      </div>
                  </div>
              </div>
          </div>
      <?php endif ?>



  </div>
</div>
<?php } ?>
