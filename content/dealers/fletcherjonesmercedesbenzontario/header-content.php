<!-- The site initially used header-content-v2 which combines both desktop and mobile
	split it up and added mobile-header partial for the new mobile redev
	Not all FJ sites have the same header.
	New partials will need to be created since we have about 4 different headers types
-->
<?php //get_shared_homepage_template('desktop-header'); ?>
<?php get_frontend_component('header/header-v3'); ?>
<?php get_frontend_component('header/model-row'); ?>
