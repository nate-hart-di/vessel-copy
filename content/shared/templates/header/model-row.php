<?php use DealerInspire\Vessel\FJ as _FJ; 
    $id = get_option('di_id');
    $isTemecula = ( $id == _FJ::getInstance()->dealerIdList['temecula'] );
    $isOntario = ( $id == _FJ::getInstance()->dealerIdList['fjontario'] );
?>
<div id="menu_modelRow">
    <div class="model_nav">
        <div class="container-wide">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav-tabs" id="modelTab">
                        <li class="active" ><button trid="a3f65ea31afd431d879aba" trc class="featured-button" data-toggle="tab" href="#tab_hybrid">Hybrid &amp; Electric</button></li>
                        <li><button trid="5883a6def8b64d38827106" trc data-toggle="tab" href="#tab_sedan">Sedans &amp; Wagons</button></li>
                        <li><button trid="78eb18db7d3c4d61a72720" trc data-toggle="tab" href="#tab_coupe">Coupes</button></li>
                        <li><button trid="29ac9dcbfe494a55badc45" trc data-toggle="tab" href="#tab_suvs">SUVS</button></li>
                        <li><button trid="ca7d209002d34b9c9147fc" trc data-toggle="tab" href="#tab_convert">Convertibles &amp; Roadsters</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-wide">
        <div class="tab-content">
            <div id="tab_sedan" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="sedanModels">

                            <div class="item">
                                <a trid="a022225a659944e5979e2a" trc href="/mercedes-benz/c-class/2024-sedan/" data-gtm-event-label="C-Class Sedan" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/sedan/c-class-sedan.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/sedan/c-class-sedan.png');?>" alt="C-Class Sedan" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">C-Class Sedan</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="6558a1d54ef2496b94b486" trc href="/mercedes-benz/e-class/2024-sedan/" data-gtm-event-label="E-Class Sedan" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/sedan/e-class-sedan.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/sedan/e-class-sedan.png');?>" alt="E-Class Sedan" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">E-Class Sedan</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="50fb50636d5642e6997f2b" trc href="/mercedes-benz/s-class/2024-sedan/" data-gtm-event-label="S-Class Sedan" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/sedan/s-class-sedan.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/sedan/s-class-sedan.png');?>" alt="S-Class Sedan" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">S-Class Sedan</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="84ed92e2aef94155b3518e" trc href="/mercedes-benz/maybach/2024-sedan/" data-gtm-event-label="Mercedes-Maybach" ><img style="margin-top: 6px;" data-original="/wp-content/plugins/vessel/content/shared/images/models/sedan/s-class-maybach.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/sedan/s-class-maybach.png');?>" alt="Mercedes Maybach" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">Mercedes-Maybach</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="63a9482f0298413893280c" trc href="/mercedes-benz/e-class/2024-wagon/" data-gtm-event-label="E-Class Wagon" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/sedan/e-class-wagon.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/sedan/e-class-wagon.png');?>" alt="E-Class Wagon" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">E-Class Wagon</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab_coupe" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="coupeModels">

                            <div class="item">
                                <a trid="ea6abe052488461eaf5bd6" trc href="/mercedes-benz/cla/2024-coupe/" data-gtm-event-label="CLA" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/coupe/cla-coupe.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/coupe/cla-coupe.png');?>" alt="CLA" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">CLA</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="bb5ab2807fc54631a441d6" trc href="/mercedes-benz/cle/2024-coupe/" data-gtm-event-label="CLE" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/coupe/cle-coupe.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/coupe/cla-coupe.png');?>" alt="CLA" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">CLE Coupe - Has Arrived!</div>
                                </div>
                            </div>

                            <?php // if( $isTemecula) : ?>
                            <div class="item">
                                <a trid="65a4bce946af44b4a448ab" trc href="/mercedes-amg/gt/2024-4-door-coupe/" data-gtm-event-label="AMG&reg; GT 4-Door" ><img style="transform: translate(0, 4px);" data-original="/wp-content/plugins/vessel/content/shared/images/models/coupe/amg-gt-4-door-new.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/coupe/amg-gt-4-door-new.png');?>" alt="AMG GT 4-Door" /></a>
                                <div class="label-wrap">
                                    <div class="model-name">AMG&reg; GT 4-Door</div>
                                </div>
                            </div>
                            <?php /*
                            $page = get_page(44145);
                            if($page){
                            */ ?>
                            <div class="item">
                                <a trid="f9faa28aea1040798055a2" trc href="/mercedes-amg/gt/2024-gt-coupe/" data-gtm-event-label="AMG&reg; GT Coupe" ><img style="transform: translate(0, 4px);" data-original="/wp-content/plugins/vessel/content/shared/images/models/coupe/amg-gt-coupe-new.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/coupe/amg-gt-coupe-new.png');?>" alt="AMG GT Coupe" /></a>
                                <div class="label-wrap">
                                    <div class="model-name">AMG&reg; GT Coupe</div>
                                </div>
                            </div>
                            <?php
                            //}
                            ?>
                            <?php // endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab_suvs" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="suvModels">
                            <div class="item">
                                <a trid="25922d4c57e9400a896047" trc href="/mercedes-benz/g-class/2024-suv/" data-gtm-event-label="G-Class SUV"  ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/g-class-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/g-class-suv.png');?>" alt="G-Class SUV" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">G-Class SUV</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="fbe7373572304ebda42602" trc href="/mercedes-benz/gla/2024-suv/" data-gtm-event-label="GLA SUV" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/gla-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/gla-suv.png');?>" alt="GLA SUV" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLA SUV</div>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="f2cfc526499446fbbc8321" trc href="/mercedes-benz/glb/2024-suv/" data-gtm-event-label="GLB SUV" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/glb-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/glb-suv.png');?>" alt="GLB SUV" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLB SUV</div>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="1f2483b1e3c64dc9816be9" trc href="/mercedes-benz/glc/2024-suv/" data-gtm-event-label="GLC SUV" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/glc-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/glc-suv.png');?>" alt="GLC SUV" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLC SUV</div>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="ad35002364fd4d7d9bef3c" trc href="/mercedes-benz/glc/2024-coupe/" data-gtm-event-label="GLC Coupe" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/coupe/glc-coupe.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/coupe/glc-coupe.png');?>" alt="GLC Coupe" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLC Coupe</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="cd46242e1d164c789dfcd9" trc href="/mercedes-benz/gle/2024-suv/" data-gtm-event-label="GLE SUV" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/gle-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/gle-suv.png');?>" alt="GLE SUV" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLE SUV</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="d72fdfc3bc4e43d6b6fd5b" trc href="/mercedes-amg/gle/2024-coupe/" data-gtm-event-label="GLE Coupe" ><img style="margin-top:10px;" data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/gle-53-coupe.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/gle-53-coupe.png');?>" alt="GLE Coupe" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLE Coupe</div>
                                </div>
                            </div>

                            <div class="item">
                                <a trid="3816bab0539140f7812554" trc href="/mercedes-benz/gls/2024-suv/" data-gtm-event-label="GLS SUV" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/gls-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/gls-suv.png');?>" alt="GLS SUV" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">GLS SUV</div>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="23af001c44354dfe998237" trc href="/mercedes-benz/maybach/2024-suv/" data-gtm-event-label="Maybach GLS" ><img style="margin-top:7px;" data-original="/wp-content/plugins/vessel/content/shared/images/models/suv/maybach-gls.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/suv/maybach-gls.png');?>" alt="Maybach GLS" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">Maybach GLS</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab_convert" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="convertModels">
                            <div class="item">
                                <a trid="83da798c8ff444299d28b7" trc href="/mercedes-amg/sl/2024-roadster/" data-gtm-event-label="SL-Class Roadster" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/cabriolet/sl-roadster.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/cabriolet/sl-roadster.png');?>" alt="SL" /></a>

                                <div class="label-wrap">
                                    <div class="model-name">SL-Class</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab_hybrid" class="tab-pane fade in active">
                <div class="row">

                    <div class="col-sm-12">
                        <div id="hybridModels">
                            <div class="item">
                                <a trid="e7073b18326f47b5a38ea0" trc href="/mercedes-benz/eqs/2024-sedan/" data-gtm-event-label="EQS" ><img style="transform: translate(0, 6px);" data-original="/wp-content/plugins/vessel/content/shared/images/models/hybrid/eqs.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/hybrid/eqs.png');?>" alt="EQS" /></a>
                                <div class="label-wrap">
                                    <div class="model-name">EQS</div>
                                    <?php do_action('content_after_eqs'); ?>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="9885e2057871447493f8b8" trc href="/mercedes-benz/eqb/2024-suv/" data-gtm-event-label="EQB" ><img data-original="/wp-content/plugins/vessel/content/shared/images/models/hybrid/eqb.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/hybrid/eqb.png');?>" alt="EQB" /></a>
                                <div class="label-wrap">
                                    <div class="model-name">EQB</div>
                                    <?php do_action('content_after_eqb'); ?>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="0194ef5152d74a46954dd4" trc href="/mercedes-benz/eqs/2024-suv/" data-gtm-event-label="EQS SUV"><img data-original="/wp-content/plugins/vessel/content/shared/images/models/hybrid/eqs-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/hybrid/eqs-suv.png');?>" alt="EQS SUV" /></a>
                                <div class="label-wrap">
                                    <div class="model-name">EQS SUV</div>
                                    <?php do_action('content_after_eqs_suv'); ?>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="4d6ce29766394c1987e27e" trc href="/mercedes-benz/eqe/2024-sedan/" data-gtm-event-label="EQE" ><img style="transform: translate(0, 4px);" data-original="/wp-content/plugins/vessel/content/shared/images/models/hybrid/eqe-sprite.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/hybrid/eqe-sprite.png');?>" alt="EQE" /></a>
                                <div class="label-wrap">
                                    <div class="model-name">EQE</div>
                                    <?php do_action('content_after_eqe'); ?>
                                </div>
                            </div>
                            <div class="item">
                                <a trid="fcfeecea3b4a4b45a5e798" trc href="/mercedes-benz/eqe/2024-suv/" data-gtm-event-label="EQE SUV" ><img style="transform: translate(0, 4px);" data-original="/wp-content/plugins/vessel/content/shared/images/models/hybrid/eqe-suv.png?ver=<?php echo filemtime(WP_PLUGIN_DIR.'/vessel/content/shared/images/models/hybrid/eqe-suv.png');?>" alt="EQE SUV" /></a>
                                <div class="label-wrap">
                                    <div id="eqe-suv-show" class="model-name">EQE SUV - Coming Soon!</div>
                                    <div id="eqe-suv-hidden" class="model-name hidden">EQE SUV</div>
                                    <?php do_action('content_after_eqe_suv'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
