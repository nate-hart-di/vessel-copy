<?php

namespace DealerInspire\Vessel;

class FJAutoGravity {

    private $_ag_id;
    private $_vessel;

    private $_tool_data = array(
        'name' => 'Autogravity',
        'label' => 'Calculate Payments',
        'form_id' => '',
        'link' => 'javascript:void(0)',
        'mobile_url' => false,
        'target' => '_self',
        'html' => '',
        'rel' => '',
        'svg_icon_slug' => 'calculator',
        'parent_css_class' => '',
        'css_class' => 'ag-finance',
        'id_attr' => '',
        'attach_id' => '',
        'img' => '',
        'alt' => '',
        'popover_state' => 'disabled',
        'conditional' => 'false',
        'data' => array(
            'autogravity' => '{}'
        ),
        'custom_html' => array()
    );

    function __construct(FJ $FJ, Vessel $vessel)
    {
        $this->_ag_id = $FJ->get_ag_id();
        $this->_vessel = $vessel;
    }

    public function add_all_ag_hooks() {
//        add_action('wp_footer', array($this, 'wp_head'));
        add_action('wp_enqueue_scripts', array($this,'fj_ag_scripts'));

        // add_filter('im_admin_action_links', array($this, 'add_tool'), 11, 1);
        // add_filter('im_default_setting_values', array($this, 'add_defaults'), 11, 1);
        add_action('get_vehicle_array', array($this, 'add_autogravity_json_to_vehicle_array'), 10, 1);
        add_filter('vdp_shopping_tools', array($this, 'inject'), 10, 1);
        add_action('hotwheels_below_cta_box', array($this, 'vdp_placement'), 10, 1);
    }

    public function fj_ag_scripts() {
        wp_register_script('fjautogravity', plugins_url() . '/vessel/content/shared/autogravity/autogravity.js', array('jquery'), null, true);
        wp_enqueue_script('fjautogravity', null, array('jquery'), null, true);


    }

    public function wp_head()
    {
        ?>
        <!-- Auto Gravity Implementation -->
        <script type="text/javascript">
          jQuery(document).ready(function($) {
              <?php if( (\DIFunctions::is_vehicle_page() || \DIFunctions::is_inventory_page() || is_front_page()) ): ?>
            (function(doc, id) {
              var js;

              if (doc.getElementById(id)) return;

              js = doc.createElement('script');
              js.id = id;
              js.src = 'https://apply.fjdrive.com/agwhitelabelwidget.js';
              doc.body.appendChild(js);
            })(document, 'autogravity-application-widget');
              <?php endif ?>

            if($(window).width() < 768)
            {
              if(isMobile.iOS())
                $('.fj-drive .android').hide();
              else
                $(".fj-drive .iOS").hide();
            }

          });
        </script>
        <!-- End AG Implementation -->
    <?php }

    public function add_autogravity_json_to_vehicle_array($vehicle)
    {
        if($vehicle['type'] == "New")
        {
            $vehicle['autogravity_json'] = json_encode(
                array(
                    'chromeStyleId' => $vehicle['chrome_style_id'],
                    'dealerId' => $this->_ag_id,
                    'msrp' => $vehicle['msrp'],
                    'imageLink' => $vehicle['thumbnail']
                ) ,
                JSON_UNESCAPED_UNICODE
            );
        }

        return $vehicle;
    }

    /*
     *    Dynamically add our custom tool to the VDP shopping tools
     */
    public function inject($shopping_tools)
    {
        global $inventoryFrontend;
        $vehicle = $inventoryFrontend->data['vehicle'];
        $this->_tool_data['data']['autogravity'] = isset($vehicle['autogravity_json']) ? $vehicle['autogravity_json'] : false;

        $calc = false;

        foreach($shopping_tools as $i => $tool)
        {
            if(strtolower($tool['name']) == "payment calculator")
                $calc = $i;
        }

        // If Payment Calc is in the tools, replace it.  If not, add our tool.
        if($calc)
            $shopping_tools[$calc] = $this->_tool_data;
        else
            $shopping_tools[] = $this->_tool_data;

        return $shopping_tools;
    }

    /*
     *    Place the FJ Drive content on the VDP
     */
    public function vdp_placement($vehicle)
    {
        if($vehicle['type'] == "New")
        {
            self::app_banner_placement("vdp");
        }
    }

    /*
     *    echo HTML for the FJ Drive content on homepage and VDPs
     */
    public static function app_banner_placement($location = "vdp")
    {
        ob_start(); ?>
        <div class="fj-drive <?= $location ?>">
            <img src="/wp-content/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/FJDrive_logo.png" alt="FJ Drive" />
            <div class="buttons">
                <a trid="50a223253e0747f4a0a3d8" trc class="iOS" target="_new" href="https://app.adjust.com/thjdyl">
                    <img class="desktop" src="/wp-content/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/desktop_FJDrive_iOS_button.png" alt="FJ Drive for iOS" />
                    <img class="mobile" src="/wp-content/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/mobile_FJDrive_iOS_button.png" alt="FJ Drive for iOS" />
                </a>
                <a trid="0a23e3055f6c48f6a34157" trc class="android" target="_new" href="https://app.adjust.com/9s7n58">
                    <img class="desktop" src="/wp-content/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/desktop_FJDrive_Android_button.png" alt="FJ Drive for Android" />
                    <img class="mobile" src="/wp-content/themes/DealerInspireCommonTheme/partials/dealer-groups/fletcherjones/mobile_FJDrive_Android_button.png" alt="FJ Drive for Android" />
                </a>
            </div>
            <a trid="23fc07bb1c3540f8b6b57d" trc href="javascript:void(0);" data-autogravity="">Log In <i class="fa fa-caret-right"></i></a>
        </div>
        <?php $html = ob_get_clean();
        echo $html;
    }
}