<div id="buy-overlay" class="hidden-all">
  <?php 
    $button_overlay_heading = get_field('button_overlay_heading');
    $button_overlay_image = get_field('button_overlay_image');
  ?>
  <h2><?php echo $button_overlay_heading; ?></h2>
  <div class="vehicle-image">
    <img data-original="<?php echo $button_overlay_image['url']; ?>" alt="<?php echo $button_overlay_image['alt']; ?>">
  </div>
  <div class="overlay-buttons">
    <?php
      if( have_rows('overlay_buttons') ):
          while ( have_rows('overlay_buttons') ) : the_row();

          $button_overlay_text = get_sub_field('button_overlay_text');
          $button_overlay_link = get_sub_field('button_overlay_link');
          $button_class = strtolower( preg_replace('/\W+/','-',$button_overlay_text) );

          ?>

          <a trid="ef3caaeaa6f7485181571d" trc href="<?php echo $button_overlay_link; ?>" class="button primary-button <?php echo $button_class;?>"><?php echo $button_overlay_text; ?></a>

          <?php
          endwhile;
        endif;
      ?>
  </div>
</div>