<?php /*
	Home page of the site
*/

$feature_button_text = get_field('button_text', 'option');
$feature_button_color = get_field('button_color', 'option');
$button_link = get_field('button_link', 'option');
?>

<?php get_header(); ?>

<?php if (get_field('before_videobanner')) { ?>
<div id="before-videobanner" data-acf="before_videobanner">
<?php the_field('before_videobanner'); ?>
</div>
<?php } ?>

<!-- MOBILE CTAS 04/20 REDEVELOPEMENT -->
<?php get_shared_homepage_template('home-mobile-ctas'); ?>

<!-- DESKTOP REDEV 07/20 STYLES AUTO INCLUDED WITH PHP COMPONENT -->
<?php get_frontend_component('homepage/desktop-0620'); ?>

<?php get_footer(); ?>
