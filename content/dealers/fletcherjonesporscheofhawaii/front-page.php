<?php /*
Home page of the site
*/ get_header(); ?>

<div class="visible-xs">   	<!-- DEFAULT MOBILE HOMEPAGE -->
	<?php get_template_part('partials/homepage/mobile/open-hours'); ?>
</div>

<?php get_template_part('/partials/dealer-groups/porsche/slider'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/full-overlay'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/model-row'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/cta-row'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/about-row'); ?>
<?php get_scoped_template_part('partials/dealer-groups/porsche/reviews-row', '', ['review_id' => '72350']); ?>
<?php get_template_part('/partials/dealer-groups/porsche/map-row'); ?>

<?php get_footer(); ?>
