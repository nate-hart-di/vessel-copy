<?php

namespace DealerInspire\Vessel;

if ( ! class_exists('VrpButtonMover') ) {
    class VrpButtonMover
    {
        private static $instance;

        public $belowPriceCtaList = array();

        public function __construct()
        {
            add_action('plugins_loaded',[$this,'callback_all_plugins_loaded'],99,1);
        }

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new VrpButtonMover();
            }
            return self::$instance;
        }

        public function callback_all_plugins_loaded(){
         //       var_dump("FUCK");
            add_filter('vrp_more_action_links',array($this,'moveVrpCta'));
        //    add_action('vrp_listview_pricing_bottom_text',array($this,'addCtaItems'),999999);
        }

        public function setCtaItem($cta){
            if( empty( $this->belowPriceCtaList[ $cta['label'] ] ) ){
                $this->belowPriceCtaList[$cta['label']] = $cta;
            }
        }

        public function getCtaList(){
            return $this->belowPriceCtaList;
        }

        public function moveVrpCta($actionLinks){
           // var_dump($actionLinks[0]); 
            if(isset($actionLinks) && !empty($actionLinks) ){

                $actionLinks->each(function($actionLink){
                    $actionLink = $actionLink->toArray();
                   // var_dump(array_key_exists('css_classes', $actionLink) );
                    if( array_key_exists('css_classes', $actionLink) ){
                                     //       var_dump($actionLink['css_classes']);

                        foreach ($actionLink['css_classes'] as $index=>$class) {
                            if( $class =='below-price-cta'){
                                var_dump($class);
                               die();
                                   // $this->setCtaItem($actionLinks[$index]);
                            }
                        }
                        
                   // die();
                    }
                    return;
                });

            }
            return $actionLinks;
        }

        public function addCtaItems(){
            if(!empty($this->belowPriceCtaList) ){
                foreach( $this->belowPriceCtaList  as $ctaItem){
                    $label = $ctaItem['label'];
                    $link = $ctaItem['url'];
                    $classes = $ctaItem['css_classes'];
                    $form = $ctaItem['form_id'];
                    $href = ( !empty($link) ) ? $link : $form;
                    $output =  '<a trid="bfe5ce7c2a3b4c3882c507" trc class="button cta-button" href="'.$link.'" >'.$label.'</a>';
                    echo $output; 
                }
            }
        }
    }
}