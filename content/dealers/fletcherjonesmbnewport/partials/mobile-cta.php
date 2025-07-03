<?php if (get_field('add_mobile_ctas')) { ?>
<div class="mobile-cta mobile-cta-inside-page visible-xs">
	<?php 
	if( have_rows( 'mobile_single_cta' ) ):
		while ( have_rows( 'mobile_single_cta' ) ) : the_row();
		
		$heading = get_sub_field( 'cta_section_heading' );
	?>
		<?php if ($heading) { ?>
		<h2 class="mobile-section-heading"><?= $heading; ?></h2>
		<?php } ?>

		<div class="mobile-cta_wrap">
			<?php 
			if( have_rows( 'ctas' ) ):
				while ( have_rows( 'ctas' ) ) : the_row();
				
				$ctaImage       = get_sub_field( 'image' );
				$ctaLink        = get_sub_field( 'link' );
				$title   		= get_sub_field( 'title' );
				$ctaTitleColor  = get_sub_field( 'title_text_color' );
				$ctaLinkTitle   = get_sub_field( 'button_text' );
				$ctaLinkBG   	= get_sub_field( 'button_background' );
				$ctaLinkColor   = get_sub_field( 'button_color' );
				$new_window 	= get_sub_field('new_window') ? 'target="_blank"' : '';
				$ctaClass   	= get_sub_field( 'add_class' );
			?>
				<div class="ctaItem">
					<img src="<?= $ctaImage['sizes']['large_medium']; ?>" alt="<?= $ctaImage['alt']; ?>" />
					<h2 class="cta-title <?php if ($ctaTitleColor != '#ffffff') : echo 'dark'; endif ?>" style="color:<?= $ctaTitleColor; ?>"><?= $title; ?></h2>
					<a trid="dfce5c04284b49ffa1863c" trc <?php if ($ctaClass) { ?> href="#" <?php } else { ?> href="<?php echo $ctaLink; ?>" <?php }; ?> <?php echo $new_window ?> class="button dark-button <?php if ($ctaClass) : echo $ctaClass; endif ?>" style="background-color:<?= $ctaLinkBG; ?>;color:<?= $ctaLinkColor; ?>"><?= $ctaLinkTitle; ?></a>
				</div>
			<?php endwhile; endif;  ?>
		</div>
	<?php endwhile; endif; ?>
</div>
<?php } ?>