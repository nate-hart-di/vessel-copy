<?php
//use \DealerInspire\Vessel\Vessel;

$FJ = \DealerInspire\Vessel\FJ::getInstance();
$vessel = new \DealerInspire\Vessel\Vessel($FJ);
/*
 * The main file for Vessel. Front page, header, and footer templates are included here.
 *
 * Vessel checks for this file existing in __construct and will fall back to the default front page template from DealerTheme.
 *
 * If it can't find any header or footer files within Vessel, it defaults to get_header and get_footer
 */

get_header();

if ($vessel->get_vessel_template('front-page.php')) {
  include $vessel->get_vessel_template('front-page.php');
} else {
  echo '<h1>Front page template for ' . get_option('di_slug') . ' not found. Check your file paths and names.</h1>';
}

get_footer();
