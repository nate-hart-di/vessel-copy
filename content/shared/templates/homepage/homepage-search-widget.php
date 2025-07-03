<?php
$top_text = isset($top_text) && !empty($top_text) ? $top_text : 'Advanced Search';
?>

<div class="search-section__content">
    <div class="row pzRow">
        <div class="col-sm-12">
            <span class="personalizer-wrap overlayloader">
                <h2><?php echo $top_text; ?></h2>
            </span>
        </div>
        <div class="col-sm-12">
            <div class="subheading">
                <span><?php echo do_shortcode('[inventory_info name="count"]'); ?> vehicles to choose from</span>
            </div>
        </div>
    </div>
    <div class="row dropdownFiltersRow">
        <div class="col-sm-12 dropdownFiltersRow__container filters-container">
            <div class="dropdownFiltersRow__filters flex-container" id="homepage-advanced-search">
                <?php get_scoped_template_part('partials/search/tymm', '', isset($tymm)?$tymm:array()); ?>
            </div>
        </div>
    </div>
</div>