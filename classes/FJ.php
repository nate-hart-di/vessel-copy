<?php
namespace DealerInspire\Vessel;

class FJ {

    private static $instance;

    private $_autogravity_dealers;
    private $_di_slug;
    private $_fj;
    private $_di_id;
    private $_ag_id;

    public $dealerIdList =[
        'fjimports'=> 616,
        'fjmercedes'=>435,
        'fjmaui'=>1434,
        'fjhonolulu'=>777,
        'temecula'=>570, 
        'fjontario'=>571,
        'fjfremont'=>416, 
        'fjhenderson'=>615,
        'fjchicago'=>535
    ];

    protected function __construct()
    {
        $this->set_di_slug();
        $this->set_fj_array();
        $this->set_autogravity_dealers();
        $this->set_ag_id();
        $this->set_di_id();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new FJ();
        }
        return self::$instance;
    }

    //Getters and setters
    public function get_fj_region()
    {
        $di_id = $this->_di_id;
        return $this->fj[$di_id]['region'];
    }

    public function get_ag_id()
    {
      return $this->_ag_id;
    }

    public function set_ag_id() {
        $di_id = \get_option('di_id');
        if( !empty( $this->_fj[$di_id] ) )
        $this->_ag_id = $this->_fj[$di_id]['ag_id'];
    }

    public function get_di_slug() {
        return $this->_di_slug;
    }

    public function set_di_slug() {
        $this->_di_slug = \get_option('di_slug');
    }

    public function set_fj_array() {
        $this->_fj = array(
            654 => array (
                'name' => 'Fletcher Jones SoCal Portal',
                'ag_id' => null,
                'region' => 'socal',
                'feature_button_default' => "/why-fletcher-jones/"
            ),
            435 => array(
                'name' => 'Fletcher Jones Motorcars',
                'ag_id' => 29633,
                'region' => 'socal',
                'feature_button_default' => ""
            ),
            571 => array(
                'name' => 'Mercedes-Benz Ontario',
                'ag_id' => 29915,
                'region' => 'socal',
                'feature_button_default' => ""
            ),
            570 => array(
                'name' => 'Mercedes-Benz Temecula',
                'ag_id' => 29937,
                'region' => 'socal',
                'feature_button_default' => ""
            ),
            1499 => array(
                'name' => 'Audi Beverly Hills',
                'ag_id' => null,
                'region' => 'socal',
                'feature_button_default' => ""
            ),
            416 => array(
                'name' => 'Fletcher Jones Motorcars of Fremont',
                'ag_id' => 29837,
                'region' => 'nocal',
                'feature_button_default' => ""
            ),
            421 => array(
                'name' => 'Porsche of Fremont',
                'ag_id' => null,
                'region' => 'nocal',
                'feature_button_default' => ""
            ),
            616 => array(
                'name' => 'Fletcher Jones Imports',
                'ag_id' => 29628,
                'region' => 'vegas',
                'feature_button_default' => "/current-mb-offers/"
            ),
            615 => array(
                'name' => 'Mercedes-Benz of Henderson',
                'ag_id' => 29882,
                'region' => 'vegas',
                'feature_button_default' => "/fletcher-jones-preferred-owners-club/"
            ),
            777 => array(
                'name' => 'Mercedes-Benz of Honolulu',
                'ag_id' => 29826,
                'region' => 'hawaii',
                'feature_button_default' => ""
            ),
            796 => array(
                'name' => 'Porsche of Hawaii',
                'ag_id' => null,
                'region' => 'hawaii',
                'feature_button_default' => ""
            ),
            797 => array(
                'name' => 'Big Island Honda',
                'ag_id' => null,
                'region' => 'hawaii',
                'feature_button_default' => ""
            ),
            1434 => array(
                'name' => 'Mercedes-Benz of Maui',
                'ag_id' => null,
                'region' => 'hawaii',
                'feature_button_default' => ""
            ),
            535 => array(
                'name' => 'Mercedes-Benz Chicago',
                'ag_id' => null,
                'region' => 'chicago',
                'feature_button_default' => "/courtesy-vehicle-lease-specials/"
            ),
            767 => array(
                'name' => 'Fletcher Jones Honda',
                'ag_id' => null,
                'region' => 'chicago',
                'feature_button_default' => ""
            ),
            1547 => array(
                'name' => 'Fletcher Jones Audi Chicago',
                'ag_id' => null,
                'region' => 'chicago',
                'feature_button_default' => ""
            ),
            1546 => array(
                'name' => 'Fletcher Jones Volkswagen',
                'ag_id' => null,
                'region' => 'chicago',
                'feature_button_default' => ""
            ),
            1702 => array(
                'name' => 'Fletcher Jones Redesign',
                'ag_id' => 29633,
                'region' => 'socal',
                'feature_button_default' => ""
            ),
            713 => array(
                'name' => 'Fletcher Jones Chicago Regional',
                'ag_id' => null,
                'region' => 'chicago',
                'feature_button_default' => ""
            )
        );
    }

    public function get_fj_array() {
        return $this->_fj;
    }

    public function set_autogravity_dealers() {
        $this->_autogravity_dealers = array(570);
    }

    public function get_autogravity_dealers() {
        return $this->_autogravity_dealers;
    }

    public function set_di_id() {
        $dealerInspireID = \get_option('di_id');
        $this->_di_id = is_int(intval($dealerInspireID)) ? intval($dealerInspireID) : $dealerInspireID;
    }

    public function get_di_id() {
        return $this->_di_id;
    }

    public static function get_form_id($title){
        $forms = \GFAPI::get_forms();
        $form_id = 1;
        foreach($forms as $i => $form)
        {
            if($form['title'] == $title) {
                $form_id = $form['id'];
            }
        }
        return $form_id;
    }

}