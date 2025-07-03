<?php
    get_scoped_template_part('partials/dealer-groups/toyota/toyotaexample2/header', '', array(
        // 'hours_department' => 'Sales,Service',
        // 'phone_department' => 'Sales,Service,Parts',
        // 'show_hours' => true,
        //'show_social' => true,
        // 'social_params' => array('loadLightboxes'=>true, 'access_token'=>'275613174.1677ed0.604a99f60c474664a4f2416d064e6d64', 'user_id'=>'275613174'),
        // 'show_os_in_header' => false,
        'oem_no_space' => true,
        'navWalker' => new wp_bootstrap_navwalker()
    ));
?>