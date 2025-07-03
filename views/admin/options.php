<?php
namespace DealerInspire\Vessel;

$FJ = new FJ();
$vessel = new Vessel($FJ);
$admin = new Admin($FJ, $vessel);

if (isset($_REQUEST['submit']) && $_REQUEST['submit'] === 'Save Changes') {
  if (isset($_REQUEST['countdown']) && !empty($_REQUEST['countdown'])) {
    update_option('homepage-countdown-enabled', $_REQUEST['countdown']);
  } else {
    update_option('homepage-countdown-enabled', 'false');
  }
}
?>
<div class="wrap">

	<h2 class="nav-tab-wrapper">
		<a href="<?php echo add_query_arg('tab', 'general'); ?>" class="nav-tab <?php echo $active_tab == 'general'
  ? 'nav-tab-active'
  : ''; ?>"><?php _e('General'); ?></a>
	</h2>

	<div class="tab-container">

		<form id="settings-select" method="post" action="">
            <div>
                <input class="countdown" type="checkbox" id="countdown" name="countdown" value="true" <?php echo $admin->is_true(
                  'homepage-countdown-enabled',
                )
                  ? 'checked'
                  : ''; ?>>
                <label for="countdown">Enable Countdown Timer</label>
            </div>

		<?php submit_button(); ?>
		</form>
	</div>
</div>