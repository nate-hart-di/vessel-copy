<?php /*================================
	Home page of the site
===================================*/ ?>
<?php if(get_field('before_videobanner')) { ?>
<div id="before-videobanner" data-acf="before_videobanner">
<?php the_field('before_videobanner'); ?>
</div>
<?php } ?>

<?php get_shared_homepage_template('home-mobile-ctas'); ?>

<!-- DESKTOP REDEV 07/20 STYLES AUTO INCLUDED WITH PHP COMPONENT -->
<?php get_frontend_component('homepage/desktop-0620'); ?>
