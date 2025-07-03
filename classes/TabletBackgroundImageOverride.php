<?php

namespace DealerInspire\Vessel;

use \DICommonTheme\HomepageBackgroundImageOverrides;

class TabletBackgroundImageOverride extends HomepageBackgroundImageOverrides {

    private $_tablet_selector;

    public function register_tablet_hooks() {
        $this->set_tablet_selector('#videobanner');
        add_action('wp_enqueue_scripts', array($this, 'override_tablet_images'));

    }

    private function set_tablet_selector($selector) {
        $this->_tablet_selector = $selector;
        return $this;
    }

    public function override_tablet_images() {

        $css = '';

        $tablet_image = get_field('homepage_tablet_image', get_option( 'page_on_front' ));

        // Start to capture css output
        ob_start();

        // Above the fold tablet image
        if ( isset($tablet_image) && !empty($tablet_image) ):

            echo '@media (max-width: 1024px){' . $this->_tablet_selector . '{ background-image: url( ' . $tablet_image . ' ) !important; }}';
        endif;

        // Save the CSS to a variable for file generation
        $css = trim(ob_get_clean());

        // Sudo minifying
        $css = str_replace(' ', '', $css);



        if ( isset($css) && !empty($css) ):

            // Add comments so other people know where these styles are coming from
            $css = '<!-- BACKGROUND OVERRIDES --> <style>' . $css . '</style> <!-- END BACKGROUND OVERRIDE CSS -->';

            // Output CSS on to page
            echo $css;

        endif;
    }

    public function register_acf_fields() {

        // TODO - Implement below the fold background adjustments

        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array (
                'key' => 'group_5935a8d87bac0',
                'title' => 'Homepage Background Image Overrides',
                'fields' => array (
                    array (
                        'key' => 'field_5935ac2f6f7fc',
                        'label' => 'Main Image',
                        'name' => '',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),
                    array (
                        'key' => 'field_5935ac426f7fd',
                        'label' => 'Desktop Image',
                        'name' => 'homepage_desktop_image',
                        'type' => 'image',
                        'instructions' => 'The desktop image must be exactly 1800 pixels in width. This is the main homepage background image that will display at the top of the page. ',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => 100,
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => 1800,
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 1800,
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),array (
                        'key' => 'field_5988ac426f7fd',
                        'label' => 'Tablet Image',
                        'name' => 'homepage_tablet_image',
                        'type' => 'image',
                        'instructions' => 'The tablet image must be exactly 1024 pixels in width. This is the main homepage background image that will display at the top of the page.',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => 100,
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => 1024,
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 1024,
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    /*array (
                        'key' => 'field_5935b5f10fde0',
                        'label' => 'Mobile Image Option',
                        'name' => 'above_fold_same_image_on_mobile',
                        'type' => 'true_false',
                        'instructions' => 'Checking this box will auto resize the desktop image and display the same image on mobile.',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => 100,
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => 'Use desktop image on mobile?',
                        'default_value' => 0,
                    ),*/
                    array (
                        'key' => 'field_5935aca66f7fe',
                        'label' => 'Mobile Image',
                        'name' => 'homepage_mobile_image',
                        'type' => 'image',
                        'instructions' => 'The mobile image must be exactly 768 pixels in width. This is the main homepage background image that will display at the top of the page in the mobile view. ',
                        'required' => 0,
                        'conditional_logic' => 0,/*array (
                            array (
                                array (
                                    'field' => 'field_5935b5f10fde0',
                                    'operator' => '!=',
                                    'value' => '1',
                                ),
                            ),
                        ),*/
                        'wrapper' => array (
                            'width' => 100,
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => 768,
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 768,
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    /*array (
                        'key' => 'field_5935aceb6f7ff',
                        'label' => 'Below Fold',
                        'name' => '',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'left',
                        'endpoint' => 0,
                    ),
                    array (
                        'key' => 'field_5935acfb6f800',
                        'label' => 'Below Fold Images',
                        'name' => 'below_fold_images',
                        'type' => 'repeater',
                        'instructions' => 'Allows the replacement of content background images for below the fold sections. Typically sections such as this include the SEO, About Us, CTA, or Model Row.',
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
                        'layout' => 'block',
                        'button_label' => 'Replace An Image',
                        'sub_fields' => array (
                            array (
                                'key' => 'field_5935ad6a6f802',
                                'label' => 'Selector Type',
                                'name' => 'css_selector_type',
                                'type' => 'select',
                                'instructions' => 'Choose whether to select the element the background image will be replacing by id, class name
                                 or full CSS selector (Advanced Targeting). ',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array (
                                    'width' => 50,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array (
                                    'null' => 'Selector',
                                    'class' => 'Class',
                                    'id' => 'ID',
                                    'css' => 'Advanced Targeting'
                                ),
                                'default_value' => array (
                                ),
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'ajax' => 0,
                                'placeholder' => '',
                                'disabled' => 0,
                                'readonly' => 0,
                            ),
                            array (
                                'key' => 'field_5935adc16f815',
                                'label' => 'Advanced Selector',
                                'name' => 'css_advanced',
                                'type' => 'text',
                                'instructions' => 'For advanced users only. Allows you to target an element the same way you would in a CSS file.
                                 Example: #videobanner .modfull',
                                'required' => 1,
                                'conditional_logic' => array (
                                    array (
                                        array (
                                            'field' => 'field_5935ad6a6f802',
                                            'operator' => '==',
                                            'value' => 'css',
                                        ),
                                    ),
                                ),
                                'wrapper' => array (
                                    'width' => 50,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => 'Enter selector',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0,
                            ),
                            array (
                                'key' => 'field_5935adc16f803',
                                'label' => 'Class Name',
                                'name' => 'css_class_name',
                                'type' => 'text',
                                'instructions' => 'The class name of the element the background image will be replacing.
                                 Do not include the preceding \'.\' in the class name.',
                                'required' => 1,
                                'conditional_logic' => array (
                                    array (
                                        array (
                                            'field' => 'field_5935ad6a6f802',
                                            'operator' => '==',
                                            'value' => 'class',
                                        ),
                                    ),
                                ),
                                'wrapper' => array (
                                    'width' => 50,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => 'Enter class name',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0,
                            ),
                            array (
                                'key' => 'field_5935ae016f804',
                                'label' => 'ID',
                                'name' => 'css_id',
                                'type' => 'text',
                                'instructions' => 'The id of the element the background image will be replacing.
                                 Do not include the preceding \'#\' in the id.',
                                'required' => 1,
                                'conditional_logic' => array (
                                    array (
                                        array (
                                            'field' => 'field_5935ad6a6f802',
                                            'operator' => '==',
                                            'value' => 'id',
                                        ),
                                    ),
                                ),
                                'wrapper' => array (
                                    'width' => 50,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => 'Enter ID',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0,
                            ),
                            array (
                                'key' => 'field_5935b7bb0eb19',
                                'label' => 'Choose Selector Type',
                                'name' => '',
                                'type' => 'message',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => array (
                                    array (
                                        array (
                                            'field' => 'field_5935ad6a6f802',
                                            'operator' => '==',
                                            'value' => 'null',
                                        ),
                                    ),
                                ),
                                'wrapper' => array (
                                    'width' => 50,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => 'Once you have selected a selector type you will be able to input the id or class name here.',
                                'new_lines' => 'wpautop',
                                'esc_html' => 0,
                            ),
                            array (
                                'key' => 'field_5935b81d0eb1a',
                                'label' => 'Desktop Image',
                                'name' => 'below_fold_desktop_image',
                                'type' => 'image',
                                'instructions' => 'The desktop image must be exactly 1800 pixels in width. This is the main homepage background image that will display at the top of the page. ',
                                'required' => '',
                                'conditional_logic' => '',
                                'wrapper' => array (
                                    'width' => 100,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'url',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                                'min_width' => 1800,
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => 1800,
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ),
                            array (
                                'key' => 'field_5935b8710eb1b',
                                'label' => 'Mobile Image Option',
                                'name' => 'below_fold_same_image_on_mobile',
                                'type' => 'true_false',
                                'instructions' => 'Checking this box will auto resize the desktop image and display the same image on mobile.',
                                'required' => '',
                                'conditional_logic' => '',
                                'wrapper' => array (
                                    'width' => 100,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => 'Use desktop image on mobile?',
                                'default_value' => 0,
                            ),
                            array (
                                'key' => 'field_5935b8e80eb1c',
                                'label' => 'Mobile Image',
                                'name' => 'below_fold_mobile_image',
                                'type' => 'image',
                                'instructions' => 'The mobile image must be exactly 768 pixels in width. This is the main homepage background image that will display at the top of the page in the mobile view.',
                                'required' => '',
                                'conditional_logic' => array (
                                    array (
                                        array (
                                            'field' => 'field_5935b8710eb1b',
                                            'operator' => '!=',
                                            'value' => '1',
                                        ),
                                    ),
                                ),
                                'wrapper' => array (
                                    'width' => 100,
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'url',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                                'min_width' => 768,
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => 768,
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => '',
                            ),
                        ),
                    ),*/
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'page',
                            'operator' => '==',
                            'value' => get_option( 'page_on_front' ),
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

        endif;
    }
}