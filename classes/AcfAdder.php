<?php
namespace DealerInspire\Vessel;

class AcfAdder
{
  private static $instance;
  private $_vessel;

  public function __construct() {}

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new AcfAdder();
    }
    return self::$instance;
  }

  public function addField($fieldGroup)
  {
    if ($fieldGroup == 'homepage_overlay_below_ctas' && Vessel::is_default_frontpage()) {
      add_action('acf/init', [$this, 'register_acf_homepage_overlay_below_ctas']);
    }
    if ($fieldGroup == 'overlay_buttons' && Vessel::is_default_frontpage()) {
      add_action('acf/init', [$this, 'register_acf_overlay_buttons']);
    }
    if ($fieldGroup == 'dipc_lightning_check') {
      add_action('acf/init', [$this, 'register_acf_dipc_lightning']);
    }
    if ($fieldGroup == 'homepage_buttons' && Vessel::is_default_frontpage()) {
      add_action('acf/init', [$this, 'register_homepage_button_acfs']);
    }
    if ($fieldGroup == 'header_nav_image') {
      add_action('acf/init', [$this, 'register_header_nav_image_acfs']);
    }
    if ($fieldGroup == 'blog_toggle') {
      add_action('acf/init', [$this, 'register_acf_blog_toggle']);
    }
    if ($fieldGroup == 'blog_template') {
      add_action('acf/init', [$this, 'register_acf_custom_blog_template']);
    }
    if ($fieldGroup == 'vdp_only_proactive_message') {
      add_action('acf/init', [$this, 'register_acf_custom_proactive_message']);
    }
  }

  function register_acf_custom_proactive_message()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_62e0408a47484',
        'title' => 'Proactive Message Settings',
        'fields' => [
          [
            'key' => 'field_62e040d7e72b5',
            'label' => 'Disable Proactive Message',
            'name' => 'disable_proactive_message',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'message' => 'Check this box to disable Proactive Messaging on all pages except the VDP.',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
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

  function register_header_nav_image_acfs()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_5ec71b7b832e5',
        'title' => 'Header Nav Image',
        'fields' => [
          [
            'key' => 'field_5ec71bbc770b8',
            'label' => 'Header Nav Image',
            'name' => '',
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
            'key' => 'field_5ec71bcb770c1',
            'label' => 'Main Site Logo',
            'name' => 'vessel_main_logo',
            'type' => 'image',
            'instructions' => 'use this to override the main site logo in the header',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'return_format' => 'array',
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
            'key' => 'field_5ec71bcb770b9',
            'label' => 'Header Nav Image',
            'name' => 'header_nav_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'return_format' => 'array',
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
            'key' => 'field_5ec71bd8770ba',
            'label' => 'Header Nav Image Link',
            'name' => 'header_nav_image_link',
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

  function register_homepage_button_acfs()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_5d97b2ffe00ac',
        'title' => 'Homepage Buttons',
        'fields' => [
          [
            'key' => 'field_5d97b307e51b4',
            'label' => 'First Button',
            'name' => '',
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
            'key' => 'field_5d97b318e51b5',
            'label' => 'Button Text',
            'name' => 'button_text_one',
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
          ],
          [
            'key' => 'field_5d97b4208efd1',
            'label' => 'Second Button',
            'name' => '',
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
            'key' => 'field_5d97b42b8efd2',
            'label' => 'Button Text',
            'name' => 'button_text_two',
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
          ],
          [
            'key' => 'field_5d97b4408efd3',
            'label' => 'Button Link',
            'name' => 'button_link_two',
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
          ],
          [
            'key' => 'field_5d97b6f9e4343',
            'label' => 'Third Button',
            'name' => '',
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
            'key' => 'field_5d97b6ea0ed17',
            'label' => 'Button Text',
            'name' => 'button_text_three',
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
          ],
          [
            'key' => 'field_5d97b6e20ed16',
            'label' => 'Button Link',
            'name' => 'button_link_three',
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
          ],
          [
            'key' => 'field_5d97be4aed18c',
            'label' => 'Fourth Button',
            'name' => '',
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
            'key' => 'field_5d97be54ed18d',
            'label' => 'Button Text',
            'name' => 'button_text_four',
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
          ],
          [
            'key' => 'field_5d97be66ed18e',
            'label' => 'Button Link',
            'name' => 'button_link_four',
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
          ],
        ],
        'location' => [
          [
            [
              'param' => 'page_type',
              'operator' => '==',
              'value' => 'front_page',
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

  function register_acf_homepage_overlay_below_ctas()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_5643995f57aa9',
        'title' => 'Below CTA Buttons Content',
        'fields' => [
          [
            'key' => 'field_5c708759e5f00',
            'label' => 'Below Cta Buttons',
            'name' => 'homepage_overlay_below_ctas',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
            'delay' => 0,
          ],
        ],
        'location' => [
          [
            [
              'param' => 'page',
              'operator' => '==',
              'value' => '3',
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
  function register_acf_overlay_buttons()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_5d5b086452e86',
        'title' => 'Overlay Buttons',
        'fields' => [
          [
            'key' => 'field_5d5b095770b2b',
            'label' => 'Button Overlay Heading',
            'name' => 'button_overlay_heading',
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
          ],
          [
            'key' => 'field_5d5b097570b2c',
            'label' => 'Button Overlay Image',
            'name' => 'button_overlay_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
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
          ],
          [
            'key' => 'field_5d5b098870b2d',
            'label' => 'Overlay Buttons',
            'name' => 'overlay_buttons',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'collapsed' => '',
            'min' => 0,
            'max' => 3,
            'layout' => 'block',
            'button_label' => 'Add Button',
            'sub_fields' => [
              [
                'key' => 'field_5d5b09b870b2e',
                'label' => 'Button Overlay Text',
                'name' => 'button_overlay_text',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '50',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
              ],
              [
                'key' => 'field_5d5b09ca70b2f',
                'label' => 'Button Overlay Link',
                'name' => 'button_overlay_link',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                  'width' => '50',
                  'class' => '',
                  'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
              ],
            ],
          ],
        ],
        'location' => [
          [
            [
              'param' => 'page_type',
              'operator' => '==',
              'value' => 'front_page',
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
  function register_acf_dipc_lightning()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_5e4f114f58c77',
        'title' => 'DIPC Lightning',
        'fields' => [
          [
            'key' => 'field_5e4f116c892a9',
            'label' => 'Uses Lightning Shortcode',
            'name' => '',
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
            'key' => 'field_5e4f117f892aa',
            'label' => 'Is Using Lightning Shortcode',
            'name' => 'is_using_lightning_shortcode',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'page_template',
              'operator' => '==',
              'value' => 'page-di-page-composer.php',
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

  function register_acf_blog_toggle()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_6154c3c6831b9',
        'title' => 'Blog Template',
        'fields' => [
          [
            'key' => 'field_6154c3dc764c6',
            'label' => 'Use Custom Blog Template',
            'name' => 'use_custom_blog_template',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
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

  function register_acf_custom_blog_template()
  {
    if (function_exists('acf_add_local_field_group')):
      acf_add_local_field_group([
        'key' => 'group_61269c12b7034',
        'title' => 'Featured Blog Post',
        'fields' => [
          [
            'key' => 'field_61269f0a0961d',
            'label' => 'Featured Blog Post',
            'name' => 'featured_blog_post',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ],
          [
            'key' => 'field_6140ba2d4c546',
            'label' => 'Carousel Image',
            'name' => 'carousel_image',
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'return_format' => 'array',
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
        ],
        'location' => [
          [
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'post',
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
        'key' => 'group_61269afdc2d78',
        'title' => 'Featured Category',
        'fields' => [
          [
            'key' => 'field_61269e3e9f495',
            'label' => 'Featured Category',
            'name' => 'featured_category',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
              'width' => '',
              'class' => '',
              'id' => '',
            ],
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'taxonomy',
              'operator' => '==',
              'value' => 'category',
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
        'modified' => 1629920223,
      ]);

      acf_add_local_field_group([
        'key' => 'group_613f7aadaf87c',
        'title' => 'Title Section',
        'fields' => [
          [
            'key' => 'field_613f7ac056b32',
            'label' => 'Title Section',
            'name' => '',
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
            'key' => 'field_613f7acf56b33',
            'label' => 'Main Title',
            'name' => 'main_title',
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
          ],
          [
            'key' => 'field_613f7ae656b34',
            'label' => 'Subtitle',
            'name' => 'subtitle',
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
          ],
          [
            'key' => 'field_613f7af056b35',
            'label' => 'Custom Page CSS',
            'name' => 'custom_page_css',
            'type' => 'acf_code_field',
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
            'mode' => 'htmlmixed',
            'theme' => 'monokai',
          ],
        ],
        'location' => [
          [
            [
              'param' => 'page_type',
              'operator' => '==',
              'value' => 'posts_page',
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
        'modified' => 1631550500,
      ]);
    endif;
  }
}
