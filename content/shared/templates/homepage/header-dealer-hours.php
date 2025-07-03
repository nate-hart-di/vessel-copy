<div class="dealer-hours">
    <?php
    $hours_service = false;
    $hours_service_and_parts = false;
    $hours = get_option('di_hours');
    $hours = !empty($hours) ? json_decode($hours) : $hours;
    if (is_array($hours)) {
      foreach ($hours as $dept) {
        if ($dept->name == 'Service') {
          $hours_service = true;
        } elseif ($dept->name == 'Service & Parts') {
          $hours_service_and_parts = true;
        }
      }
    }
    ?>
    <i class="fa fa-clock-o" aria-hidden="true"></i>
    <span class="hours hours-sales">
        <?php echo do_shortcode('[di_display_open_hours departments="Sales" class=dynamic-hours]'); ?>
    </span> |
    <span class="hours hours-service">
        <?php if ($hours_service_and_parts) {
          echo do_shortcode('[di_display_open_hours departments="Service & Parts" class=dynamic-hours]');
        } elseif ($hours_service) {
          echo do_shortcode('[di_display_open_hours departments="Service" class=dynamic-hours]');
        } ?>
    </span>
</div>