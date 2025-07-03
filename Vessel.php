<?php
/* Be sure to replace vessel anywhere that sees fit (in php files, and filenames) */
/*
Plugin Name: Dealer Inspire - Vessel
Plugin URI: http://www.dealerinspire.com/
Description: One source of truth for all things FJ.
Version: 2.5.1.7
Author: Dealer Inspire
Author URI: http://www.dealerinspire.com
*/

namespace DealerInspire\Vessel;

require_once('autoload.php');
require_once('helpers.php');
require_once(dirname(__DIR__, 2) . '/themes/DealerInspireCommonTheme/includes/plugins/HomepageBackgroundImageOverrides/HomepageBackgroundImageOverrides.php');
include_once get_template_directory() . '/includes/plugins/CustomCSS/customCSS.php';

$acfs = new AcfAdder();
$FJ = FJ::getInstance();
$mercedes = new Mercedes();
$vessel = new Vessel($FJ);
$utility = new Utility($vessel);
$admin = new Admin($FJ, $vessel);

if ( Vessel::is_default_frontpage() ){
    $tabletbgcustomizer = new TabletBackgroundImageOverride();
    $tabletbgcustomizer->register_tablet_hooks();
}

$enqueue = new Enqueue($vessel, $FJ, $mercedes);
$shared_functions = new SharedFunctions($FJ, $mercedes);
//$vrpButtonMover = VrpButtonMover::getInstance();

$api = new API($FJ);
$send = new Send($FJ);
$update = new Update($FJ);

$send->vessel_send_api_settings_hooks();
$update->vessel_update_api_hooks();


$utility::check_vessel_version();
$utility::set_vessel_version();

//Everything Vessel needs
$enqueue->vessel_actions_filters();

$admin->add_admin_page_hooks();

//Shared functionality
$shared_functions->add_all_shared_hooks_filters();
$shared_functions->register_sidebars();
$shared_functions->register_shared_acf_groups();

if ( ((!$vessel->is_prod()) && (in_array($FJ->get_di_id(), $mercedes->get_mercedes_dealers()))) || ( ( in_array($FJ->get_di_id(), $FJ->get_autogravity_dealers()) ))) {
    $AutoGravity = new FJAutoGravity($FJ, $vessel);
    //AutoGravity hooks
    $AutoGravity->add_all_ag_hooks();
}

if((in_array($FJ->get_di_id(), $mercedes->get_mercedes_dealers()))) {
    $enqueue->mb_actions_filters();
}

$enqueue->flipclock_hooks();

if ( Vessel::is_default_frontpage() ){
    $shared_functions->add_homepage_bg_customizer();
}
