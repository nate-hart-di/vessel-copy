<?php

//Get options from Vessel options page
$start_date = get_field('start_date', 'option');
$end_date = get_field('end_date', 'option');
$today = strtotime('now');

if (timer_enabled() && ((strtotime($start_date) <= $today) && ($today < strtotime($end_date)))) {
    ?>
    <div class="col-sm-12 text-center">
        <div class="clock"></div>
    </div>
    <?php
}