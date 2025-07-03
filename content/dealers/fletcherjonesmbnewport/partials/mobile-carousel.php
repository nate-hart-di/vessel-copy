<?php if (get_field('add_mobile_carousels')) { ?>
<div class="mobile-carousel visible-xs">
	<?php if (have_rows('mobile_carousel')):
   while (have_rows('mobile_carousel')):

     the_row();

     $heading = get_sub_field('carousel_section_heading');
     ?>
	
		<?php if ($heading) { ?>
		<h2 class="mobile-section-heading"><?= $heading ?></h2>
		<?php } ?>
		
		<div class="mobile-carousel_wrap">
			<div class="swiper-wrapper">
				<?php if (have_rows('ctas')):
      while (have_rows('ctas')):

        the_row();

        $content = get_sub_field('content');
        ?>
					<div class="swiper-slide">
						<div class="cta-wrap">
							<?php echo $content; ?>
						</div>
					</div>
				<?php
      endwhile;
    endif; ?>
			</div>
		</div>
	<?php
   endwhile; ?>
	<div class="mobile_cta__navigation">
            <div trid="8f2a16bb58794f7aae7b20" trc class="swiper-button-prev mobile-direction swiper-button-white"></div> 
            <div trid="6f4042aea05b4181895af4" trc class="swiper-button-next mobile-direction swiper-button-white"></div>
    </div>
	<?php
 endif; ?>
</div>
<?php } ?>
