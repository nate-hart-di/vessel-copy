<div class="visible-xs">
    <div class="mobile-cta" style="position: relative;display: block;">
        <?php if (have_rows('mobile_ctas')):
          $count = 0;
          while (have_rows('mobile_ctas')):

            the_row();

            $ctaImage = get_sub_field('image');
            $ctaLink = get_sub_field('link');
            $ctaLinkTitle = get_sub_field('button_text');
            $ctaLinkBG = get_sub_field('button_background');
            $ctaLinkColor = get_sub_field('button_color');

            if ($count < 2): ?>
            <div class="ctaItem di-lazyloaded">
                <img class="ctaItem-image" src="<?= $ctaImage['sizes']['thumbnail'] ?>" data-lazy-img="<?= $ctaImage[
  'sizes'
]['large'] ?>" alt="<?= $ctaImage['alt'] ?>" height="<?= $ctaImage['height'] ?>" />
                <a trid="f35189c8ea9e47bb8c1642" trc href="<?= $ctaLink ?>" class="button mobile-button" style="background-color:<?= $ctaLinkBG ?>;color:<?= $ctaLinkColor ?> !important"><?= $ctaLinkTitle ?></a>
            </div>        
        <?php else: ?>
            <div class="ctaItem">
                <?php if (!empty($ctaImage)): ?>
                <img class="ctaItem-image" data-original="<?= $ctaImage['sizes']['large'] ?>" alt="<?= $ctaImage[
  'alt'
] ?>" height="<?= $ctaImage['height'] ?>" />
                <?php endif; ?>
                <a trid="2520d59c2ccf41188b739a" trc href="<?= $ctaLink ?>" class="button mobile-button" style="background-color:<?= $ctaLinkBG ?>;color:<?= $ctaLinkColor ?> !important"><?= $ctaLinkTitle ?></a>
            </div>
        <?php endif;
            ?>
        <?php $count++;
          endwhile;
        endif; ?>
    </div>

    <div id="mobile-subscribe" data-acf="mobile_email_form">
        <?php //echo do_shortcode('[gravityform id="153" title="false" description="true"]');
        //changed form to an acf because it might differ for every site

        the_field('mobile_email_form'); ?>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
    $(".ctaItem").each(function(i,v){

        if( $(v).find("img").length == 0 ){
            $(v).addClass("di-lazyloaded")
        }
        if( $(v).find("img").attr('src') == undefined ){
            $(v).addClass("di-lazyloaded")
        }
        else{
            $(v).find("img").on('load',function(e){
                if( this.complete ){
                    $(v).addClass("di-lazyloaded");
                }
            });
        }
    });

    setTimeout(function(){
        $(".ctaItem.di-lazyloaded").each(function(i,v){
            if( $(v).find("img").length && !($(v).find("img").attr('data-lazy-img') == '') ){
                $(v).find("img").attr('src',$(v).find("img").data('lazy-img'));
                $(v).removeAttr('data-lazy-img');
            }
        });
        },1500);
});
</script>
