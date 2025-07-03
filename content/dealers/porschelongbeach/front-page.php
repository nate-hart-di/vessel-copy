<?php /*
Home page of the site
*/ get_header(); ?>

<div class="visible-xs">   	<!-- DEFAULT MOBILE HOMEPAGE -->
	<?php get_scoped_template_part('/partials/homepage/mobile/open-hours', '', [
   'departments' => 'Sales, Service & Parts',
 ]); ?>
</div>

<?php get_template_part('/partials/dealer-groups/porsche/slider'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/full-overlay'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/model-row'); ?>

<?php if (get_field('above_shopping')) { ?>
<div id="above-shopping" data-acf="above_shopping">
<?php the_field('above_shopping'); ?>
</div>
<?php } ?>

<?php get_template_part('/partials/dealer-groups/porsche/cta-row'); ?>
<?php get_frontend_component('blog/featured-category'); ?>
<?php get_template_part('/partials/dealer-groups/porsche/about-row'); ?>
<?php get_scoped_template_part('partials/dealer-groups/porsche/reviews-row', '', ['review_id' => '64309']); ?>
<?php get_template_part('/partials/dealer-groups/porsche/map-row'); ?>

<?php get_footer(); ?>
