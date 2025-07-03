<?php if (!class_exists('DealerInspire_Vessel')) {
  die();
}
//Block Direct Access
?>
<?php
$option_value = get_option($prefix . $id);
if ($option_value === false) {
  $option_value = '';
}
$option_value = !is_null($option_id)
  ? (array_key_exists($option_id, $option_value)
    ? $option_value[$option_id]
    : '')
  : $option_value;
?>
<input type="text" id="<?php echo $prefix .
  $id .
  (!is_null($option_id) ? '_' . $option_id : ''); ?>" name="<?php echo $prefix .
  $id .
  (!is_null($option_id) ? '[' . $option_id . ']' : ''); ?>" class="<?php echo array_key_exists('class', $setting)
  ? $setting['class'] . ' '
  : ''; ?>code" value="<?php echo $option_value; ?>" />
<?php if (array_key_exists('description', $setting)): ?><p class="description"><?php echo $setting[
  'description'
]; ?></p><?php endif;
