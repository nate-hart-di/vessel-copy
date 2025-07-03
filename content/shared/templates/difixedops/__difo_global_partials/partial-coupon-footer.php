<?php
extract($coupon_vars);
$permalink = get_permalink($id);
preg_match('/\.com\/(.*)/', get_option('di_twitter_id'), $twitterMatch);
$twitterName = (isset($twitterMatch[1])) ? $twitterMatch[1] : '';
?>

<div class="coupon-actions">
    <div class="social-share" style="text-align: right;">
        <?php
        /*
        if (difo_sharer()) {
            echo difo_sharer()->facebook($permalink);
        }
        <a trid="eee6e769dcce4626960c7c" trc href="https://www.facebook.com/sharer/sharer.php?u=<?= $permalink; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
        <a trid="fcc64f03b66448dc9bf6f7" trc href="https://twitter.com/intent/tweet?url=<?= $permalink; ?>&text=Check out this offer!&via=<?= $twitterName; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
        */
        ?>
        
    </div>
    <ul class="button-wrap">
    <?php foreach ($buttons as $button) :
        $classes = array();
        $_classes = array(
            'difo-' . $button['link'],
            'difo-' . $button['type'],
            $button['classes'],
            ( $button['type'] == 'wallet' ) ? 'difo-wallet-btn-container' : '',
            ( isset($button['id']) && $button['id'] ) ? 'difo-'.$button['id'] : '',
        );
        foreach ($_classes as $class) {
            $classes[] = di_fixed_ops()->permalize($class);
        }
        $classes = implode(' ', apply_filters('difo_button_wrapper_classes', $classes));
        ?>
        <li class="<?php echo $classes; ?>"><?php echo $button['button_html']; ?></li>
    <?php endforeach; ?>
    </ul>
</div>