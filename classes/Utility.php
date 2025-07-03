<?php

namespace DealerInspire\Vessel;

class Utility
{
  public static $token = getenv('VSLACK_TOKEN');
  public static $vessel;

  public function __construct(Vessel $vessel)
  {
    self::$vessel = $vessel;
  }

  /**
   * Send a Message to a Slack Channel.
   *
   * In order to get the API Token visit: https://api.slack.com/custom-integrations/legacy-tokens
   * The token will look something like this `xoxo-2100000415-0000000000-0000000000-ab1ab1`.
   *
   * @param string $message The message to post into a channel.
   * @param string $channel The name of the channel prefixed with #, example #foobar
   * @return boolean
   */
  public static function slack_message($message)
  {
    $ch = curl_init('https://slack.com/api/chat.postMessage');
    $data = http_build_query([
      'token' => self::$token,
      'channel' => '#vessel-notifications', //"#mychannel",
      'text' => $message, //"Hello, Foo-Bar channel message.",
      'username' => 'Vessel Bot',
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }

  public static function set_vessel_version()
  {
    $plugin = dirname(__DIR__, 1) . '/Vessel.php';
    $version = get_file_data($plugin, ['Version'], 'plugin');
    $updated_version = $version[0];

    update_option('vessel_version', $updated_version);
  }

  public static function get_vessel_version()
  {
    return get_option('vessel_version');
  }

  public static function check_vessel_version()
  {
    $old_version = self::get_vessel_version();

    $vessel_plugin = dirname(__DIR__, 1) . '/Vessel.php';
    $vessel_version = get_file_data($vessel_plugin, ['Version'], 'plugin');
    $string_version = $vessel_version[0];
    $current_version = intval($string_version);

    if (version_compare($old_version, $current_version, '<') && self::$vessel->is_prod()) {
      $message =
        '<!here> | Vessel updated on *' .
        get_option('di_description') .
        '* from `' .
        $old_version .
        '` to `' .
        $current_version .
        '` on ' .
        date('m/d/y') .
        ' at ' .
        date('H:i:s');
      self::slack_message($message);
    }
  }
}
