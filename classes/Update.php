<?php

namespace DealerInspire\Vessel;


class Update extends API
{

    public function __construct(FJ $FJ)
    {
        parent::__construct($FJ);
    }

    public function vessel_update_api_hooks() {

        add_action('wp_ajax_nopriv_update_vessel_setting', array($this, 'update_vessel_setting'));
//         Endpoint: /wp/wp-admin/admin-ajax.php?action=

    }

    public function update_setting($settings) {
        $no_slashes = stripslashes_deep($settings);

        $decoded_settings = json_decode($no_slashes, true);

        foreach($decoded_settings as $key => $value){
            switch ($key){
                case "button_text":
                    update_field($key, $value, 'option');
                    break;
                case "button_color":
                    update_field($key, $value, 'option');
                    break;
                case "button_link":
                    update_field($key, $value, 'option');
                    break;
                case "start_date":
                    update_field($key, $value, 'option');
                    break;
                case "end_date":
                    update_field($key, $value, 'option');
                    break;
                case "countdown_timer":
                    update_field($key, $value, 'option');
                    break;
                case "countdown_timer_enabled":
                    update_field($key, $value, 'option');
                case "radioactive":
                    update_field($key, $value, 'option');
                case "last_mass_update_time":
                    update_option($key, $value);
                case "last_mass_update_name":
                    update_option($key, $value);
                default:
                    break;
            }
        }
    }

    public function update_vessel_setting() {
        if (!$this->check_vessel_auth_key()){
            return;
        }

        $this->update_setting($_REQUEST['vessel_settings_update']);

        $res = array (
          'code' => 200
        );

        wp_send_json_success($res);

        wp_die();
    }

}