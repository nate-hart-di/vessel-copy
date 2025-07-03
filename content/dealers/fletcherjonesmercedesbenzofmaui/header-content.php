<?php get_frontend_component('header/header-v2'); ?>
<?php
get_scoped_template_part(
    'partials/translate/google', 'translate',
    array(
        'mobile' => 'true'
    )
);
?>

<?php get_frontend_component('header/model-row'); ?>
