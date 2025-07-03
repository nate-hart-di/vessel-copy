<div id="frontpage-0620" class="frontpage-0620 hidden-xs">

	<!--=================================================
					HERO SECTION
	==================================================-->
	<?php
		$hero_bg = get_field('hero_bg');
	?>
	<section id="heroRow" class="heroRow" <?php if($hero_bg) { ?>style="background-image: url(<?php echo $hero_bg['url'];  ?>)" <?php } ?>>
		<div class="heroRow__container lazy-loading">
			<?php get_template_part('partials/homepage/personalizer-key'); ?>
		</div>
		<?php if( have_rows('hero_cta')): ?>
		<div class="heroRow__cta">
			<?php while ( have_rows('hero_cta') ) : the_row();
				$image = get_sub_field('image');
				$text = get_sub_field('text');
				$link = get_sub_field('link');
				$tab = get_sub_field('new_tab');
			?>
			<a trid="dc9ef932f8ac4686aa2205" trc href="<?php echo $link; ?>" target="<?php echo $tab; ?>" class="heroRow__cta--wrap">
				<img data-original="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				<p><?php echo $text; ?></p>
			</a>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
	</section>

	<!--=================================================
					CTA SECTION
	==================================================-->
	<?php
		$cta_bg = get_field('cta_bg');
		$cta_title = get_field('cta_title');
	?>

	<section id="ctaRow" class="ctaRow" <?php if($cta_bg) { ?>style="background-image: url(<?php echo $cta_bg['url'];  ?>)" <?php } ?>>
		<div class="ctaRow__title">
			<?php if($cta_title) {
				echo $cta_title;
			} else { ?>
				<h2>Fletcher Jones Is Here For You</h2>
				<p>
					Our team is here for you ready to assist with all of your needs. We will continue to work hard to provide various avenues to continue the level of service you have come to expect. At Fletcher Jones our goal is to exceed your expectations while we keep our community safe.
				</p>
			<?php } ?>
		</div>
		<?php if( have_rows('cta')): ?>
		<div class="ctaRow__wrap fly-in-bottom">
			<?php while ( have_rows('cta') ) : the_row();
				$image = get_sub_field('cta_image');
				$text = get_sub_field('cta_text');
				$link = get_sub_field('cta_link');
				$tab = get_sub_field('cta_new_tab');
			?>
			<a trid="4a50bb1c76d94e69995e76" trc href="<?php echo $link; ?>" target="<?php echo $tab; ?>" class="ctaRow__link">
				<img data-original="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				<p><?php echo $text; ?></p>
			</a>
			<?php endwhile; ?>
		</div>
		<?php endif; ?>
		<div class="ctaRow__btn">
			<a trid="4c967d505f9044418536cf" trc href="<?= get_field('cta_button_link') ? get_field('cta_button_link') : "/"; ?>" class="button blue-gradient-ol"><?= get_field('cta_button_text') ? get_field('cta_button_text') : "Start Here"; ?></a>
		</div>
	</section>

	<!--=================================================
				SLIDER SECTION
	==================================================-->
	<section id="homepage-slider" class="homepage-slider">
		<?php echo do_shortcode('[di-slider name="homepage"]'); ?>
	</section>

	<!--=================================================
				SHOP ONLINE SECTION
	==================================================-->
	<?php $shopOnline_content = get_field('shop_online_content'); ?>

	<section id="shopOnline" class="shopOnline">
		<div class="shopOnline__wrap">
			<div class="shopOnline__left">
				<?php

					$shopOnlineImg = get_field('shopOnline_image_bg');

					if( !empty($shopOnlineImg) ): ?>

						<img class="shopOnline-bg" data-original="<?php echo $shopOnlineImg['url']; ?>" alt="<?php echo $shopOnlineImg['alt']; ?>" />

				<?php endif; ?>

				<?php

					$shopOnlineImg2 = get_field('shopOnline_image');

					if( !empty($shopOnlineImg2) ): ?>

						<img class="shopOnline-img fly-in-left" data-original="<?php echo $shopOnlineImg2['url']; ?>" alt="<?php echo $shopOnlineImg2['alt']; ?>" />

				<?php endif; ?>
			</div>
			<div class="shopOnline__right">
				<?php if($shopOnline_content) {
					echo $shopOnline_content;
				} else { ?>
					<h2>Shop Online Stress-Free</h2>
					<p>
						We offer great upfront pricing and a 100% online experience.. Buy or Lease your next new Mercedes-Benz online and we'll deliver it straight to your doorstep.
					</p>
					<a trid="1617554f09fd4d698d3de4" trc href="/new-vehicles/">How It Works <i class="fa fa-caret-right" aria-hidden="true"></i></a>
				<?php } ?>
			</div>
		</div>
	</section>

	<!--=================================================
				SERVICE SECTION
	==================================================-->
	<?php $service_content = get_field('service_content'); ?>

	<section id="serviceRow" class="serviceRow">
		<div class="serviceRow__wrap">
			<div class="serviceRow__left">
				<?php if($service_content) {
					echo $service_content;
				} else { ?>
					<h2>You Choose How To Service With Us</h2>
					<p>
						The professional team at our Newport Beach service center can manage all your Mercedes-Benz maintenance and Mercedes-Benz auto repairs needs.
					</p>
					<a trid="f0dc8d9d1a334fe4bc6c33" trc href="/service/schedule-service/">Service Center <i class="fa fa-caret-right" aria-hidden="true"></i></a>
				<?php } ?>
			</div>
			<div class="serviceRow__right">
				<?php

					$serviceImg = get_field('service_image_bg');

					if( !empty($serviceImg) ): ?>

						<img class="service-bg" data-original="<?php echo $serviceImg['url']; ?>" alt="<?php echo $serviceImg['alt']; ?>" />

				<?php endif; ?>

				<?php

					$serviceImg2 = get_field('service_image');

					if( !empty($serviceImg2) ): ?>

						<img class="service-img fly-in-right" data-original="<?php echo $serviceImg2['url']; ?>" alt="<?php echo $serviceImg2['alt']; ?>" />

				<?php endif; ?>
			</div>
		</div>
	</section>

	<!--=================================================
				SEO SECTION
	==================================================-->
	<section id="seoRow" class="seoRow">
		<div class="seoRow__img">
			<?php if( get_field('seo_image') ): ?>
				<img class="seo-img" data-original="<?php the_field('seo_image'); ?>" />
			<?php endif; ?>
		</div>
		<div class="seoRow__content">
			<div class="seoRow__wrap fly-in-bottom">
				<h1><span>Welcome To </span> %%di_name%%</h1>
				<?php the_content(); ?>
				<div class="seoRow__wrap--btn">
					<a trid="4263fbc66f044906b5a1fe" trc id="meetTeam" href="/about/" class="button blue-gradient-bg">Meet Our Team</a>
					<a trid="c840bc0897004e3b9bdbb0" trc href="https://sites.hireology.com/fletcherjonescareers/index.html" target="_blank" class="button blue-gradient-ol">Join Our Team</a>
				</div>
			</div>
		</div>
	</section>


	<!--=================================================
					BADGE SECTION
	==================================================-->
	<?php if( get_field('badge_row_text')): ?>
		<section id="badgeRow" class="badgeRow">
				<?php the_field('badge_row_text'); ?>
				<style>
					<?php the_field('badge_row_css'); ?>
				</style>
		</section>
	<?php endif; ?>
	<!--=================================================
				MAP SECTION
	==================================================-->
	<section id="map" class="map">
		<?php

			$latitude = do_shortcode('[di_option option="di_latitude"]');
			$longitude = do_shortcode('[di_option option="di_longitude"]');
			$longitudeAdjust = $longitude + .40;

			get_scoped_template_part('partials/map/mapboxscript', '',
				array(
					'node'=>'map3',
					'zoom'=>10,
					'latitude'=>$latitude,
					'longitude'=>$longitude,
					'map_options'=>'
						{center: ['.$latitude.', '.$longitudeAdjust.']},
						{dragging: 0},
						{zoomControl:false}
					',
					"style_url" => "mapbox://styles/di-sysops/ckb02870k0ch11jp9xpb5fw82",
					"load_on_mobile" => true
				)
			);
		?>
		<div class="mapRow blockSection">
			<div id="map3"></div>
			<div class="mapWrapper__directions fly-in-right">
				<h2 class="blockSection__heading">Contact Us</h2>

				<div class="mapWrapper__dealerInfo">
					<?php get_template_part('/includes/svg/icon', 'map-marker'); ?>
					<?php do_action('address_label') ?>
					<?= get_option("di_street_address"); ?><br /><?= get_option("di_city"); ?>, <?= get_option("di_state"); ?> <?= get_option("di_zipcode"); ?>

					<?php do_action('more_address_info') ?>

				</div>
				<div class="mapWrapper__dealerInfo">
					<?php get_template_part('/includes/svg/icon', 'clock'); ?>
					<?= do_shortcode('[di_display_open_hours departments="Sales" class="dynamic-hours sales"]'); ?>
					<?= do_shortcode('[di_display_open_hours departments="Service" class="dynamic-hours service"]'); ?>
					<?= do_shortcode('[di_display_open_hours departments="Parts" class="dynamic-hours parts"]'); ?>
				</div>

				<?php do_action('more_map_info') ?>

				<div class="blockSection__mainCTA">
					<a trid="fee94e2072824e2ba636c4" trc class="button blue-gradient-bg" href="/contact-us/">Ask A Question</a>
				</div>
			</div>
		</div>
	</section>
	<!-- BOTTOM OF MAP / INPUT ADDRESS SECTION -->
	<section class="mapRow2 blockSection">
		<div class="mapWrapper__directions">
			<div class="mapWrapper__title">
				<h2 class="blockSection__heading">Get Directions</h2>
				<span><?= get_option("di_street_address"); ?> <?= get_option("di_city"); ?>, <?= get_option("di_state"); ?> <?= get_option("di_zipcode"); ?></span>
			</div>

			<?php do_action('more_directions_info') ?>

			<form class="mapWrapper__content" action="https://maps.google.com/maps" method="get" target="_blank">
				<input class="mapWrapper__location" type="text" name="saddr" placeholder="Enter Your Address">
				<input id="insert-location" type="hidden" name="daddr" value="<?= get_option('di_street_address'); ?>, <?= get_option('di_city'); ?>, <?= get_option('di_state'); ?> <?= get_option('di_zipcode'); ?>">
				<button trid="10c3d6b60d564b288046cc" trc type="submit" class="button blue-gradient-bg">Go</button>
			</form>
		</div>
	</section>
</div>
