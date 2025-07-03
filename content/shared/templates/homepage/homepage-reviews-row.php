<?php
$review_id = !empty($review_id) ? $review_id : get_option('di_reviewpush_ids');
$review_link = !empty($review_link) ? $review_link : '/about-us/customer-testimonials/';
$review_text = !empty($review_text) ? $review_text : 'Read All Reviews';
$review_title = !empty($review_title) ? $review_title : '';
?>
<section class="reviewsRow blockSection">
	<div class="container-wide">
		<h2 class="blockSection__heading"><?php echo $review_title; ?></h2>
		<div class="blockSection__scroller reviews__scroller">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<?php echo do_shortcode(
       '[reviewpush_reviews id="' . $review_id . '" min_rating="4" limit="20" hide_empty="true" api="json"]',
     ); ?>
				</div>
				<div class="blockSection__navigation reviews__navigation">
					<div trid="3f91318bd8cf4fdaae6a16" trc class="swiper-button-prev reviews swiper-button-white"></div>
					<div trid="8edeba7825944369843803" trc class="swiper-button-next reviews swiper-button-white"></div>
				</div>
			</div>
		</div>
        <div class="blockSection__cta">
            <a trid="0acc202269884449a551aa" trc href="<?php echo $review_link; ?>" class="button primary-button homepage-button" >
         	<?php echo $review_text; ?>
			</a>
        </div>
	</div>
</section>