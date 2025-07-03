<?php
extract($coupon_vars);
$coupon_image = $images['html']['thumbnail'];
$fixed_ops_types = wp_get_post_terms($coupon_vars['id'], 'fixedoptype');
$type = '';
if (!empty($fixed_ops_types) && is_array($fixed_ops_types)) {
  $type = $fixed_ops_types[0]->slug;
}
if (array_key_exists('buttons', $coupon_vars)) {
  foreach ($coupon_vars['buttons'] as &$button) {
    $button['classes'] = '';
    if (strpos(strtolower($button['title']), 'part') !== false) {
      $button['classes'] = 'difo-parts-button';
    }
  }
}
?>

<div id="coupon-<?php echo $id; ?>" class="coupon-coupon difo-list-item <?php echo $type; ?>">
    <div class="inner">
        <div class="container-fluid">
            <div class="row">
				<?php echo get_namespaced_template_part('__difo_global_partials', 'partial', 'coupon-head-list', [
      'coupon_vars' => $coupon_vars,
    ]); ?>
                <?php echo get_namespaced_template_part('__difo_global_partials', 'partial', 'coupon-content-list', [
                  'coupon_vars' => $coupon_vars,
                ]); ?>
            </div>
        </div>
    </div>

    <?php echo $print_html; ?>

    <?php if (current_user_can('moderate_comments')): ?>
        <div class="edit-difo"><?php echo edit_post_link('<i class="fa fa-pencil"></i>', '', '', $id); ?></div>
    <?php endif; ?>
</div>
