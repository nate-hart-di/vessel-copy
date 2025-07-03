<?php
namespace DealerInspire\Vessel;

if (!class_exists('VesselHoursShortcode')) {
  class VesselHoursShortcode
  {
    public function __construct()
    {
      //need to wait for all plugins to load so that the shortcode exists when we remove it

      // 616 == fjimports
      // 435 == fjmercedes
      // 535 == mbchicago
      // $id = get_option('di_id');
      // if( $id == 616|| $id == 435 || $id == 535){
      add_action('after_setup_theme', [$this, 'init']);
      // }
    }

    public function init()
    {
      remove_shortcode('di_display_open_hours');
      add_shortcode('di_display_open_hours', [$this, 'do_my_shortcode']);
    }

    public function do_my_shortcode($atts, $content = null)
    {
      $tz = get_option('timezone_string');
      $current_day = (new \DateTime('now', new \DateTimeZone($tz)))->format('l');

      extract(
        shortcode_atts(
          [
            'departments' => 'Sales,Service & Parts',
            'class' => 'dynamic-hours',
            'show_disclaimer' => false,
          ],
          $atts,
        ),
      );

      $days = [
        'Sunday' => 0x1,
        'Monday' => 0x2,
        'Tuesday' => 0x4,
        'Wednesday' => 0x8,
        'Thursday' => 0x10,
        'Friday' => 0x20,
        'Saturday' => 0x40,
      ];

      $departments = array_map('trim', explode(',', $departments));
      $departments = apply_filters('di_open_hours_depts', $departments, $atts, $current_day);

      $hours = json_decode(get_option('di_hours'), true);
      $hours = is_array($hours) ? $hours : [];

      $return_string = '';
      $is_open = false;

      foreach ($hours as $h) {
        // $h['name'] == Department Name
        if (in_array($h['name'], $departments)) {
          $return_string .=
            '<span class="department">' .
            _x($h['name'], 'Dynamic Hours', 'dealerinspire') .
            ':&nbsp;</span><span class="hours">';
        } else {
          continue;
        }

        $todays_hours = 'Closed';

        // Matched Department
        foreach ($h['hours'] as $hour) {
          $today = $days[$current_day];

          if ($today & $hour['days']) {
            $todays_hours = $hour;
            break;
          }
        }

        if ($todays_hours != 'Closed') {
          $is_open = true;
          $open = strtolower(
            $todays_hours['open_hour'] .
              ($todays_hours['open_minute'] > 0 ? ':' . $todays_hours['open_minute'] : '') .
              $todays_hours['open_meridian'],
          );
          $close = strtolower(
            $todays_hours['close_hour'] .
              ($todays_hours['close_minute'] > 0 ? ':' . $todays_hours['close_minute'] : '') .
              $todays_hours['close_meridian'],
          );
          $time_separator = apply_filters('di_time_separator', '-');

          // is_fr is not available in Common v4
          if (function_exists('is_fr') && is_fr()) {
            $open = DIFunctions::convert_to_canada_time($open, $todays_hours);
            $close = DIFunctions::convert_to_canada_time($close, $todays_hours, 'close');
          }
          $return_string .=
            '<span class="doy">' . _x(substr($current_day, 0, 3), 'Dynamic Hours', 'dealerinspire') . '&nbsp;</span>';
          $return_string .=
            $open .
            $time_separator .
            $close .
            (!empty($disclaimer) && $show_disclaimer == true
              ? ' <span class="disclaimer">(' . $disclaimer . ')</span>'
              : '');
        } else {
          // Allow filters to customize the 'Closed' text based on the Department and Day of the week.
          $closed_text = apply_filters(
            'department_hours_closed_text',
            _x('Closed', 'DI Hours', 'dealerinspire'),
            $h['name'],
            $current_day,
          );
          $return_string .= '<span class="closed">' . $closed_text . '</span>';
        }

        $return_string .= '</span>';
      }

      $open_today = $is_open
        ? '<span class="open">' . apply_filters('open_today_text', __('Open Today!', 'dealerinspire')) . '</span> '
        : '';

      $return_string = $open_today . $return_string;

      $return_string = apply_filters('di_hours_shortcode_todays_hours', $return_string);

      return "<span class='{$class}'>{$return_string}</span>";
    }
  }
}
