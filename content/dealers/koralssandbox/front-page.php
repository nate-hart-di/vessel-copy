<?php
/*
	Home page of the site
*/
?>

<div class="visible-xs">   	<!-- DEFAULT MOBILE HOMEPAGE -->
    <?php get_template_part('partials/homepage/mobile/open-hours'); ?>
    <?php get_template_part('partials/homepage/mobile/search-banner'); ?>

</div>



<div class="hidden-xs">


    <!-- DELETE THIS CODE -->

    <div class="container-wide">
        <div class="row">
            <div class="col-sm-12">
                <h1>Front page brought to you by Vessel!</h1>

                <h2>Heading 2</h2>

                <h3>Heading 3</h3>

                <h4>Heading 4</h4>

                <p>Sample paragraph text.</p>
            </div>
        </div>
    </div>

    <!-- DELETE THIS CODE -->


</div>

<div class="visible-xs">
    <?php get_template_part('partials/homepage/mobile/weather'); ?>
</div>

