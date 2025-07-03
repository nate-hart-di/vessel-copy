<?php

function timer_enabled() {
    $timer = get_field('countdown_timer', 'option');
    return (!empty($timer)) ? true : false;
}

function glow() {
    $glow_enabled = get_field('radioactive', 'option');
    return (!empty($glow_enabled)) ? true : false;
}

function get_homepage_ctas() {
    return require_once \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/homepage/main-ctas.php';
}

function get_imports_homepage_ctas() {
    return require_once \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/homepage/imports-main-ctas.php';
}

function get_homepage_countdown() {
    return require_once \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/homepage/countdown-timer.php';
}

function get_shared_homepage_template($file) {
    require_once \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/homepage/' . $file . '.php';
}

function get_shared_mobile_template($file) {
    require_once \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/mobile/' . $file . '.php';
}
function get_shared_template($file) {
    require_once \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/' . $file . '.php';
}
function is_prod() {
    return (defined('ENVIRONMENT') && constant('ENVIRONMENT') === 'production') ? true : false;
}
function get_frontend_component($slug, $name = null, $params = array()){
    if( file_exists( \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/styles/' . $slug . '.min.css' ) ){
        $styles = file_get_contents(\DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/styles/' . $slug . '.min.css');
        echo '<style>'.$styles.'</style>';
        get_scoped_shared_template($slug,$name,$params);
    }

};

/**
 * @param $url - URL of network passed in from show_social_icons
 * @param $network - Key from array of social icons passed in
 * @return string HTML
 */
function build_social_html($url, $network) {
    ob_start(); ?>
    <div class="floating-social-icon">
      <a trid="b1ca60428de44b63b278c4" trc href="<?= $url ?>" target="_blank">
        <i class="fa fa-<?= $network ?>"></i>
      </a>
    </div>
    <?php
    $html = ob_get_clean();
    echo $html;
}

function is_in_black_friday_window() {
    $now = new DateTime();
    $BF_Wed = new DateTime('11/22/18');
    $Tuesday_After = new DateTime('11/27/18');

    if (($now > $BF_Wed) && ($now < $Tuesday_After)) {
        return true;
    } else {
        return false;
    }
}

function is_in_end_of_year_window() {
    $now = new DateTime();
    $day_after_christmas = new DateTime('12/26/18');
    $second_day_2019 = new DateTime('1/2/19');

    if (($now > $day_after_christmas) && ($now < $second_day_2019)) {
        return true;
    } else {
        return false;
    }
}

function eoy_model_check($model) {
    $should_show_on = [
    'cla',
    'c-class',
    'slc',
    'gla',
    'glc',
    'e-class',
    'gls',
    'cls',
    's-class',
    'amg® gt',
    'g-class'
    ];

    return in_array($model, $should_show_on);
}

/**
 * @param array $social_networks - associative list of network names and url values, with urls as empty strings
 * @return string HTML
 */
function show_social_icons(array $social_networks) {

    foreach ($social_networks as $network => $url) {
        if (!empty(get_option('di_' . $network . '_url')) && $network !== 'twitter') {
            $social_networks[$network] = get_option('di_' . $network . '_url');
            continue;
        } else if (!empty(get_option('di_twitter_id')) && $network === 'twitter') {
            $social_networks['twitter'] = get_option('di_twitter_id');
            continue;
        }
        unset($social_networks[$network]);
    }

    return array_walk($social_networks, 'build_social_html');
}

if (!function_exists('get_scoped_shared_template')) {
    /**
     * An alternative to get_template_part that allows you to pass scoped variables.  Amazing concept.
     *
     * @author Cade Cannon <ccannon@torsionmobile.com>
     * @param  string   $slug   Slug of include template
     * @param  string   $name   Name of included template.  Defaults to null.
     * @param  array    $params Array of parameters that will get scoped to the template.
     * @param  boolean  $_return Returns the content instead of echoing it out; Useful for shortcodes, variables, etc.
     */
    function get_scoped_shared_template($slug, $name = null, $params = array(), $_return = false)
    {
        do_action("get_template_part_{$slug}", $slug, $name);

        $templates = array();
        $name = (string)$name;

        if ('' !== $name) {
            $templates[] = "{$slug}-{$name}.php";
            $params['theme'] = $name;
        }

        $templates[] = "{$slug}.php";

        $file = \DealerInspire\Vessel\Vessel::get_plugin_dir_path() . 'content/shared/templates/' . $templates[0];
        if (file_exists($file)) {
            if ($params == null) {
                $params = array();
            }
            extract($params);
            ob_start();
            include($file);
            $content = ob_get_contents();
            ob_end_clean();

            if ($_return) :
                return $content;
            else :
                echo $content;
            endif;
        }
    }
}

if (!function_exists('isUsingSiteBuilderHeader')) {
    /**
     * Checks if the site has a Site Builder header
     * @return boolean
     */
    function isUsingSiteBuilderHeader()
    {
        return get_option('site-builder-settings_sb_header', false);
    }
}

if (!function_exists('isUsingSiteBuilderFooter')) {
    /**
     * Checks if the site has a Site Builder footer
     * @return boolean
     */
    function isUsingSiteBuilderFooter()
    {
        return get_option('site-builder-settings_sb_footer', false);
    }
}
