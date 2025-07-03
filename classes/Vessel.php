<?php

namespace DealerInspire\Vessel;

class Vessel {
    private $_option_group_prefix = 'dealerinspire-vessel-';
    private $_option_prefix = 'dealerinspire-vessel-';
    private $_settings_page_slug = 'dealerinspire-vessel-settings';
    private $_fj;

    public $useDealerThemeList = [
        '421'
    ];

    public function __construct(FJ $FJ){
        $this->_fj = $FJ;
    }

    public function vessel_template_exists($name) {
        $template = $this->get_plugin_path() .'/content/dealers/' . $this->_fj->get_di_slug() . '/' . $name;

        if(file_exists($template)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_plugin_path(){
        return dirname(__DIR__, 1) . '/';
    }

    public function get_vessel_template($template) {
        return $this->get_plugin_path() .'content/dealers/' . get_option('di_slug') . '/' . $template;
    }

    public function is_prod() {
        return (defined('ENVIRONMENT') && constant('ENVIRONMENT') === 'production') ? true : false;
    }

    public function register_settings(){
        foreach($this->_settings as $tab_key => $sections){
            foreach($sections as $section_key => $section){
                foreach($section['settings'] as $key => $setting){
                    register_setting($this->_option_group_prefix.$tab_key, $this->_option_prefix.$key, array_key_exists('sanitize_function', $setting)?array($this, $setting['sanitize_function']):null);
                }
            }
        }
    }

    public static function is_default_frontpage(){
        return ( in_array(get_option( 'page_on_front'), array(3,4,5)) )  ? true : false;
    }

    /**
     * ************ EVERYTHING BELOW HERE IS COPY/PASTE FROM STANDARD PLUGIN CODE **********
     * I don't like it but I don't see a good way around it yet
     *
     */

    /**
     * field_callback function.
     *
     * @access public
     * @param mixed $args
     * @return void
     */
    public function field_callback($args)
    {
        $params = array(
            'prefix' => $this->_option_prefix,
            'id' => $args['id'],
            'setting' => $args['setting'],
            'option_id' => array_key_exists('option_id', $args) ? $args['option_id'] : null
        );

        switch($args['setting']['type'])
        {
        case 'textarea': echo $this->scoped_read($this->get_plugin_path().'views/fields/textarea.php', $params);
        break;
        case 'checkbox': echo $this->scoped_read($this->get_plugin_path().'views/fields/checkbox.php', $params);
        break;
        case 'hours': echo $this->scoped_read($this->get_plugin_path().'views/fields/hours.php', $params);
        break;
        case 'select_livechat_tool':
        case 'select_livechat_override': echo $this->scoped_read($this->get_plugin_path().'views/fields/'.$args['setting']['type'].'.php', $params);
        break;
        default: echo $this->scoped_read($this->get_plugin_path().'views/fields/text.php', $params);
        break;
        }
    }

    /**
     * section_callback function.
     *
     * @access public
     * @param mixed $args
     * @return void
     */
    public function section_callback($args)
    {
        $section = $this->sections[$args['id']];
        if(array_key_exists('description', $section) && sizeof($section['description']) > 0)
        {
            echo "<p>".$section['description']."</p>";
        }
    }

    /**
     * scoped_read function.
     *
     * @access public
     * @param mixed $file
     * @param array $params (default: array())
     * @return void
     */
    public function scoped_read($file, $params = array())
    {
        if(file_exists($file))
        {
            extract($params);
            ob_start();
            include($file);
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
        else
        {
            throw new Exception("File $file does not exist.");
        }
    }

    // use this to create a variable like string to be used in various functions (replaces spaces, special characters with hyphens)
    public function permalize( $string ) {
        return sanitize_title_with_dashes( $string );
    }

    public function plugin_url() {
        return untrailingslashit( plugins_url( '/', __FILE__ ) );
    }


    public static function get_plugin_dir_path(){
        return dirname(__DIR__, 1) . '/';
    }

    public function add_settings_link(){
        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", array($this, 'plugin_settings_link') );
    }

    public function plugin_settings_link($links) {
        $settings_link = '<a trid="d17303fb950b4916ac1bfc" trc href="admin.php?page='.$this->_settings_page_slug.'">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function ShouldUseDealerThemeFiles($id)
    {
        return in_array($id, $this->useDealerThemeList) ? true : false;
    }

}
