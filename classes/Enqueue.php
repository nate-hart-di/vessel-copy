<?php

namespace DealerInspire\Vessel;

use DealerInspire\Sliders\Framework\DataMapper\Exceptions\Exception;
use Zend\Stdlib\DateTime;

class Enqueue
{
  protected $settings;
  protected $vessel;
  protected $_fj;

  public function __construct(Vessel $vessel, FJ $FJ, Mercedes $MB)
  {
    $this->vessel = $vessel;
    $this->_fj = $FJ;
    $this->_mercedes = $MB;
  }

  public function vessel_actions_filters()
  {
    add_action('init', [$this, 'register_custom_fields']);
    add_action('init', [$this, 'register_shared_shortcodes']);
    add_action('wp_print_scripts', [$this, 'override_js']);

    //Switch to the homepage, styles and functions file inside Vessel

    if (Vessel::is_default_frontpage()) {
      add_filter('template_include', [$this, 'use_vessel_homepage'], 99);
    }
    add_filter('template_include', [$this, 'use_new_single_template'], 99);
    add_filter('template_include', [$this, 'use_new_blog_template'], 99);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_shared_vessel_stylesheet'], 21);
    if (!$this->vessel->ShouldUseDealerThemeFiles($this->_fj->get_di_id())) {
      add_action('wp_enqueue_scripts', [$this, 'enqueue_vessel_styles'], 20);
      add_action('wp_enqueue_scripts', [$this, 'enqueue_vessel_scripts']);
      add_action('wp_after_body', [$this, 'return_new_header_template'], 1);
      add_action('wp_footer', [$this, 'return_new_footer_template'], 9999999999999999999);
    }
    add_filter('di_stacks_top', [$this, 'addTopStacks']);

    add_action('wp_head', [$this, 'enqueue_shared_js']);
    add_action('init', [$this, 'enqueue_vessel_functions_file'], 1);

    //Dequeue default CSS stylesheet from DealerTheme
    add_action('wp_enqueue_scripts', [$this, 'dequeue_default_css'], 99);

    //Render the footer and header templates from inside Vessel.
    add_action('wp_head', [$this, 'set_correct_timezone']);
    add_action('admin_enqueue_scripts', [$this, 'admin_style']);
  }

  public function set_correct_timezone()
  {
    switch ($this->_fj->get_di_slug()) {
      case 'fletcherjonesimports':
        date_default_timezone_set('America/Denver');
        break;
      case 'fletcherjonesmbnewport':
        date_default_timezone_set('America/Los_Angeles');
        break;
      case 'fletcherjonesmercedesbenzchicago':
        date_default_timezone_set('America/Chicago');
        break;
      case 'fletcherjonesmercedesbenzofhenderson':
        date_default_timezone_set('America/Denver');
        break;
      case 'fletcherjonesmercedesbenzontario':
        date_default_timezone_set('America/Los_Angeles');
        break;
      case 'fletcherjonesmotorcarsoffremont':
        date_default_timezone_set('America/Los_Angeles');
        break;
      case 'porscheoffremont':
        date_default_timezone_set('America/Los_Angeles');
        break;
      case 'fletcherjonessocalregional':
        date_default_timezone_set('America/Los_Angeles');
        break;
      case 'fletcherjonesbigislandhondahilo':
        date_default_timezone_set('Pacific/Honolulu');
        break;
      case 'fletcherjonesmercedesbenzofmaui':
        date_default_timezone_set('Pacific/Honolulu');
        break;
      case 'fletcherjonesporscheofhawaii':
        date_default_timezone_set('Pacific/Honolulu');
        break;
      case 'fletcherjonesmercedesbenztemecula':
        date_default_timezone_set('America/Los_Angeles');
        break;
    }
  }

  public function register_shared_shortcodes()
  {
    add_shortcode('fj_holiday_hours', [$this, 'holiday_hours_shortcode']);
  }

  public function holiday_hours_shortcode()
  {
    $sales_hours = get_field_object('holiday_hours', 'option');

    $hol_sales_hours = $sales_hours['value'][0];
    $hol_service_hours = $sales_hours['value'][1];
    ob_start();
    ?>
        <div class="row">
            <div id="saleshours" class="col-md-6">
                <h3>Sales Hours</h3>

        <?php foreach ($hol_sales_hours as $day => $time) { ?>
            <div class="department-hours">
                <span><?= ucwords($day) ?>: </span><span><?= $time ?></span>
            </div>
        <?php } ?>
        </div>
        <?php
        $sales_html = ob_get_clean();

        ob_start();
        ?>

        <div id="servicehours" class="col-md-6">
            <h3>Service Hours</h3>

        <?php foreach ($hol_service_hours as $day => $time) { ?>
            <div class="department-hours">
                <span><?= ucwords($day) ?>: </span><span><?= $time ?></span>
            </div>
        <?php } ?>
            </div>
        </div>
        <?php
        $service_html = ob_get_clean();

        $combined = $sales_html . $service_html;

        return $combined;
  }

  public function register_custom_fields()
  {
    if (function_exists('register_field_group')) {
    }

    if (function_exists('acf_add_options_page')) {
      acf_add_options_page('Vessel Settings');
    }
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_5a5f9f698a6cd',
        'title' => 'Homepage Settings',
        'fields' => [
          [
            'key' => 'field_5a5f9fd4832a3',
            'label' => 'Countdown Timer',
            'name' => 'countdown_timer',
            'type' => 'tab',
            'instructions' => 'This is the timer used for the Black Friday, Christmas, and New Year\'s requests.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => 'field_5a5fc341454e1',
            'label' => 'Countdown Timer',
            'name' => 'countdown_timer',
            'type' => 'checkbox',
            'instructions' => 'Countdown timer as used for Black Friday, Christmas, and New Years',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'choices' => [
              'Enabled' => 'Enabled',
            ],
            'default_value' => [],
            'layout' => 'vertical',
            'toggle' => 0,
          ],
          [
            'key' => 'field_5a5fc6c66c02d',
            'label' => 'Start Date',
            'name' => 'start_date',
            'type' => 'date_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'display_format' => 'm/d/Y',
            'return_format' => 'm/d/Y',
            'first_day' => 1,
          ],
          [
            'key' => 'field_5a5fcad76c02e',
            'label' => 'End Date',
            'name' => 'end_date',
            'type' => 'date_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'display_format' => 'm/d/Y',
            'return_format' => 'm/d/Y',
            'first_day' => 1,
          ],
          [
            'key' => 'field_5bb27b5ac320c',
            'label' => 'Header',
            'name' => 'header',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => 'field_5bb2675e7e923',
            'label' => 'Header Image',
            'name' => 'vessel_header_image',
            'type' => 'image',
            'instructions' =>
              'Header image (example: breast cancer awareness month ribbon). NOTE: Image height is limited with CSS to 55px maximum, but will auto scale its width so it scales.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'return_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
          ],
          [
            'key' => 'vessel_header_image_link_jsldfhglsfagblb',
            'label' => 'Header Image Link',
            'name' => 'vessel_header_image_link',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'placeholder' => 'Ex. /new-vehicles/',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
          ],
          [
            'key' => 'field_5bb27b5ac320d',
            'label' => 'Footer',
            'name' => 'footer',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => 'field_5bb2675e7e924',
            'label' => 'Footer Image',
            'name' => 'vessel_footer_image',
            'type' => 'image',
            'instructions' =>
              'Footer image (example: breast cancer awareness month ribbon). NOTE: Image height is limited with CSS to 55px maximum, but will auto scale its width so it scales.',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'return_format' => 'url',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
          ],
          [
            'key' => 'field_5a5fcdddb071a',
            'label' => 'Feature Button',
            'name' => 'feature_button',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'placement' => 'top',
            'endpoint' => 0,
          ],
          [
            'key' => 'field_5a5fce4eb071b',
            'label' => 'Button Text',
            'name' => 'button_text',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'placeholder' => 'Ex. Why FJ',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
          ],
          [
            'key' => 'field_5a9fce4eb071f',
            'label' => 'Button Link',
            'name' => 'button_link',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'placeholder' => 'Ex. /new-vehicles/',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
            'readonly' => 0,
            'disabled' => 0,
          ],
          [
            'key' => 'field_5a5fce72b071c',
            'label' => 'Button Color',
            'name' => 'button_color',
            'type' => 'text',
            'instructions' => 'Defaults to the site\'s default primary color if empty: FJ blue for most sites, FJ red for Porsche.

You can choose a hex value or color. Ex: #FFFFFF or red',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
          ],
          [
            'key' => 'field_5a5fc341464e1',
            'label' => 'Add radioactive red glow',
            'name' => 'radioactive',
            'type' => 'checkbox',
            'instructions' => 'As used for Christmas and New Years 2017',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'choices' => [
              'Enabled' => 'Enabled',
            ],
            'default_value' => [],
            'layout' => 'vertical',
            'toggle' => 0,
          ],
          [
            'key' => 'field_5a19c341464e1',
            'label' => 'Enable feature button',
            'name' => 'featurebtn',
            'type' => 'checkbox',
            'instructions' => 'Show feature button on homepage? <b>Fletcherjones.com only.</b>',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'choices' => [
              'Enabled' => 'Enabled',
            ],
            'default_value' => [],
            'layout' => 'vertical',
            'toggle' => 0,
          ],
        ],
        'location' => [
          [
            [
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'acf-options-vessel-settings',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
      ]);

      acf_add_local_field_group([
        'key' => 'group_5a6660f34749f',
        'title' => 'Holiday Hours',
        'fields' => [
          [
            'key' => 'field_5a66610b0af50',
            'label' => 'Hours',
            'name' => 'holiday_hours',
            'type' => 'repeater',
            'instructions' =>
              'Generates holiday hours text to be used with the [fj_holiday_hours /] shortcode. <b>First row is treated as Sales, second row is treated as Service.</b> Produces format of Day: 9:00 AM - 10 PM',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'collapsed' => '',
            'min' => '',
            'max' => '2',
            'layout' => 'table',
            'button_label' => 'Add Row',
            'sub_fields' => [
              [
                'key' => 'field_5a6662370af51',
                'label' => 'Monday',
                'name' => 'monday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
              [
                'key' => 'field_5a66627e0af52',
                'label' => 'Tuesday',
                'name' => 'tuesday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
              [
                'key' => 'field_5a6662c60af53',
                'label' => 'Wednesday',
                'name' => 'wednesday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
              [
                'key' => 'field_5a6662cf0af54',
                'label' => 'Thursday',
                'name' => 'thursday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
              [
                'key' => 'field_5a6662d70af55',
                'label' => 'Friday',
                'name' => 'friday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
              [
                'key' => 'field_5a6662df0af56',
                'label' => 'Saturday',
                'name' => 'saturday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
              [
                'key' => 'field_5a6662e80af57',
                'label' => 'Sunday',
                'name' => 'sunday',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
                'readonly' => 0,
                'disabled' => 0,
              ],
            ],
          ],
        ],
        'location' => [
          [
            [
              'param' => 'options_page',
              'operator' => '==',
              'value' => 'acf-options-vessel-settings',
            ],
          ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
      ]);
    endif;
  }

  public function dequeue_default_css()
  {
    if (wp_style_is('base-child-style', 'enqueued')) {
      wp_deregister_style('base-child-style');
      wp_dequeue_style('base-child-style');
    }

    $enqueued_dealertheme_styles = [
      'base-child-style-home',
      'base-child-style-vrp',
      'base-child-style-vdp',
      'base-child-style-inside',
    ];

    foreach ($enqueued_dealertheme_styles as $style) {
      if (wp_style_is($style, 'enqueued')) {
        wp_deregister_style($style);
        wp_dequeue_style($style);
      }
    }
  }

  public function flipclock_file_hooks()
  {
    wp_register_script('flipclockjs', plugins_url() . '/vessel/content/shared/flipclock/flipclock.min.js');
    wp_enqueue_script('flipclockjs', null, ['jquery'], null, true);
  }

  public function flipclock_hooks()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_flipclock_assets']);
    add_action('wp_enqueue_scripts', [$this, 'flipclock_file_hooks']);
    add_action('wp_enqueue_scripts', [$this, 'flipclock_styles']);
  }

  public function flipclock_styles()
  {
    wp_enqueue_style('flipclock-fixes', plugins_url() . '/vessel/content/shared/flipclock/fixes.css');
    wp_enqueue_style('flipclock-styles', plugins_url() . '/vessel/content/shared/flipclock/flipclock.min.css');
  }

  public function enqueue_flipclock_assets()
  {
    $end_date = get_field('end_date', 'option');

    $countdown_timer_assets = [
      'vesselEndDate' => $end_date,
    ];

    wp_register_script('vessel-flipclock', plugins_url() . '/vessel/content/shared/flipclock/homepage-timer.js');
    wp_enqueue_script(
      'vessel-flipclock',
      plugins_url() . '/vessel/content/shared/flipclock/homepage-timer.js',
      ['jquery'],
      null,
      true,
    );

    wp_localize_script('vessel-flipclock', 'vesselTimerAssets', $countdown_timer_assets);
  }

  public function enqueue_vessel_scripts()
  {
    //Enqueue JS from Vessel

    //I see this all over the place, enqueuing it because why not
    wp_enqueue_script('jquery-ui-accordion', false, ['jquery', 'jquery-ui-core']);

    if (!$this->vessel->is_prod()) {
      wp_register_script(
        $this->_fj->get_di_slug() . '-script',
        plugins_url() .
          '/vessel/content/dealers/' .
          $this->_fj->get_di_slug() .
          '/js/' .
          $this->_fj->get_di_slug() .
          '-vessel.js',
        ['jquery'],
        filemtime(
          $this->vessel->get_plugin_path() .
            'content/dealers/' .
            $this->_fj->get_di_slug() .
            '/js/' .
            $this->_fj->get_di_slug() .
            '-vessel.js',
        ),
        true,
      );
      wp_enqueue_script($this->_fj->get_di_slug() . '-script');

      return;
    }

    if (
      file_exists(
        $this->vessel->get_plugin_path() .
          'content/dealers/' .
          $this->_fj->get_di_slug() .
          '/js/min/' .
          $this->_fj->get_di_slug() .
          '-vessel.min.js',
      )
    ) {
      wp_register_script(
        $this->_fj->get_di_slug() . '-script',
        plugins_url() .
          '/vessel/content/dealers/' .
          $this->_fj->get_di_slug() .
          '/js/min/' .
          $this->_fj->get_di_slug() .
          '-vessel.min.js',
        ['jquery'],
        filemtime(
          $this->vessel->get_plugin_path() .
            'content/dealers/' .
            $this->_fj->get_di_slug() .
            '/js/min/' .
            $this->_fj->get_di_slug() .
            '-vessel.min.js',
        ),
        true,
      );
      wp_enqueue_script($this->_fj->get_di_slug() . '-script');
    }
  }

  public function enqueue_shared_vessel_stylesheet()
  {
    if (file_exists($this->vessel->get_plugin_path() . 'content/shared/styles/fj-vessel-shared-styles.min.css')) {
      wp_register_style(
        'vessel-shared-stylesheets',
        plugins_url() . '/vessel/content/shared/styles/fj-vessel-shared-styles.min.css',
        ['vessel-style-css-home'],
        filemtime($this->vessel->get_plugin_path() . 'content/shared/styles/fj-vessel-shared-styles.min.css'),
        'all',
      );

      wp_enqueue_style('vessel-shared-stylesheets');
    }
  }

  public function enqueue_shared_js()
  {
    if (file_exists($this->vessel->get_plugin_path() . 'content/shared/min/shared-scripts.min.js')) {
      wp_register_script(
        $this->_fj->get_di_slug() . '-shared-scripts',
        plugins_url() . '/vessel/content/shared/min/shared-scripts.min.js',
        ['jquery'],
        filemtime($this->vessel->get_plugin_path() . 'content/shared/min/shared-scripts.min.js'),
        true,
      );

      $shuttle_form = $this->_fj::get_form_id('Airport Shuttle Scheduler');

      $is_MB_site = 0;
      if (in_array($this->_fj->get_di_id(), $this->_mercedes->get_mercedes_dealers())) {
        $is_MB_site = 1;
      }

      wp_localize_script($this->_fj->get_di_slug() . '-shared-scripts', 'variables', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'shuttle_form' => $shuttle_form,
        'is_MB' => $is_MB_site,
      ]);

      wp_enqueue_script($this->_fj->get_di_slug() . '-shared-scripts');
    }
  }

  public function enqueue_vessel_styles()
  {
    $dealerRootCSS = $this->vessel->get_plugin_path() . 'content/dealers/' . $this->_fj->get_di_slug() . '/css/';

    if (file_exists($dealerRootCSS . $this->_fj->get_di_slug() . '.min.css')) {
      wp_enqueue_style(
        'vessel-style-css-home',
        plugins_url() .
          '/vessel/content/dealers/' .
          $this->_fj->get_di_slug() .
          '/css/' .
          $this->_fj->get_di_slug() .
          '.min.css',
        [],
        filemtime(
          $this->vessel->get_plugin_path() .
            'content/dealers/' .
            $this->_fj->get_di_slug() .
            '/css/' .
            $this->_fj->get_di_slug() .
            '.min.css',
        ),
      );
    }

    if (file_exists($dealerRootCSS . 'home.min.css') && is_front_page()) {
      wp_enqueue_style(
        'vessel-base-child-style-home',
        plugins_url() . '/vessel/content/dealers/' . $this->_fj->get_di_slug() . '/css/home.min.css',
        [],
        filemtime(
          $this->vessel->get_plugin_path() . 'content/dealers/' . $this->_fj->get_di_slug() . '/css/home.min.css',
        ),
      );
    }

    if (
      (file_exists($dealerRootCSS . 'vrp.css') || file_exists($dealerRootCSS . 'vrp.min.css')) &&
      \DIFunctions::is_inventory_page()
    ) {
      wp_enqueue_style(
        'vessel-base-child-style-vrp',
        plugins_url() . '/vessel/content/dealers/' . $this->_fj->get_di_slug() . '/css/vrp.min.css',
        [],
        filemtime(
          $this->vessel->get_plugin_path() . 'content/dealers/' . $this->_fj->get_di_slug() . '/css/vrp.min.css',
        ),
      );
    }

    if (
      (file_exists($dealerRootCSS . 'vdp.css') || file_exists($dealerRootCSS . 'vdp.min.css')) &&
      \DIFunctions::is_vehicle_page()
    ) {
      wp_enqueue_style(
        'vessel-base-child-style-vdp',
        plugins_url() . '/vessel/content/dealers/' . $this->_fj->get_di_slug() . '/css/vdp.min.css',
        [],
        filemtime(
          $this->vessel->get_plugin_path() . '/content/dealers/' . $this->_fj->get_di_slug() . '/css/vdp.min.css',
        ),
      );
    }

    if (
      (file_exists($dealerRootCSS . 'inside.css') || file_exists($dealerRootCSS . 'inside.min.css')) &&
      \DIFunctions::is_vehicle_page()
    ) {
      wp_enqueue_style(
        'vessel-base-child-style-vdp',
        plugins_url() . '/vessel/content/dealers/' . $this->_fj->get_di_slug() . '/css/inside.min.css',
        [],
        filemtime(
          $this->vessel->get_plugin_path() . '/content/dealers/' . $this->_fj->get_di_slug() . '/css/inside.min.css',
        ),
      );
    }

    if (
      file_exists(
        $this->vessel->get_plugin_path() . 'content/dealers/' . $this->_fj->get_di_slug() . '/css/inside.min.css',
      )
    ) {
      if (
        (!is_front_page() && !\DIFunctions::is_inventory_page() && !\DIFunctions::is_vehicle_page()) ||
        (function_exists('is_di_page_composer') && is_di_page_composer())
      ) {
        wp_enqueue_style(
          'vessel-base-child-style-inside',
          plugins_url() . '/vessel/content/dealers/' . $this->_fj->get_di_slug() . '/css/inside.min.css',
          [],
          filemtime(
            $this->vessel->get_plugin_path() . 'content/dealers/' . $this->_fj->get_di_slug() . '/css/inside.min.css',
          ),
        );
      }
    }
  }

  public function return_new_footer_template()
  {
    if (!isUsingSiteBuilderFooter()) {
      $new_template = $this->vessel->get_vessel_template('footer-content.php');
      include $new_template;
    }
  }

  public function return_new_header_template()
  {
    if (
      !isUsingSiteBuilderHeader() &&
      !is_page_template('templates/page-kiosk.php') &&
      false == get_option('dealerinspire-assets_di_stacks_convert_header', false)
    ) {
      $new_template = $this->vessel->get_vessel_template('header-content.php');
      include $new_template;
    }
  }

  function addTopStacks($stacks)
  {
    // Add if convert header is toggled on and site builder is off
    if (!isUsingSiteBuilderHeader() && \get_option('dealerinspire-assets_di_stacks_convert_header', false)) {
      $stacks[] = [
        'id' => 'header-content',
        'filePath' => $this->vessel->get_vessel_template('header-content.php'),
      ];
    }

    return $stacks;
  }

  public function enqueue_vessel_functions_file()
  {
    if (file_exists($this->vessel->get_plugin_path() . 'content/dealers/shared/fj-shared-functions-vessel.php')) {
      include_once $this->vessel->get_plugin_path() . '/content/dealers/shared/fj-shared-functions-vessel.php';
    }

    if (
      file_exists($this->vessel->get_plugin_path() . 'content/dealers/' . $this->_fj->get_di_slug() . '/functions.php')
    ) {
      include_once $this->vessel->get_plugin_path() .
        '/content/dealers/' .
        $this->_fj->get_di_slug() .
        '/functions.php';
    }
  }

  public function use_vessel_homepage($template)
  {
    if (is_front_page()) {
      $new_template = $this->vessel->get_plugin_path() . 'content/vessel/vessel-main-page.php';
      if (file_exists($new_template)) {
        return $new_template;
      }
    }
    return $template;
  }

  public function use_new_single_template($template)
  {
    if (is_single()) {
      $new_template = $this->vessel->get_plugin_path() . 'content/shared/templates/blog/custom-single.php';
      if (file_exists($new_template)) {
        return $new_template;
      }
    }
    return $template;
  }

  public function use_new_blog_template($template)
  {
    if ((is_category() || is_home()) && get_field('use_custom_blog_template', 'option')) {
      $new_template = $this->vessel->get_plugin_path() . 'content/shared/templates/blog/custom-blog.php';
      if (file_exists($new_template)) {
        return $new_template;
      }
    }
    return $template;
  }

  public function add_mb_styles()
  {
    //Loading MB Corpo S font
    wp_deregister_style('mercedesfont');
    wp_dequeue_style('mercedesfont');

    wp_register_style(
      'mercedesfont-ca',
      plugins_url() . '/vessel/content/shared/styles/mercedes-benz-fonts-canada.css',
    );
    wp_enqueue_style('mercedesfont-ca');
  }

  public function mb_actions_filters()
  {
    add_action('wp_enqueue_scripts', [$this, 'add_mb_styles'], 999999999999999);
  }

  public function override_js()
  {
    wp_dequeue_script('custom');
  }

  public function admin_style()
  {
    // wp_enqueue_style('vessel-admin-styles', get_template_directory_uri().'/admin.css');

    wp_register_style(
      'vessel-admin-styles',
      plugins_url() . '/vessel/content/shared/styles/admin/popup-pro.min.css',
      '',
      filemtime($this->vessel->get_plugin_path() . 'content/shared/styles/admin/popup-pro.min.css'),
      'all',
    );

    wp_enqueue_style('vessel-admin-styles');
  }
}
