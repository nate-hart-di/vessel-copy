<?php
namespace DealerInspire\Vessel;
use DealerInspire\Vessel\AcfAdder as AcfAdder;
use Inventory\Vehicles\Entity\Vehicle;

class SharedFunctions
{
    private $_fj;
    private $_mercedes;
    private $_vessel;
    /*
     * Construct
     */
    function __construct(FJ $FJ, Mercedes $mercedes)
    {
        $this->_fj = $FJ;
        $this->_mercedes = $mercedes;

        // Specials carousel
        //add_action('fj_below_homepage_video', array($this, 'below_homepage_video'), 10);

    }

    public function add_homepage_bg_customizer() {
        require_once WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/plugins/HomepageBackgroundImageOverrides/HomepageBackgroundImageOverrides.php';
        $background_image_override = new \DICommonTheme\HomepageBackgroundImageOverrides();
        $background_image_override->setMainBackgroundImageMobile('#videobanner');
    }

    public function add_all_shared_hooks_filters() {
        $this->add_core_hooks_filters();
        $this->add_header_hooks();
        $this->add_navigation_hooks();
        $this->add_body_hooks();
        $this->add_inventory_hooks();
        $this->add_fj_cache_control_hooks();
    }

    public function add_core_hooks_filters() {
        add_action('plugins_loaded',[$this,'callback_all_plugins_loaded'],99,1);

        add_filter('difo_registered_namespaces', [$this, 'fletcherjones_fixedops']);
        add_filter( 'comment_form_defaults', [$this, 'add_share_thoughts_blog']);
        add_action( 'wp_ajax_nopriv_di_hours', [$this, 'di_hours'] );
        add_action( 'wp_ajax_di_hours', [$this,'di_hours'] );
        add_filter('upload_mimes', [$this,'cc_mime_types'] );
        add_filter( 'user_can_richedit', [$this,'disable_visual_editor'],999,1);

    }

    public function add_header_hooks() {
        add_action('init', array($this, 'register_shortcodes'));
        add_action( 'init', array($this,'new_thumbnail_img'), 15 );
        add_filter('enable_di_back_button', array($this, 'back_button'), 30, 1);
        add_action('wp_enqueue_scripts', array($this, 'load_shared_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'add_custom_conversations_styles'));
        add_action('wp_enqueue_scripts', array($this, 'script_dequeues'),PHP_INT_MAX);
        add_filter('algolia_inventory_synonyms',array($this, 'vessel_inventory_synonyms'), 1, 1);
        add_action('porsche_top_item',array($this, 'google_translate'), 1, 1);
    }

    public function add_navigation_hooks() {
        add_filter('nav_menu_link_attributes', [$this, 'remove_main_menu_title_attr'], 20, 4);
    }

    public function add_body_hooks() {
        add_action('wp_head', array($this, 'wp_head'), 10);
        //add_action('wp_footer', array($this, 'homepage_carousel_script'), 60);
        add_filter('body_class', array($this, 'add_class_to_specials_page'), 10, 1);
        add_filter('body_class', array($this, 'add_3rd_party_class'), 10, 1);
        add_filter('body_class', array($this, 'add_vrp_class'), 10, 1);
        add_filter('body_class', array($this, 'add_service_class'), 10, 1);
        add_action('wp_footer',array($this, 'di_archives_shortcode_js'),10);
        add_filter('im_vdp_hotwheels_ctabox_bottom_offset',array($this,'ctabox_footer_offset') );

        add_action('wp_footer',array($this,'dipc_lightning_mobile_filter'));
        add_action('mobile_tabs_contact_add_phone_numbers',array($this,'mobile_phone_numbers'));
        add_action('bottom_mobile_content_tab',array($this,'mobile_content_tab_bottom_content'));

        add_action('blog_archive_before_main_loop',array($this, 'blog_archive_before_main_loop'));
    }

    public function callback_all_plugins_loaded(){
        $this->add_inventory_hooks();
    }

    public function add_inventory_hooks() {
        // Inventory Hooks
        add_action('im_homepage_search_filter_vehicle_attributes', array($this, 'use_chrome_trim'), 10, 1);
        add_action('vehicle_pre_save', array($this, 'inventory'), 11, 1);
        if ( !in_array($this->_fj->get_di_id(), array(571, 535)) ) { // Exclude MB Ontario & MB Chicago, all VRP CTAs in Action Links
          add_action('post_button_bar_buttons', array($this, 'post_button_bar_buttons'), 10, 1);
        }
        add_filter('vdp_link_url_variables', array($this, 'vdp_link_url_variables'), 10, 1);
        add_filter('im_premium_options_keys', array($this, 'expand_premium_features_search_values'));
        add_filter('im_premium_options_list', [$this,'add_premium_options'], 10, 1);
        add_filter('get_vehicle_array', array($this, 'amg_vehicle_titles'), 12);
        add_filter('algolia_vehicle_types', array($this, 'set_algolia_vehicle_types'));
        add_filter('im_sold_vehicle_redirect_url', array($this, 'set_sold_vehicle_redirect_url'));
        add_filter('algolia_inventory_synonyms',array($this,'algolia_synonyms'),99,1);
        add_filter('vehicle_pre_save', array($this, 'add_amg_line_package_to_vrp_feature_filter'));
        add_filter('di_google_events_form_type_mapping', array($this, 'change_form_tracking_types'));

        // VDP Hooks
        if (is_prod() && $this->_fj->get_di_id() === 435) {
            add_filter('di_hotwheels_gallery_path', array($this, 'hotwheels_gallery_path'));
        }

        add_filter('di_hotwheels_show_lightbox_gallery', array($this, 'use_vdp_gallery_lightbox'));

        add_filter('hotwheels_below_cta_box', array($this, 'hotwheels_below_cta_box'), 10, 1);
        add_filter('di_common_svg_dirs', array($this, 'di_common_svg_dirs'), 10, 1);

        // Misc Hooks
        add_filter('special_service_layout', array($this, 'coupon_service_template'), 999, 3 );
        //add_filter('user_can_richedit', array($this, 'remove_rich_edit_access'));
        add_filter('text_specials_print_button', array($this, 'change_print_button_text'), 10, 3);
        add_filter('di_template_available_directories', [$this,'fixedops_custom_template'], 30, 3);
        add_filter('difo_button_wrapper_classes', [$this,'fixedops_button_classes'],30,1);
        add_filter('inventory-display-vrp-sorter', [$this,'lvrp_custom_sorts'], 10,1);
    }

    public function enqueue_flipclock() {
        wp_enqueue_script('flipclockjs', 'https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.js', array('jquery'), null, true);
        wp_enqueue_style('flipclockcss', 'https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.min.css');
    }

    public function add_share_thoughts_blog($defaults) {
        $defaults['title_reply'] = "Share Your Thoughts";
        return $defaults;
    }

    /*
     *    Register the custom sidebars for the sites
     */
    public function register_sidebars()
    {
        register_nav_menus(
            array(
                'simple-main-menu' => 'Simple Main Menu'
            )
        );
        register_sidebar(array(
                'name'  => 'New Vehicle Menu',
                'id'    => "new-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<span class="widgettitle">',
                'after_title'   => '</span>' )
        );

        register_sidebar(array(
                'name'  => 'Nearly New Menu',
                'id'    => "nearly-new-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<span class="widgettitle">',
                'after_title'   => '</span>' )
        );

        register_sidebar(array(
                'name'  => 'Pre-Owned Vehicle Menu',
                'id'    => "used-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<span class="widgettitle">',
                'after_title'   => '</span>' )
        );

        register_sidebar(array(
                'name'  => 'Special Offers Sidebar',
                'id'    => "special-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'  => '</div>',
                'before_title'  => '<span class="widgettitle">',
                'after_title'   => '</span>' )
        );

        register_sidebar(array(
                'name'  => 'Finance Menu',
                'id'    => "finance-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'    => '</div>',
                'before_title'    => '<span class="widgettitle">',
                'after_title'     => '</span>' )
        );

        register_sidebar(array(
                'name'  => 'Service Menu',
                'id'    => "service-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'    => '</div>',
                'before_title'    => '<span class="widgettitle">',
                'after_title'     => '</span>' )
        );

        register_sidebar(array(
                'name'  => 'About Menu',
                'id'    => "about-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'    => '</div>',
                'before_title'    => '<span class="widgettitle">',
                'after_title'     => '</span>' )
        );
        register_sidebar(array(
                'name'  => 'Vans Menu',
                'id'    => "vans-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'    => '</div>',
                'before_title'    => '<span class="widgettitle">',
                'after_title'     => '</span>' )
        );
        register_sidebar(array(
                'name'  => 'Next to New Menu',
                'id'    => "next-to-new-menu-sidebar",
                'before_widget' => '<div class="widget">',
                'after_widget'    => '</div>',
                'before_title'    => '<span class="widgettitle">',
                'after_title'     => '</span>' )
        );

        if ($this->_fj->get_di_id() != 797) { // Exclude Big Island Honda because we need 2 different hours blocks; one for each store
            register_sidebar(
                array(
                    'name'  => 'Holiday Hours',
                    'id'    => "holiday-hours",
                    'description'   => 'Place content here regarding your holiday hours.',
                    'before_widget' => '<div id="holiday-hours" style="display:none">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<span class="hidden">',
                    'after_title'   => '</span>'
                )
            );
        } else { // These are the Hoilday Hours blocks for Big Island Honda
            register_sidebar(
                array(
                    'name'  => 'Holiday Hours Hilo',
                    'id'    => "holiday-hours-hilo",
                    'description'   => 'Place content here regarding your holiday hours.',
                    'before_widget' => '<div id="holiday-hours-hilo" style="display:none">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<span class="hidden">',
                    'after_title'   => '</span>'
                )
            );
            register_sidebar(
                array(
                    'name'  => 'Holiday Hours Kona',
                    'id'    => "holiday-hours-kona",
                    'description'   => 'Place content here regarding your holiday hours.',
                    'before_widget' => '<div id="holiday-hours-kona" style="display:none">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<span class="hidden">',
                    'after_title'   => '</span>'
                )
            );
        }
    }

    /*
     *    Register the ACF Field Groups for this dealer group
     */
    public function register_shared_acf_groups()
    {
        $id = $this->_fj->get_di_id();

        if (($id == $this->_fj->dealerIdList['fjmercedes']) ||
            ($id == $this->_fj->dealerIdList['fjchicago']) ||
            ($id == $this->_fj->dealerIdList['fjontario']) ||
            ($id == $this->_fj->dealerIdList['fjfremont']) ||
            ($id == $this->_fj->dealerIdList['fjimports']) ||
            ($id == $this->_fj->dealerIdList['fjhenderson']) ||
            ($id == $this->_fj->dealerIdList['fjhonolulu']) ||
            ($id == $this->_fj->dealerIdList['fjmaui'])) {
            AcfAdder::getInstance()->addField('overlay_buttons');
        }

        if( ($id == $this->_fj->dealerIdList['fjmaui']) ||
            ($id == $this->_fj->dealerIdList['fjhonolulu'])
        )
        {
            AcfAdder::getInstance()->addField('homepage_overlay_below_ctas');
        }

        if( ($id == $this->_fj->dealerIdList['fjchicago']) ){
            AcfAdder::getInstance()->addField('homepage_buttons');
        }

        AcfAdder::getInstance()->addField('dipc_lightning_check');
        AcfAdder::getInstance()->addField('header_nav_image');

        // disables conversations proactive messages on all pages but
        AcfAdder::getInstance()->addField('vdp_only_proactive_message');

        // adds a toggle to the settings file to turn on custom ACFs on blog posts
        AcfAdder::getInstance()->addField('blog_toggle');
        if(get_field('use_custom_blog_template', 'option')){
            AcfAdder::getInstance()->addField('blog_template');
        }

        if ( function_exists('acf_add_local_field_group') ) {

            acf_add_local_field_group(array (
                'key' => 'group_5a95d58de8c4c',
                'title' => 'Blog Upsells',
                'fields' => array (
                    array (
                        'key' => 'field_5a95d59747004',
                        'label' => 'Upsells',
                        'name' => 'upsells',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => '',
                        'max' => '',
                        'layout' => 'table',
                        'button_label' => 'Add Upsell',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_5a95d5a147005',
                                'label' => 'Image',
                                'name' => 'image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'array',
                                'preview_size' => 'medium',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ),
                            array (
                                'key' => 'field_5a95d5af47006',
                                'label' => 'Title',
                                'name' => 'title',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0,
                            ),
                            array (
                                'key' => 'field_5a95d5c047007',
                                'label' => 'Link',
                                'name' => 'link',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0,
                            ),
                            array (
                                'key' => 'field_5a95d71c0c88b',
                                'label' => 'Target',
                                'name' => 'target',
                                'type' => 'select',
                                'instructions' => '',
                                'required' => '',
                                'conditional_logic' => '',
                                'wrapper' => array (
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array (
                                    'self' => 'Same Window',
                                    'blank' => 'New Window',
                                ),
                                'default_value' => array (
                                    0 => 'self',
                                ),
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'ajax' => 0,
                                'placeholder' => '',
                                'disabled' => 0,
                                'readonly' => 0,
                            ),
                        ),
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'post',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));

            $blog_css = array (
                'key' => 'group_5866e0c85e05e',
                'title' => 'Custom CSS',
                'fields' => array (
                    array (
                        'key' => 'field_5866e0db4a639',
                        'label' => 'Blog CSS',
                        'name' => 'blog_css',
                        'type' => 'acf_code_field',
                        'instructions' => 'Place your custom post-related CSS here. Please be wary of global classes and ID\'s that may be in use in the header and footer DOM on these pages.<br><b>Do not include the &lt;style&gt; tags.</b>',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'mode' => 'css',
                        'theme' => 'monokai',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'post',
                        ),
                    ),
                    array(
                        array (
                            'param' => 'page_type',
                            'operator' => '==',
                            'value' => 'posts_page',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            );

            acf_add_local_field_group($blog_css);


            acf_add_local_field_group(array(
                'key' => 'group_6303fdb70363e',
                'title' => 'Model List',
                'fields' => array(
                    array(
                        'key' => 'field_63069a19fb1ab',
                        'label' => 'Trim List',
                        'name' => 'trim_list',
                        'type' => 'text',
                        'instructions' => "A list of all model name modifiers used in the model list, separated by commas
            e.g. 4MATIC,All-Terrain,AMG,4-Door,Cabriolet
            Don't include spaces!",
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '4MATIC,All-Terrain,AMG,4-Door,Cabriolet',
                        'placeholder' => '4MATIC,All-Terrain,AMG,4-Door,Cabriolet',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'acf-options-vessel-settings',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
                

            /*
            * Register ACF fields to input stock numbers for custom featured specials
            * on homepage.
            */
            if ($this->_fj->get_di_id() == 777) { // 777 is MB Honolulu
                acf_add_local_field_group(array (
                    'key' => 'group_5899e45156908',
                    'title' => 'Featured Specials',
                    'fields' => array (
                        array (
                            'key' => 'field_5899e4a9ac891',
                            'label' => 'Featured Specials',
                            'name' => 'stock_numbers',
                            'type' => 'tab',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'placement' => 'top',
                            'endpoint' => 0,
                        ),
                        array (
                            'key' => 'field_5899e4ceac892',
                            'label' => 'Custom Specials',
                            'name' => 'custom_specials',
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array (
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => '',
                            'max' => '',
                            'layout' => 'table',
                            'button_label' => 'Add Row',
                            'sub_fields' => array (
                                array (
                                    'key' => 'field_5899e51aac893',
                                    'label' => 'Stock Numbers',
                                    'name' => 'stock_numbers',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array (
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                    'readonly' => 0,
                                    'disabled' => 0,
                                ),
                            ),
                        ),
                    ),
                    'location' => array (
                        array (
                            array (
                                'param' => 'page_type',
                                'operator' => '==',
                                'value' => 'front_page',
                            ),
                        ),
                    ),
                    'menu_order' => 0,
                    'position' => 'normal',
                    'style' => 'default',
                    'label_placement' => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen' => '',
                    'active' => 1,
                    'description' => '',
                ));

            }

        }
    }

    public function load_shared_scripts()
    {
        //    Needed for the VDP "condensed" gallery

        wp_enqueue_style('swiper-css', get_template_directory_uri() . '/includes/js/swiper/swiper.min.css');
        wp_enqueue_script(
            'swiper-js',
            get_template_directory_uri() . '/includes/js/swiper/swiper.jquery.min.js',
            array( 'jquery' ),
            '',
            true
        );
        //not sure if this is needed, added in enqueue class
        /*
        if (in_array($this->_fj->get_di_id(), $this->_mercedes->get_mercedes_dealers())) {
            wp_enqueue_style('mercedesfont', get_template_directory_uri() . '/css/dealer-groups/mercedes-benz/mercedes-benz-fonts.css');
        }
        */

    }

    public function vdp_link_url_variables($keys) {
        return array(
            'type',
            'year',
            'make',
            'model',
            'trim',
            'drivetrain',
            'body',
            'vin'
        );
    }


    /*
     *  Search the packages for features/premium features
     */
    public function expand_premium_features_search_values($premium_options_keys)
    {
        $premium_options_keys['Packages'] = 'packages';
        return $premium_options_keys;
    }

    /*
     * Add AMG Line Package to the Premium options
     */
    public function add_premium_options($list) {
        $features = [
            [
                'name' => 'AMG Line Package',
                'keywords' => [
                    'amg line',
                    'amg line package',
                ],
            ],
        ];

        foreach($features as $feature)
        {
            $f = new \stdClass();
            foreach($feature as $k=>$v)
                $f->{$k} = $v;

            if(!empty($f->name) && !empty($f->keywords))
                $list[] = $f;
        }

        return $list;
    }

    /*
     *    SC #00088459 - Update all AMG vehicles to Mercedes-Benz-AMG instead of Mercedes-Benz AMG
     */
    public function amg_vehicle_titles( $vehicle )
    {
        if (in_array($this->_fj->get_di_id(), $this->_mercedes->get_mercedes_dealers()))
        {
            foreach (['__title', '__title_vrp'] as $title_keys)
            {
                if (preg_match("/(Mercedes-Benz)(\s)(amg)/i", $vehicle->$title_keys) === 1)
                {
                    $vehicle->$title_keys = preg_replace("/(Mercedes-Benz)(\s)(amg)/i", "$1-$3", $vehicle->$title_keys);
                }
            }
        }
        return $vehicle;
    }

    /*
     *    Register the shortcodes for this group
     */
    public function register_shortcodes()
    {
        add_shortcode('show-posts', array($this, 'show_posts'));
        add_shortcode('show-video-gallery', array($this, 'video_gallery'));
        add_shortcode('di_get_archives', array($this,'di_get_archives_shortcode'));
        add_shortcode('reviews-row', array($this,'homepage_reviews'));
        add_shortcode('homepage-search-widget', array($this,'homepage_search_widget'));
    }

    public function register_cpts()
    {
        $video_labels = array(
            'name'  => _x( 'Video Gallery', 'Admin: Video Post Type', 'di-admin' ),
            'singular_name' => _x( 'Gallery Video', 'Admin: Video Post Type', 'di-admin' ),
            'menu_name' => _x( 'Video Gallery', 'Admin: Video Post Type', 'di-admin' ),
            'name_admin_bar'    => _x( 'Video Gallery', 'Admin: Video Post Type', 'di-admin' ),
            'parent_item_colon' => _x( 'Parent Item:', 'Admin: Video Post Type', 'di-admin' ),
            'all_items' => _x( 'All Videos', 'Admin: Video Post Type', 'di-admin' ),
            'add_new_item'  => _x( 'Add Video', 'Admin: Video Post Type', 'di-admin' ),
            'add_new'   => _x( 'Add New', 'Admin: Video Post Type', 'di-admin' ),
            'new_item'  => _x( 'New Video', 'Admin: Video Post Type', 'di-admin' ),
            'edit_item' => _x( 'Edit Video', 'Admin: Video Post Type', 'di-admin' ),
            'update_item'   => _x( 'Update Video', 'Admin: Video Post Type', 'di-admin' ),
            'view_item' => _x( 'View Video', 'Admin: Video Post Type', 'di-admin' ),
            'search_items'  => _x( 'Search Videos', 'Admin: Video Post Type', 'di-admin' ),
            'not_found' => _x( 'Not found', 'Admin: Video Post Type', 'di-admin' ),
            'not_found_in_trash'    => _x( 'Not found in Trash', 'Admin: Video Post Type', 'di-admin' )
        );
        $video_args = array(
            'label' => _x( 'video_gallery', 'Admin: Video Post Type', 'di-admin' ),
            'description'   => _x( 'For displaying offer graphics for current promotions', 'Admin: Video Post Type', 'di-admin' ),
            'labels'    => $video_labels,
            'supports'  => array( 'title', ),
            'taxonomies'    => array( 'category', 'post_tag' ),
            'hierarchical'  => false,
            'public'    => true,
            'show_ui'   => true,
            'show_in_menu'  => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-playlist-video',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export'                    => true,
            'has_archive'                 => true,
            'exclude_from_search' => false,
            'publicly_queryable'    => true,
            'capability_type'         => 'page'
        );
        register_post_type( 'video_gallery', $video_args );

        $slide_labels = array(
            'name'  => _x( 'Homepage Slides', 'Admin: Homepage Slides Post Type', 'di-admin' ),
            'singular_name' => _x( 'Homepage Slide', 'Admin: Homepage Slides Post Type', 'di-admin' ),
            'menu_name' => _x( 'Homepage Slides', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'name_admin_bar'    => _x( 'Homepage Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'parent_item_colon' => _x( 'Parent Item:', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'all_items' => _x( 'All Slides', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'add_new_item'  => _x( 'Add Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'add_new'   => _x( 'Add New', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'new_item'  => _x( 'New Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'edit_item' => _x( 'Edit Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'update_item'   => _x( 'Update Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'view_item' => _x( 'View Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'search_items'  => _x( 'Search Slide', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'not_found' => _x( 'Not found', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'not_found_in_trash'    => _x( 'Not found in Trash', 'Admin: Post Type Homepage Slides', 'di-admin' )
        );
        $slide_args = array(
            'label' => _x( 'homepage_slides', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'description'   => _x( 'Full screen sliders on homepage', 'Admin: Post Type Homepage Slides', 'di-admin' ),
            'labels'    => $slide_labels,
            'supports'  => array( 'title', ),
            'taxonomies'    => array( 'category', 'post_tag' ),
            'hierarchical'  => false,
            'public'    => true,
            'show_ui'   => true,
            'show_in_menu'  => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-images-alt',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export'    => true,
            'has_archive'   => true,
            'exclude_from_search' => false,
            'publicly_queryable'    => true,
            'capability_type'   => 'page'
        );
        register_post_type( 'homepage_slides', $slide_args );

    }

    /*
     *    show-posts shortcode
     */
    public function show_posts( $atts , $content = null )
    {
        extract(
            shortcode_atts(
                array(
                    'category' => '',
                    'posts' => '3',
                    'excerpt' => 'true',
                    'date' => 'true',
                    'thumbnail' => 'false',
                    'text' => 'light'
                ),
                $atts
            )
        );
        $args = array (
            'post_type' => 'post',
            'posts_per_page' => $posts,
            'orderby' => 'date',
            'order' => 'DESC',
            'category_name' => $category
        );
        $query = new \WP_Query($args);
        if ($query->have_posts()) {
            ob_start(); ?>

            <ul class="posts list-unstyled clearfix <?php echo ($thumbnail =="true" ? 'withThumbnail ' : '') . ($text != "light" ? $text : "") ?>">
                <?php while ($query->have_posts()) : $query->the_post();
                    $id = get_the_id(); ?>

                    <li class="post">
                        <?php if ($date == 'true' && $thumbnail == "false") { ?>
                            <span class="post-date"><?php echo get_the_date() ?></span>
                        <?php }
                        if ($thumbnail == 'true') { ?>
                            <span class="post-image"><a trid="e546e1679bd1464c95bc37" trc href="<?php echo get_permalink() ?>"><?php echo get_the_post_thumbnail( $id, array('auto',50)) ?></a></span>
                        <?php } ?>
                        <h3><a trid="b8cae36a538b4cb08a8e1b" trc href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a></h3>
                        <?php if ($date == 'true' && $thumbnail == "true") { ?>
                            <span class="post-date"><?php echo get_the_date() ?></span>
                        <?php }
                        if ($excerpt == 'true') { ?>
                            <p><?php echo get_the_excerpt() ?></p>
                        <?php } ?>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php
            $output = ob_get_clean();
        } else {
            $output = "<h3>No posts found at this time.</h3>";
        }

        wp_reset_postdata();

        return $output;
    } // show_posts shortcode

    /*
     *    video-gallery shortcode
     */
    public function video_gallery( $atts , $content = null )
    {
        extract( shortcode_atts(
                array(
                    'category' => '',
                    'posts' => '-1',
                ), $atts )
        );

        $args = array (
            'post_type' => 'video_gallery',
            'posts_per_page' => $posts,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'category_name' => $category
        );

        $query = new \WP_Query($args);
        if ($query->have_posts()) {
            ob_start(); ?>

            <ul class="video-gallery list-unstyled clearfix">
                <?php while ($query->have_posts()) : $query->the_post();
                    $id = get_the_id();
                    $videoid = get_field('video_id');
                    $videothumb = get_field('video_thumbnail');
                    $videotitle = get_field('video_title');
                    $videodesc = get_field('video_description'); ?>

                    <li class="video"><div class="video-top-wrap">
                            <a trid="a135a19834a440afbc6a09" trc href="https://www.youtube.com/embed/<?php echo $videoid ?>?rel=0&amp;autoplay=1" class="various lightbox fancybox.iframe">
                                <img src="<?php echo $videothumb ?>" />
                            </a>
                            <a trid="7ba860a1a06f40c28bd282" trc href="https://www.youtube.com/embed/<?php echo $videoid ?>?rel=0&amp;autoplay=1" class="play-button various lightbox fancybox.iframe">
                                <i class="fa fa-play"></i>
                            </a>
                            <div class="video-bottom-wrap"><h3><?php echo $videotitle ?></h3>
                                <div class="video-description"><?php echo $videodesc ?></div></div>
                    </li>

                <?php endwhile ?>

            </ul>
            <?php
            $output = ob_get_clean();
        } else {
            $output = "<h3>No videos found at this time.</h3>";
        }

        wp_reset_postdata();

        return $output;
    } // video_gallery shortcode

    public function back_button( $enable_di_back_button )
    {
        return true;
    }

    public function wp_head()
    {
        global $post;
        $css = false;

        if (isset($post) && is_singular('post')) {
            $css = get_field("blog_css", $post->ID);
        } elseif ($_SERVER['REQUEST_URI'] == "/blog/") {
            $blog_page = get_option('page_for_posts');
            $css = get_field('blog_css', $blog_page);
        }

        if($css) {
            echo "<style id='custom-blog'>" . $css . "</style>";
        }

    }

    /*
     *    Use Chrome Trim on homepage drop-down filters
     */
    public function use_chrome_trim($attributes)
    {
        $attributes[] = 'chrome_trim';
        return $attributes;
    }

    /*
     *    Change the button label on the print button for service/parts coupons
     */
    public function change_print_button_text(
        $print_button_text,
        $special_id,
        $ctatext1
    ) {
        $print_button_text = "Print Offer";
        return $print_button_text;
    }

    public function fletcherjones_fixedops($templates)
    {
        $templates[] = 'difo_fletcherjones';
        return $templates;
    }

    /*
     *    Apply a class to the body of the Specials VDPs
     */
    public function add_class_to_specials_page( $classes )
    {
        global $inventoryFrontend;
        if ( \DIFunctions::is_vehicle_page() === true )
        {
            if ( isset($inventoryFrontend->data['vehicle']['special_field_1']) && $inventoryFrontend->data['vehicle']['special_field_1'] === 'S' )
            {
                $classes[]= "page-specials-vehicle-page";
            }
        }

        return $classes;
    }

    /*
     *    Handle all the inventory adjustments in the vehicle_pre_save
     */
    public function inventory($vehicle)
    {
        $vehicle->horsepower = "";
        if (isset($vehicle->tech_options) && !empty($vehicle->tech_options))
        {
            $tech_opts = $vehicle->tech_options;
            $has_horsepower = false;
            foreach($tech_opts as $option)
            {
                if (stripos(strtolower($option), "horsepower") !== false)
                {
                    $has_horsepower = $option;
                }
            }
            if ($has_horsepower !== false)
            {
                $horsepower = explode(":", $has_horsepower);
                $horsepower = explode("@", $horsepower[1]);
                $horsepower = trim($horsepower[0]);
                $vehicle->horsepower = $horsepower;
            }
        }
        $model = strtolower($vehicle->model);

        $modelArr = explode('-', $model);
        if (strlen($modelArr[0]) == 3 && isset($modelArr[1]) && strtolower($modelArr[1]) == "class" )
            $vehicle->model = $modelArr[0];

        switch($model)
        {
            case "sl":
                $vehicle->model = "SL-Class";
                break;

            case "m":
            case "ml":
            case "ml-class":
                $vehicle->model = "M-Class";
                break;

            case "gl":
                $vehicle->model = "GL-Class";
                break;

            case "b-class":
                $vehicle->chrome_trim = ( empty($vehicle->chrome_trim) ) ? "Electric Drive" : $vehicle->chrome_trim;
                break;
            case "gt":
            case "amg gt":
            case "amg® gt":
                $vehicle->model = "AMG® GT";
                break;
        }

        foreach(['model','trim'] as $keys)
        {
            if( preg_match("/amg(?:\s|$)/i", $vehicle->$keys ) === 1 )
            {
                $vehicle->$keys = preg_replace("/(amg)(?:\s|$)/i", "$1® ", $vehicle->$keys);
            }
        }

        if ($vehicle->make == "Smart") {
            $vehicle->make = "smart";
        }

        if (!class_exists("FJAutogravity") && isset($vehicle->autogravity_json)) {
            $vehicle->delete_meta("autogravity_json");
        }

        if( isset($vehicle->cylinders) ){
            switch($vehicle->cylinders){
                case "4":
                    $vehicle->custom_engine = "4 Cylinder";
                break;
                case "6":
                    $vehicle->custom_engine = "6 Cylinder";
                break;
                case "8":
                    $vehicle->custom_engine = "8 Cylinder";
                break;
                case "10":
                    $vehicle->custom_engine = "10 Cylinder";
                break;
                case "12":
                    $vehicle->custom_engine = "12 Cylinder";
                break;
                case "electric":
                    $vehicle->custom_engine = "Electric Motor";
                break;
            }
        }

    }

    public function post_button_bar_buttons($vehicle)
    {
        //  If the AG class is enabled and there is json data on the vehicle, then we won't need an href attr, we'll use a data-autogravity attr instead
        $use_ag_data_or_href = class_exists("FJAutogravity") && isset($vehicle['autogravity_json']) && !empty($vehicle['autogravity_json']) && strtolower($vehicle['type']) == "new";

        if ($use_ag_data_or_href) {
            $attr = " data-autogravity='" . $vehicle['autogravity_json'] . "'";
        } else {
            $attr = " href='/apply-for-financing/'";
        }

        echo "<a trid='c891e83c2c4a42deaff21c' trc class='button primary-button block finance-link hidden-all below-price-cta'" . $attr . ">Get Pre-Approved</a>";
    }

    /*
     *    Adjust the service coupon template for larger images and a toggle disclaimer
     */
    public function coupon_service_template($post_content, $coupon_id, $coupon_data)
    {
        $post_content = str_replace('<div class="disclaimer">', '<a class="view-disclaimer-link">View Disclaimer</a><div class="disclaimer"><i class="fa fa-close"></i>', $post_content);
        return $post_content;
    }

    /*
     *    Define the partial path for the Hotwheels VDP main gallery
     */
    public function hotwheels_gallery_path($path)
    {
        $path = 'partials/vdp/project-hotwheels/vehicle-gallery-condensed';
        return $path;
    }

    /*
     *    Turn off the [+] sign on this VDP gallery partial to avoid lightbox conflicts with other callbacks applied to the gallery
     */
    public function use_vdp_gallery_lightbox($booleon)
    {
        if ($this->_fj->get_di_id() == 435 ) {
            $booleon = true;
        } else {
            $booleon = false;
        }

        return $booleon;
    }

    public function hotwheels_below_cta_box($vehicle)
    {

        $value_trade_dealers = [
            416, // FJ Motorcars Fremont
        //    435, // Newport
            571, // Ontario
            570 // Temecula
        ];

        ob_start(); ?>
        <?php
        $premium_options = $this->_build_premium_options($vehicle);
        $premium_options = apply_filters('cta_box_premium_options', $premium_options,$vehicle);
        if(!empty($premium_options) && is_array($premium_options) && (get_option('di_id') != 654 && get_option('di_id') != 421 && get_option('di_id') != 796)) { ?>
            <div id="ctabox-premium-features" class="ctabox-row open">
                <div style="display: none;" class="features-link">
                    <span class="open-toggle">View All<i class="fa fa-angle-right"></i> </span>
                    <span class="close-toggle">Close<i class="fa fa-times"></i> </span>
                </div>
                <h4 class="features-title">
                    Premium Options
                </h4>
                <div class="premium-options-list">
                    <?php foreach($premium_options as $premium_option) {
                        echo sprintf('<li class="list-group-item"><h3>%s%s</h3><p>%s</p></li>',
                            is_array($premium_option) ? (isset($premium_option['name']) ? $premium_option['name'] : $premium_option['header']) : $premium_option,
                            is_array($premium_option) && !empty($premium_option['price']) ? ' <span class="vehicle-package-price "> $'.number_format($premium_option['price'],0).'</span>' : '',
                            is_array($premium_option) ? $premium_option['description'] : ''
                        );
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php echo $html = ob_get_clean();
        echo $html;
    } // oef: hotwheels_below_cta_box()

    private function _build_premium_options($vehicle)
    {
        $premium_options = array();
        foreach(array('factory_options','premium_options') as $key)
        {
            if(!empty($vehicle[$key]) && is_array($vehicle[$key]))
            {
                foreach($vehicle[$key] as $option){

                    if(is_array($option) && isset($option['name']) && in_array(strtoupper($option['name']),['TRANSMISSION','PRIMARY PAINT','ENGINE','WHEELS']) !== false && empty($option['price']))
                        continue;

                    $duplicate = false;
                    foreach($premium_options as $premium_option) {
                        if(isset($option['option_code']) && isset($premium_option['option_code']) && $option['option_code'] == $premium_option['option_code']) {
                            $duplicate = true;
                            break;
                        }
                    }
                    if(!$duplicate) $premium_options[] = $option;
                }

                break;
            }
        }
        return $premium_options;
    }

    /*
     *    Set a custom directory for icon SVGs
     */
    public function di_common_svg_dirs($dirs)
    {
        return array_merge($dirs,array(WP_CONTENT_DIR . '/themes/DealerInspireCommonTheme/includes/svg/sharp_and_thin') );
    } // eof: di_common_svg_dirs()

    // Which vehicles to include in the homepage carousel on which sites
    private $_carousel = [
        'used-cpo' => [ // Pre-Owned and Certified Pre-Owned
            435, // Newport
            571, // Ontario
            570, // Temecula
            416, // MB Fremont
            615, // Henderson
            797, // Big Island Honda
        ],
        'cpo' => [ // Certified Pre-Owned only
            421, // Porsche of Fremont
            796, // Porsche of Hawaii
            1434, // MB of Maui
            616, // FJ Imports
            535 // MB Chicago
        ],
        'custom' => [ // ACF stock repeater (client-chosen vehicles)
            777 // MB Honolulu
        ]
    ];

    //    Exclusions variable for conditional integrations (CURRENTLY FOR HOMEPAGE CAROUSEL)
    private $_exclusions = array(
    );

    /*
     *    Inject the custom specials carousel below the homepage video
     */
    public function below_homepage_video()
    {
        if( !is_front_page()):
            return;
        endif;
        // used-cpo array
        if ( in_array($this->_fj->get_di_id(), $this->_carousel['used-cpo']) ) {
            $s = new InventorySearch;
            $s->type = array('Used', 'Certified Used');

            if ($this->_fj->get_di_id() == 797) { // Compliance fix for Honda
                $s->make = array("Honda");
            }
        } elseif (in_array($this->_fj->get_di_id(), $this->_carousel['custom'])) { // 777 is MB Honolulu
            // get the repeater the stock numbers are being stored in
            $repeater = get_field('custom_specials');
            // instantiate the stock_numbers array
            $stock_numbers = array();

            // Populate the stock_numbers array
            foreach( $repeater as $i => $row ) {
                $stock_numbers[] = $row['stock_numbers'];
            }

            // Set the stock numbers to search for
            $s = new InventorySearch;
            $s->stock = $stock_numbers;
        } elseif(in_array($this->_fj->get_di_id(), $this->_carousel['cpo'])) { // cpo-only
            $s = new InventorySearch;
            $s->type = array('Certified Used');
            $s->special_field_1 = 'S';
        }

        if (isset($s) && is_object($s)) {
            $s->find();
            $vehicles = $s->get_vehicles(0,30);
        }

        if (isset($vehicles) && !empty($vehicles)) {
            // Feature Title to be displayed above the specials carousel
            $feature_title = 'Featured Vehicles'; ?>

            <div id="featuredSpecials">
                <div class="container-wide">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="feature-title"><?php echo $feature_title; ?></h2>
                            <ul id="CPOCarousel" class="special-offers">
                                <?php foreach($vehicles as $v): ?>
                                    <li class="special-offer card hover-effect per-row-3">
                                        <a trid="2bd6c63afc9947ee916279" trc href="<?php echo $v['link'] ?>" >
                                            <img src='<?php echo $v['thumbnail'] ?>' alt="<?php echo esc_attr($v['title']) ?>" />
                                        </a>
                                        <div class="offer-content card-content">
                                            <a trid="72b1f964b75b4109b3a0d0" trc href="<?php echo $v['link'] ?>">
                                                <h2><?php echo $v['title_vrp'] ?></h2>
                                                <div class="rates">
                                                    <div class="offeritem">
                                                        <span class="offerrate">Fletcher Jones Price:</span>
                                                        <span class="offerlabel"><?php echo is_numeric($v['our_price']) ? '$'.number_format($v['our_price'],0) : $v['our_price']; ?></span>
                                                    </div>
                                                </div>
                                                <div style="clear:both"></div>
                                            </a>
                                        </div>
                                        <div class="offerbuttonbar card-action">
                                            <a trid="0671eb76b8f8485a98dd80" trc class="button primary-button block" href="<?php echo $v['link'] ?>">View Vehicle</a>
                                        </div>
                                    </li>
                                <?php
                                endforeach;
                                unset($vehicles);
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }

    public function homepage_carousel_script()
    {
        if(is_front_page() && !in_array($this->_fj->get_di_id(), $this->_exclusions)):
            ?>
            <script type="text/javascript" id="homepage-carousel-script">
              jQuery(document).ready(function($){
                $("#CPOCarousel").owlCarousel({
                  autoPlay: true,
                  stopOnHover: true,
                  navigation: true,
                  navigationText: [
                    "<span class='striped-icon'><i class='fa fa-chevron-left'></i></span>",
                    "<span class='striped-icon'><i class='fa fa-chevron-right'></i></span>"
                  ],
                  items : 3,
                  itemsDesktop : [1399,3],
                  itemsDesktopSmall: [1199,2],
                  itemsTablet: [1024,2],
                  itemsMobile: [767, 1],
                  afterInit: function(owl) {
                    $(owl).addClass("shown");
                  }
                });
              });
              jQuery('body').on('homepage-usp-shown', function() {
                $("#search-overlay #CPOCarousel").owlCarousel({
                  autoPlay: true,
                  stopOnHover: true,
                  navigation: true,
                  navigationText: [
                    "<span class='striped-icon'><i class='fa fa-chevron-left'></i></span>",
                    "<span class='striped-icon'><i class='fa fa-chevron-right'></i></span>"
                  ],
                  items : 3,
                  itemsDesktop : [1399,3],
                  itemsDesktopSmall: [1199,2],
                  itemsTablet: [1024,2],
                  itemsMobile: [767, 1],
                  afterInit: function(owl) {
                    $(owl).addClass("shown");
                  }
                });
              });
              jQuery('body').on("homepage-usp-hidden", function() {
                // Nothing here yet
              });
            </script>
        <?php
        endif;
    }

    /*
        [di_get_archives]
        shortcode takes no inputs yet, outputs archive posts, listed monthly when <1 year old, then yearly
        requires di_archives_shortcode_js()
    */
    public function di_get_archives_shortcode ($atts)
    {
        $wpdb = $GLOBALS['wpdb'];
        $archive_results_html = '';

        $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date)
            FROM $wpdb->posts WHERE post_status = 'publish'
            AND post_type = 'post' ORDER BY post_date DESC");
        if(isset($years)){
            $archive_results_html .= '<span class="widgettitle" >Archives</span>';
            $archive_results_html .= '<ul>';
            foreach($years as $year) :

                $archive_results_html .= '<li><a trid="96ea832096f048829dc58b" trc href="#">'.$year.'</a>';

                $is_hidden = (date('Y') == $year) ? '">'  : ' hidden">';

                $archive_results_html.= '<ul class="archive-sub-menu-'.$year.$is_hidden;

                $months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date)
                FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'
                AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");
                foreach($months as $month) :

                    $month_link = get_month_link($year, $month);
                    $link_date = date( 'F', mktime(0, 0, 0, $month) );
                    $archive_results_html .= '<li><a trid="ae47af2bce0e4c92a1a315" trc href="'.$month_link.'"><span>'.$link_date.'</span></a></li>';

                endforeach;

                $archive_results_html.= '</ul>';

                $archive_results_html.= '</li>';

            endforeach;

            $archive_results_html .= '</ul>';
        }
        return $archive_results_html;
    }

    public function di_archives_shortcode_js()
    {
        ?>
        <script>
          jQuery(function($){
            $("#di_archives_widget > ul > li > a").click(function(e){
              e.preventDefault();
              var clickedYear = $(this).text();
              var targetSubMenu = ".archive-sub-menu-"+clickedYear;
              $(targetSubMenu).toggleClass("hidden");
            });
          });
        </script>
        <?php
    }

    // Removes the hover attributes from the navigation links
    public function remove_main_menu_title_attr($atts, $items, $args, $depth)
    {
        if( isset($args) && !empty($args)){
            if( isset($args->menu) ){
                if( isset($args->menu->slug) ){
                    if($args->menu->slug == "main-menu") {
                        $atts['title'] = "";
                    }
                }
            }
        }

        return $atts;
    }


    public function holiday_homepage_scripts()
    { ?>
        <style>
            @media(min-width:767px) {
                #preferredownersRow {
                    display:none;
                }

                .flip-clock-wrapper {
                    width: auto !important;
                }
            }

            @media (max-width: 767px) {
                .clock.flip-clock-wrapper {
                    zoom: 0.4 !important;
                }
            }


            #whitewrap > a.striped-icon {
                display:none;
            }
            #videobanner #videooverlay {
                top:40%;
            }
            #homepage-advanced-search form#searchform input.alg-searc-class {
                background: transparent;
                border-bottom: 1px solid #fff;
                color:#fff;
            }
            @media (max-width:1024px) {
                #videobanner #videooverlay {
                    top:30%;
                }
                #videobanner #videooverlay .videooverlay-content .homepage-timer {
                    transform: scale(.8);
                }

            }

            @media(min-width: 1025px) {
                .flip-clock-wrapper {
                    width: 620px !important;
                    margin: 20px auto !important;
                }
            }

            .flip-clock-label {
                color: #fff !important;
            }

            .flip-clock-wrapper ul li a div div.inn {
                font-size:35px;
                text-size-adjust: none !important;
            }

        </style>

        <script type="text/javascript" id="fj-custom-holiday-scripts">
          jQuery(document).ready(function($){

            var now = new Date();

            var newYear = new Date(2018, 0, 1)

            var diff = (newYear.getTime()/1000) - (now.getTime()/1000);

            var clock = new FlipClock($('.clock'),diff,{
              clockFace: 'DailyCounter',
              countdown: true
            })

          });
        </script>

    <?php }

    public function set_algolia_vehicle_types($types)
    {
        // SC 00109547
        return array(array('type:New', 'type:Used', 'type:Certified Used','type:Certified Pre-Owned','type:Pre-Owned'));
    }

    public function set_sold_vehicle_redirect_url($redirect_url)
    {
        // SC 00139813
        $post_id = get_option('di_page_used_vehicles');

        if(!empty($post_id)){
            $redirect_url = get_permalink($post_id);
        }
        return $redirect_url;
    }

    public function algolia_synonyms($syns) {
        $syns[] = array('a class', 'a-class');
        $syns[] = array('c class', 'c-class');
        $syns[] = array('e class', 'e-class');
        $syns[] = array('g class', 'g-class');
        $syns[] = array('gl class', 'gl-class');
        $syns[] = array('m class', 'm-class');
        $syns[] = array('s class', 's-class');
        $syns[] = array('sl class', 'sl-class');
        return $syns;
    }

    public function fixedops_custom_template($dirs, $namespace, $templates) {
      $_dirs = [];
      $_dirs[] = WP_CONTENT_DIR . "/plugins/vessel/content/shared/templates/difixedops/" . $namespace;
      $_dirs = array_merge($_dirs, $dirs);

      return $_dirs;
    }

    public function fixedops_button_classes($classes) {
    //    var_dump($buttons);
    //    die();
        foreach($classes as $class){
            if( strpos($class, 'service') !== false ){
                $classes[] = 'difo-service-button';
            }
            else if( strpos($class, 'parts') !== false  ){
                $classes[] = 'difo-parts-button';
            }
        }

        return $classes;
    }

    public function add_amg_line_package_to_vrp_feature_filter($vehicle){
        if( !empty( $vehicle->factory_options ) && is_array( $vehicle->factory_options ) ){
            if(in_array('321', array_column($vehicle->factory_options, 'option_code'))){
                $vehicle->features[] = 'AMG Line package';
                sort($vehicle->features);
            }
        }
    }

    public function di_hours(){
        ob_start();
        get_shared_template('homepage/header-dealer-hours');
        $html = ob_get_clean();

        wp_send_json_success(array(
            "success" => true,
            "data" =>  $html
        ));
        exit;
    }

    public function ctabox_footer_offset(){
        return '( bottomOffset + 600);';
    }

    public function dipc_lightning_mobile_filter(){
        if( get_field('is_using_lightning_shortcode') ) :
        ?>
        <div class="lvrp-mobile-filters" data-collapsed="true">
            <div class="mobile-facets-wrapper" style="height: 0px">
                <div class="mobile-facets-container">
                    <div class="mobile-stats"><span class="stats"></span></div>
                    <div class="scroll-wrap">
                        <div class="facets-toggles"></div>
                    </div>
                    <div class="refinement-filters-row">
                        <ul class="refinement-filters"></ul>
                    </div>
                </div>
            </div>
            <div class="mobile-filter-toggles"></div>
            <div id="mobile-lightning-search" class="mobile-search-field">
            </div>
        </div>
        <?php endif;
    }

    public function mobile_phone_numbers(){
        $id = $this->_fj->get_di_id();
        $dealerList = [
            'fjfremont',
            'fjhenderson',
            'fjimports',
            'fjhonolulu',
            'fjmaui'
        ];
        foreach( $dealerList as $dealer ){
            if( $id == $this->_fj->dealerIdList[$dealer] ){
                return array(
                    array(
                        'label' => 'Sales',
                        'number' => get_option('di_phone_mobile_sales') ? get_option('di_phone_mobile_sales') : get_option('di_phone_sales')
                    ),
                    array(
                        'label' => 'Service',
                        'number' => get_option('di_phone_mobile_service') ? get_option('di_phone_mobile_service') : get_option('di_phone_service')
                    ),
                );
            }
        }
    }

    public function mobile_content_tab_bottom_content(){
        $id = $this->_fj->get_di_id();
        $dealerList = [
            'fjfremont',
            'fjhenderson',
            'fjimports',
            'fjhonolulu',
            'fjmaui'
        ];
        foreach( $dealerList as $dealer ) :
            if( $id == $this->_fj->dealerIdList[$dealer] ) : ?>
                <div class="ourhours">
                    <p class="service"><?php echo do_shortcode('[di_display_open_hours departments="Service & Parts" class=dynamic-hours]'); ?></p>
                </div>
            <?php endif;
        endforeach;
    }

    function homepage_reviews($atts) {
        extract(
            shortcode_atts(
                array(
                    'review_link' => '',
                    'review_title' => '',
                    'review_id' => '',
                    'review_text' => '',
                ),
                $atts
            )
        );
        ob_start();
        get_frontend_component('homepage/homepage-reviews-row','',
            array(
                'review_link'=>$review_link,
                'review_title'=>$review_title,
                'review_id'=>$review_id,
                'review_text'=>$review_text
            )
        );
        $output =  ob_get_clean();
        return $output;
    }

    public function script_dequeues(){

    //    global $wp_scripts;
    //    var_dump($wp_scripts);
    //    die();

    //        global $wp_styles;
    //    var_dump($wp_styles);
    //    die();
        $scriptList = [
        //    "di-personalize_site",
        //    "jquery",
        //    "di-geolocation-js",
        //    "di-google-analytics-local-js",
        //    "di-shift-digital-js",
        //    "jquery-ui-core",
        //    "jquery-ui-widget",
        //    "jquery-ui-position",
        //    "jquery-ui-menu",
        //    "wp-a11y",
        //    "jquery-ui-autocomplete",
        //    "mvnAlgoliaSearch",
        //    "algolia-frontend",
        //    "tp-referral-js",
        //    "jquery-ui-accordion",
        //    "fletcherjonesmercedesbenzofmaui-script",
        //    "swiper-js",
        //    "fjautogravity",
            "vessel-flipclock",
            "flipclockjs",
            "flexslider_js",
        //    "lazy-load",
        //    "jquery-migrate",
        //    "search-filters-js",
        //    "jquery-ui-datepicker",
        //    "gforms_datepicker",
        //    "owl-carousel",
        //    "bootstrap-js",
        //    "fancybox-js",
        //    "placehold",
        //    "application",
        //    "equalHeights",
        //    "matchHeight",
            "vide",
        //    "sidr",
            "skrollr",
        //    "reviews",
        //    "touchwipe",
        //    "savethings",
        //    "dealer-custom",
        //    "Roxanne",
        //    "wpmu-public-min-js",
        //    "underscore",
        //    "inventory",
            "gforms_character_counter",
        //    "wp-embed",
        //    "fletcherjonesmercedesbenzofmaui-shared-scripts",
            "gform_placeholder",
            "no_captcha_recaptcha_internal",
            "no_captcha_recaptcha",
            "gform_json",
            "gform_gravityforms",
            "gform_datepicker_init",
            "gform_masked_input",
            "google-maps-api",
            "online-shopper-v2-js",
            "di-os-js"
        ];

        $styleList = [
        //    'im_admin',
        //    'admin-bar', 
            'mprogress-style', 
            'online-shopper-v2-css',
        //    'di-admin-bar', 
            'swiper-css',
            'flipclock-fixes',
            'flipclock-styles',
            'flexslider_css',
            'di-srp-layout-stylesheet',
        //    'owl-styles',
        //    'bootstrap-css', 
            'fancybox-css', 
        //    'sidr-css',
            'a2a-remote-css',
            'tablepress-responsive-tables',
            'tablepress-default',
        //    'yoast-seo-adminbar',
            'inventory-css',
        //    'vessel-style-css-home',
        //    'vessel-base-child-style-home',
        //    'vessel-shared-stylesheets',
        //    'wpmu-animate-min-css',
        //    'mercedesfont-ca', 
        ];

        $id = $this->_fj->get_di_id();

        if( $id == $this->_fj->dealerIdList['fjmaui'] ){
            if (is_front_page()) {

                //foreach( $scriptList as $script ){
                    //wp_deregister_script($script);
                    //wp_dequeue_script($script);                    
                //}

                //foreach( $styleList as $style ){
                    //wp_deregister_script($style);
                    //wp_dequeue_script($style);                    
                //}

            }
        }
    }

    public function add_3rd_party_class($classes){
        $classes[] = "di-third-party-render";
        return $classes;
    }

    public function lvrp_custom_sorts($sorts){
        $make = 'Mercedes-Benz';
        $sorts['custom_fj_commercial_vans_last'] = [
            'name' => 'Commercial and Vans last',
            'userSortDisplay' => 'By Type',
            'rankings' => [
                [
                    // This will create a new key in algolia to use as a ranking
                    'key' => 'custom_model',
                    // The default score assigned to `custom_type` in the event we cant find a mapping.
                    // If for some reason a vehicle didn't have a type of New, Certified Used or Used -
                    // it would be sent behind the Used Vehicles
                    'defaultScore' => 0,
                    'direction' => 'asc',
                    'mappings' => [

                        [
                            'rules' => [
                            [
                                'key' => 'model',
                                'value' => 'Metris Cargo Van'
                            ]            
                            ],
                            // If the type key on the vehicle object is `New` this will get a score of 0.
                            // Its 0 because we the direction is ascending and we new to show up first.
                            'score' => 1
                        ],
                        [
                            'rules' => [
                            [
                                'key' => 'model',
                                'value' => 'Metris Passenger Van'
                            ]            
                            ],
                            // If the type key on the vehicle object is Certified Used this will get a score of 1.
                            // Its 0 because we the direction is ascending and we want Certified Used showing after New.
                            'score' => 2
                        ],
                        [
                            'rules' => [
                            [
                                'key' => 'model',
                                'value' => 'Sprinter Cargo Van'
                            ]            
                            ],
                            // If the type key on the vehicle object is Certified Used this will get a score of 1.
                            // Its 0 because we the direction is ascending and we want Certified Used showing after New.
                            'score' => 3
                        ],
                        [
                            'rules' => [
                            [
                                'key' => 'model',
                                'value' => 'Sprinter Crew Van'
                            ]            
                            ],
                            // If the type key on the vehicle object is Certified Used this will get a score of 1.
                            // Its 0 because we the direction is ascending and we want Certified Used showing after New.
                            'score' => 4
                        ],
                        [
                            'rules' => [
                            [
                                'key' => 'model',
                                'value' => 'Sprinter Passenger Van'
                            ]            
                            ],
                            // If the type key on the vehicle object is Certified Used this will get a score of 1.
                            // Its 0 because we the direction is ascending and we want Certified Used showing after New.
                            'score' => 5
                        ],
                        [
                            'rules' => [
                            [
                                'key' => 'model',
                                'value' => 'Sprinter Cab Chassis'
                            ]            
                            ],
                            // If the type key on the vehicle object is Certified Used this will get a score of 1.
                            // Its 0 because we the direction is ascending and we want Certified Used showing after New.
                            'score' => 6
                        ],
                    ] 
                ],
                [
                    // This will create a new key in algolia to use as a ranking
                    'key' => 'custom_make',
                    // The default score assigned to `custom_type` in the event we cant find a mapping.
                    // If for some reason a vehicle didn't have a type of New, Certified Used or Used -
                    // it would be sent behind the Used Vehicles
                    'defaultScore' => 2,
                    'direction' => 'asc',
                    'mappings' => [
                        [
                            'rules' => [
                            [
                                'key' => 'make',
                                'value' => $make
                            ]            
                            ],
                            // If the type key on the vehicle object is `New` this will get a score of 0.
                            // Its 0 because we the direction is ascending and we new to show up first.
                            'score' => 1
                        ]
                    ]                        
                ],
                [
                    'key' => 'our_price', // The key on the vehicle object to sort by
                    'direction' => 'asc' // Whether to sort in asc or desc order
                ]
            ]
        ];

        /**
         * SC 00938531 -  request #2 Custom sort by image count
         */

        $sorts['custom_sort_by_image_count_with_price'] = [
            'name'            => 'Sort by highest image count to lowest and price low to high',
            'userSortDisplay' => 'Sort by highest image count to lowest and price low to high',
            'rankings'        => [
                [
                    'key'       => 'image_count',
                    'direction' => 'desc'
                ],
                [
                    'key'       => 'our_price',
                    'direction' => 'asc'
                ]
            ]
        ];

        $sorts['custom_sort_by_image_count'] = [
            'name'            => 'Sort by highest image count to lowest',
            'userSortDisplay' => 'Sort by highest image count to lowest',
            'rankings'        => [
                [
                    'key'       => 'image_count',
                    'direction' => 'desc'
                ]
            ]
        ];
            
        return $sorts;
    }

    public function cc_mime_types($mimes){
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }

    function new_thumbnail_img() {
        if (function_exists('add_theme_support')) {
            add_image_size('post-thumbnails', 950, 500, true);
        }
    }


function is_active($slug){
    $active = str_replace(array("/", "category"), "", $_SERVER['REQUEST_URI']);
    if ($slug == $active) {
        return "active";
    }
    return '';
}

function blog_archive_before_main_loop(){
    if(get_field('use_custom_blog_template', 'option')){
        // featured categories as links, used on desktop and tablet
        echo '<div class="featuredCats hidden-xs">';
        echo '<div class="featuredCats__wrapper">';
        echo '<a trid="8ef698f6d629413fb86b7d" trc class="featuredCategory ' . $this->is_active('blog') . '" href="/blog/" alt="View all posts">Home</a>';

        // sets up arguments for the get_categories. featured_category is an ACF true/false in each category
        $args=  array(
            'meta_key' => 'featured_category',
            'meta_value' => true
        );
        //gets a list of categories where featured_category is true
        $categories = get_categories( $args );
        foreach( $categories as $category ) {
            // assembles an a tag form the the category info returned by get_categories

            $category_link = sprintf( 
                '<a trid="36397cab92464ef1990ad5" trc class="featuredCategory %2$s" href="%1$s">%3$s</a>',
                esc_url( get_category_link( $category->term_id ) ),
                esc_attr( $this->is_active($category->slug)),
                esc_html( $category->name )
            );
             

            echo $category_link;
        } 
        echo "</div></div>";

        // featured categories as a dropdown, used on mobile only
        echo '<div class="featuredCats visible-xs">';
        echo '<div class="featuredCats__wrapper">';
        echo '<select class="featuredCats__select" name="categories" onChange="document.location.href = this.value">';
        echo '<option>--Select--</option>';
        echo '<option class="featuredCategory" value="/blog/">Home</option>';

        foreach( $categories as $category ) {
            $category_option = sprintf( 
                '<option class="featuredCategory" value="%1$s" >%2$s</option>',
                esc_url( get_category_link( $category->term_id ) ),
                esc_html( $category->name )
            );
            echo $category_option;
        } 

        echo "</select></div></div>";

        // greates an own carousel of featured blog posts
        echo '<div class="featured-carousel owl-carousel owl-theme">';
        // pulls the all blog posts with the featured blog post acf set to true, 10 per page
        $cc_args = array(
            'posts_per_page'   => 10,
            'post_type'        => 'post',
            'meta_key'         => 'featured_blog_post',
            'meta_value'       => true
        );
        $posts = get_posts( $cc_args );
        foreach ($posts as $post){
            $image = get_field("carousel_image", $post->ID);
            //var_dump($image);
            $title_link = sprintf( 
                '<a trid="2a15f2c7aef34053a9dab6" trc class="" href="%1$s">%2$s</a>',
                esc_url( get_permalink( $post->ID ) ),
                esc_attr( sprintf( __( '%s', 'commontheme' ), $post->post_title ) )
            );

            $CTA_link = sprintf( 
                '<a trid="f3b6fc23005c476eb7f7c2" trc class="button cta-button" href="%1$s" >Read More</a>',
                esc_url( get_permalink( $post->ID ) )
            );


            // assembleing the carousel item using the cta link and image url above.
            $content = '<div class="featuredContent" >';
            $content = $content . "<h3 class='title'>";
            $content = $content . $title_link;
            $content = $content . "</h3>";
            $content = $content . "<span class='cta'>";
            $content = $content . $CTA_link;
            $content = $content . "</span>";
            $content = $content . '</div>';

            $image_tag = '<div class="item featuredImage" style="background-image:url(' . $image['url'] . ');" > ' . $content . '</div>';

            // echos out the carousel item, a div with an image background, the title and a read more CTA inside
            echo $image_tag;
        }
        echo "</div>";
        }
    }

    public function disable_visual_editor($user){
        return false;
    }

    public function homepage_search_widget($atts){
        extract(
            shortcode_atts(
                array(
                    'top_text' => '',
                ),
                $atts
            )
        );
        ob_start();
        get_frontend_component('homepage/homepage-search-widget','',
            array(
                'top_text'=>$top_text,
            )
        );
        $output = ob_get_clean();
        return $output;
    }

    public function change_form_tracking_types($formMappings) {
 
        if( isset($formMappings['14']) ){
            $formMappings['14']['form_type'] = 3;
        }
        if( isset($formMappings['15']) ){
            $formMappings['15']['form_type'] = 3;
        }
    
        return $formMappings;
    }

    public function add_custom_conversations_styles() {
        if(get_field('disable_proactive_message', 'option')){
            wp_register_style('custom-conversations', plugins_url() . '/vessel/content/shared/styles/vdp/custom-conversations.css');
            wp_enqueue_style('custom-conversations');
        }
    }


    /**
    * Create list of synonyms. 
    * Takes supplied CSV file and removes spaces and dashes to make the models searchable no matter what
    * Ex. AMG E 300 4MATIC, AMG E300 4MATIC, E300 4MATIC, AMG E300, E 300 4MATIC, AMG E 300, E300, E 300
    */
    public function generate_synonyms(){
        try{
            // declaring variables
            $syns = array();
            $processed = array();
            $csv = array();
            $trims = explode(',', get_field('trim_list', 'option'));
            // gets the url of the model list file
            $file_url = \DealerInspire\Vessel\Vessel::get_plugin_dir_path().'content/shared/models.csv';
            // loads the actual file
            $file = file($file_url);
            if(isset($file_url)){

                // itterates through the file and loads the array $csv with data
                foreach ($file as &$line) {
                    $csv[] = str_getcsv($line);
                }
                
                // processes the raw data into a one dimentional array
                foreach($csv as &$subarray){
                    foreach($subarray as &$item){
                        if(isset($item) && !empty($item)){
                            $processed[] = $item;
                        }
                    }
                }

                // clears any entries that are duplicated, because there were some that were :(
                $processed = array_unique($processed);
                foreach($processed as &$item){
                    // sets up the first two items in the array
                    $nospacesItem =  str_replace(' ', '', $item);
                    $synonymArray = array($item, $nospacesItem);

                    foreach($trims as &$t) {
                        // iterates through all trims indicated in the trim_list ACF field
                        if (strpos($nospacesItem, $t) !== false) {
                            $synonymArray[] = str_replace($t, '', $nospacesItem);
                            $synonymArray[] = ltrim(str_replace($t, '', $item));
                            // if the first bit is part of a model number, this catches it and removes the space in the model number
                            $itemArray = explode(" ",$item);
                            if ($t == $itemArray[0]) {
                                $synonymArray[] = substr_replace($item, '', strpos($item, " ", strpos($item, " ") + 1), 1);
                            }
                            if ($t !== $itemArray[0]) {
                                $val=$synonymArray[]=array_pop($synonymArray);
                                $synonymArray[] = substr_replace($val, '', strpos($val, " "), 1);
                                $synonymArray[] = substr_replace($item, '', strpos($item, " "), 1);
                            }
                            
                        }
                    }

                    // adds a synonym without dashes for each synonym with a dash, removes all double spaces
                    foreach ($synonymArray as &$entry){
                        $entry = preg_replace('/\s+/',' ', $entry);
                        $entry = trim($entry);
                        if (strpos($entry, "-") !== false) $synonymArray[] = str_replace('-', '', $entry);
                    }
                    // makes sure array items are unique and adds current synonyms to 2d array
                    $synonymArray = array_unique($synonymArray);

                    $syns[] = $synonymArray;
                }
            }
            return $syns;
            } catch (Exception $e) {
                error_log('Caught exception: ',  $e->getMessage(), "\n");
                return false;
            }
        }
    

    public function vessel_inventory_synonyms($syns) {
        // checks if DI_Transient is a thing, and if it is, it loads the synonyms up into the DB
        if (class_exists("\\di_transient") && method_exists('\\di_transient', 'remember')) {
            $synonymList = \di_transient::get_instance()->remember('synonym-data', function () {
                return $this->generate_synonyms();
            }, 600);
        }

        if(is_array($syns)){
            $synonymList = array_merge($synonymList, $syns);
        }

        // test code. limiting the number of synonyms
        foreach($synonymList as &$synonymArray){
            $synonymArray = array_slice($synonymArray, 0, 50);
        }

        return $synonymList;
    }

    private $vrp_model_ctas = array(
        '/mercedes-benz/g-class/2022-suv/inventory/'=>'fj-g-class-page',
        '/mercedes-benz/gla/2022-suv/inventory/'=>'fj-gla-page',
        '/mercedes-benz/glb/2022-suv/inventory/'=>'fj-glb-page',
        '/mercedes-benz/glc/2022-coupe/inventory/'=>'fj-glc-coupe-page',
        '/mercedes-benz/glc/2022-suv/inventory/'=>'fj-glc-suv-page',
        '/mercedes-amg/gle-coupe/inventory/ '=>'fj-gle-coupe-page',
        '/mercedes-benz/gle/2022-suv/inventory/'=>'fj-gle-suv-page',
        '/mercedes-benz/gls/2022-suv/inventory/'=>'fj-gls-suv-page',
        '/mercedes-benz/a-class/2022-sedan/inventory/'=>'fj-a-class-page',
        '/mercedes-benz/c-class/2022-sedan/inventory/'=>'fj-c-class-page',
        '/mercedes-benz/e-class/2022-sedan/inventory/'=>'fj-e-class-page',
        '/mercedes-benz/e-class/2022-wagon/inventory/'=>'fj-e-class-wagon-page',
        '/new-vehicles/mercedes-maybach/'=>'fj-maybach-page',
        '/mercedes-benz/s-class/2022-sedan/inventory/'=>'fj-s-class-page',
        '/mercedes-benz/amg-gt/2021-roadster/inventory/'=>'fj-gt-roadster-page',
        '/mercedes-benz/amg-gt/2022-4-door-coupe/inventory/'=>'fj-gt-coupe-page',
        '/mercedes-benz/c-class/2022-coupe/inventory/'=>'fj-c-class-coupe-page',
        '/mercedes-benz/cla/2022-coupe/inventory/'=>'fj-cla-coupe-page',
        '/mercedes-benz/cls/2022-coupe/inventory/'=>'fj-cls-coupe-page',
        '/mercedes-benz/e-class/2022-coupe/inventory/'=>'fj-e-class-coupe-page',
        '/mercedes-benz/sl-class/2022-roadster/inventory/'=>'fj-sl-class-page',
        '/mercedes-benz/c-class/2022-cabriolet/inventory/'=>'fj-c-class-cab-page',
        '/mercedes-benz/e-class/2022-cabriolet/inventory/'=>'fj-e-class-cab-page',
        '/mercedes-benz/glc/2023-suv/inventory/'=>'fj-glc-2023-page',
        '/mercedes-eq/2023-eqe/inventory/'=>'fj-eqe-page',
        '/mercedes-eq/2023-eqs-suv/inventory/'=>'fj-eqs-suv-page',
        '/mercedes-eq/2022-eqs/inventory/'=>'fj-eqs-page',
        '/mercedes-eq/2022-amg-eqs/inventory/'=>'fj-amg-eqs-page',
        '/mercedes-eq/2022-eqb/inventory/'=>'fj-eqb-page',
        '/mercedes-benz/gla/2023-suv/inventory/'=>'fj-gla-suv-page',
        '/mercedes-benz/cla/2023-coupe/inventory/'=>'fj-cla-2023-page',
        '/mercedes-benz/cls/2023-coupe/inventory/'=>'fj-cls-2023-page',
        '/mercedes-benz/e-class/2023-sedan/inventory/'=>'fj-e-class-2023-page',
        '/mercedes-eq/2023-eqb/inventory/'=>'fj-eqb-2023-page',
        '/mercedes-eq/2023-eqs/inventory/'=>'fj-eqs-2023-page',
        '/mercedes-eq/2023-amg-eqs/inventory/'=>'fj-2023-amg-eqs-page',
        '/mercedes-benz/glb/2023-suv/inventory/'=>'fj-glb-2023-page',
        '/mercedes-benz/s-class/2023-sedan/inventory/'=>'fj-s-class-2023-page',
        '/mercedes-benz/c-class/2023-sedan/inventory/'=>'fj-c-class-2023-page',
        '/mercedes-benz/c-class/2023-coupe/inventory/'=>'fj-c-class-coupe-2023-page',
        '/mercedes-eq/2023-amg-eqs/inventory/'=>'fj-amg-eqs-2023-page',
        '/mercedes-benz/gle/2023-suv/inventory/'=>'fj-gle-suv-2023-page',
        '/mercedes-amg/gle/2023-coupe/inventory/'=>'fj-amg-gle-2023-page',
        '/mercedes-amg/gle/2023-suv/inventory/'=>'fj-amg-gle-suv-2023-page',
        '/mercedes-benz/g-class/2023-suv/inventory/'=>'fj-g-class-2023-page',
        '/mercedes-benz/maybach/2023-sedan/inventory'=>'fj-maybach-2023-page',
        '/mercedes-amg/sl/2023-roadster/inventory/'=>'fj-sl-2023-page',
        '/mercedes-eq/2023-eqe-suv/inventory/'=>'fj-eqe-2023-page',
        '/mercedes-benz/gls/2023-suv/inventory/'=>'fj-gls-2023-page',
    );

    /*
        SF-01304156
        adding body class to specific VRPs to target styles
    */
    public function add_vrp_class($classes){
        foreach ($this->vrp_model_ctas as $pageURL => $class) {
            if( strpos($_SERVER['REQUEST_URI'], $pageURL) !== false ){
                $classes[] = $class;
            }
        }
        return $classes;
    }

    public function add_service_class($classes){
        if( strpos($_SERVER['REQUEST_URI'], 'service') !== false ){
            $classes[] = 'service-page';
        }
        return $classes;
    }

    public function google_translate(){
        get_shared_template('header/language-toggle');
    }

    /**
     * Cache control
     * Uses a version parameter approach to ensure fresh content while allowing caching
     */
    public function fj_cache_control() {
        // Only apply to front-end requests
        if (!is_admin()) {
            add_filter('script_loader_src', [$this, 'fj_add_version_parameter'], 99, 1);
            add_filter('style_loader_src', [$this, 'fj_add_version_parameter'], 99, 1);
            add_action('save_post', [$this, 'fj_update_site_modified_time']);
            add_action('wp_update_nav_menu', [$this, 'fj_update_site_modified_time']);
            add_action('customize_save_after', [$this, 'fj_update_site_modified_time']);
        }
    }

    public function add_fj_cache_control_hooks() {
        // Add the cache control hooks
        add_action('init', [$this, 'fj_cache_control']);
    }

    public function fj_update_site_modified_time() {
        update_option('fj_site_modified', time());
    }

    /**
     * Add a dynamic version parameter to CSS and JS files
     * This allows browsers to cache files but ensures they get fresh versions when updated
     */
    public function fj_add_version_parameter($src) {
        // Skip files that already have a version or external URLs
        if (strpos($src, 'ver=') !== false || strpos($src, home_url()) === false) {
            return $src;
        }

    $version = get_option('fj_site_modified', time());

    // Append version parameter
    $src = add_query_arg('ver', $version, $src);

    return $src;
    }
}