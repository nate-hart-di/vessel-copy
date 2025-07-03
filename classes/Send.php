<?php

namespace DealerInspire\Vessel;

class Send extends API
{
  public function __construct(FJ $FJ)
  {
    parent::__construct($FJ);
  }

  public function vessel_send_api_settings_hooks()
  {
    add_action('wp_ajax_nopriv_send_settings', [$this, 'send_settings']);
  }

  public function send_settings()
  {
    if (!$this->check_vessel_auth_key()) {
      return;
    }

    $fj_array = $this->_fj->get_fj_array();
    $vessel_version = Utility::get_vessel_version();
    $di_slug = get_option('di_slug');
    $di_name = get_option('di_name');
    $di_id = get_option('di_id');
    $feature_button_text = get_field('button_text', 'option');
    $feature_button_color = get_field('button_color', 'option');
    $button_link = get_field('button_link', 'option');
    $start_date = get_field('start_date', 'option');
    $end_date = get_field('end_date', 'option');
    $timer = get_field('countdown_timer', 'option');
    $radioactive = get_field('radioactive', 'option');
    $last_mass_update_name = get_option('last_mass_update_name');
    $last_mass_update_time = get_option('last_mass_update_time');

    $json = [
      'di' => [
        'di_slug' => $di_slug,
        'di_name' => $di_name,
        'di_id' => $di_id,
        'vessel_version' => $vessel_version,
        'last_mass_update_name' => $last_mass_update_name !== '' ? $last_mass_update_name : 'N/A',
        'last_mass_update_time' => $last_mass_update_time !== '' ? $last_mass_update_time : 'N/A',
      ],
      'settings' => [
        'feature_button' => [
          'text' => $feature_button_text !== '' ? $feature_button_text : 'Why FJ',
          'color' => $feature_button_color !== '' ? $feature_button_color : 'FJ blue',
          'link' =>
            $button_link !== ''
              ? $button_link
              : ($fj_array[$di_id]['feature_button_default'] === ''
                ? '/current-offers/'
                : $fj_array[$di_id]['feature_button_default']),
          'radioactive' => $radioactive !== '' ? $radioactive : 'disabled',
        ],
        'countdown_timer' => [
          'enabled' => $timer[0] !== '' ? $timer[0] : 'disabled',
          'start_date' => $start_date !== '' ? $start_date : 'disabled',
          'end_date' => $end_date !== '' ? $end_date : 'disabled',
        ],
      ],
    ];

    echo json_encode($json);
    wp_die();
  }
}
