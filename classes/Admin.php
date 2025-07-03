<?php

namespace DealerInspire\Vessel;

class Admin {

    private $_fj;
    private $_vessel;

    public function __construct(FJ $FJ, Vessel $vessel)
    {
        $this->_fj = $FJ;
        $this->_vessel = $vessel;
    }

    public function add_admin_page_hooks() {
        add_action('admin_menu', array($this,'admin_menu'), 11);
        add_action('admin_bar_menu', array($this, 'add_jump_bar'), 100, 1);
    }

    public function admin_menu() {
        add_submenu_page(
            \DealerInspire::$settings_page_slug,
            'Vessel Settings',
            'Vessel',
            'manage_options',
            'dealerinspire-vessel-settings',
            array($this, 'settings')
        );
    }

    public function settings() {
        require_once($this->_vessel->get_plugin_path().'views/admin/options.php');
    }

    public function is_true($option) {
        $result = get_option($option);
        return ($result === 'true') ? true : false;
    }

    public function add_jump_bar($wp_admin_bar) {

            $wp_admin_bar->add_node([
                'id'     => 'dealer_group',
                'title'    =>    'Jump to Site'
            ]);

            $sites = [
                'FJ Auto Group' => 'https://www.fjautogroup.com',
                'Big Island Honda- Hilo/Kona' => 'https://www.bigislandhonda.com',
                'FJ Imports' => 'https://www.fjimports.com',
                'Mercedes-Benz Newport' => 'https://www.fjmercedes.com',
                'Mercedes-Benz Chicago' => 'https://www.mercedesbenzchicago.com',
                'Mercedes-Benz Honolulu' => 'https://www.mercedesbenzofhonolulu.com',
                'Mercedes-Benz Henderson' => 'https://www.mbofhenderson.com',
                'Mercedes-Benz Maui' => 'https://www.mbofmaui.com',
                'Mercedes-Benz Ontario' => 'https://www.mbontario.com',
                'Mercedes-Benz Temecula' => 'https://www.mbtemecula.com',
                'FJ Motorcars Fremont' => 'https://www.mboffremont.com',
                'Porsche of Hawaii' => 'https://www.porscheofhawaii.com',
                'FJ Socal Regional' => 'https://www.fletcherjones.com',
                'Porsche of Fremont' => 'https://www.porscheoffremont.com',
            ];

            foreach($sites as $name => $url) {
                $wp_admin_bar->add_node([
                    'title' => $name,
                    'id' => 'dealer_group_'.$name,
                    'href' => $url,
                    'parent' => 'dealer_group',
                    'meta' => [
                        'target' => 'blank'
                    ]
                ]);
            }
    }

}