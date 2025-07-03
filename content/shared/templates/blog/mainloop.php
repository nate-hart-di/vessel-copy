<?php
/**
 * main content loop with headings
 *
 */
$msg = apply_filters( 'no_post_msg', "<p>Sorry, no posts matched your criteria.</p>");
$wpml_file_location = apply_filters( 'wpml_file_location', 'commontheme');


if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
?>

<main>
	<div <?php post_class(); ?>>
	
		<div class="post-content">
	
		<?php if ((!is_single() && !is_page()) && has_post_thumbnail()) { ?>
	        <div class="post-thumbnail">
	            <?php the_post_thumbnail('post-thumbnails'); ?>
	        </div>
	    <?php } ?>

	    <?php do_action('di_content_bookends', get_the_ID(), 'top' );
	
	        if (is_single()) { ?>
	
			<h1 class="entry-title"><?php the_title(); ?></h1>
	
			<div class="meta-below-title">
				<span class="updated">
	                <?php if ( is_fr() || (get_locale() == 'fr_FR' )) { ?>
	                    <?php the_time('j F, Y') ?>
	                    <?php } else { ?>
	                    <?php the_time('F jS, Y') ?>
	                    <?php } ?>
	            </span>
	            <span class="by-author"><?= __('by', 'commontheme'); ?></span>
	            <span class="vcard author">
	                <span class="fn">
	                    <?php the_author_posts_link() ?>
	                </span>
	            </span>
	        </div>
			<?php do_action('below_blog_date'); ?>
	
	        <div class="sharing">
	           <?= __('Share this Post:', 'commontheme'); ?>
	            <?php do_action('blog_before_share'); ?>
	
				<?php /** FB sharer no longer accepts custom parameters. Info here: https://developers.facebook.com/support/bugs/357750474364812/ */ ?>
	            <a trid="cc9924db79644e49ad28dd" trc href="javascript:void(0);" onclick="popupwindow('https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>','Share on Facebook',940,500); clicky.log(this.href);" class="fa fa-facebook button primary-button facebook"></a>
	
	            <a trid="d014811c15c94a93965b3d" trc href="javascript:void(0);" onclick="popupwindow('https://twitter.com/share?text=Check%20out%20this%20post%20<?php echo urlencode(get_the_title()); ?>&url=<?php echo get_permalink(); ?>','Share on Twitter',600,250);clicky.log(this.href);" class="fa fa-twitter button primary-button twitter" ></a>
	
	            <?php if(apply_filters('blog_share_enable_linkedin', false)) : ?>
	            <a trid="1bcc601737ce45328a57d1" trc href="javascript:void(0);" onclick="popupwindow('https://www.linkedin.com/shareArticle?mini=true&url=<?= get_permalink(); ?>&title=<?= get_the_title(); ?>', '<?php do_action('blog_after_share'); ?>','Share on LinkedIn',600,350); clicky.log(this.href);" class="fa fa-linkedin button primary-button linkedin"></a>
	            <?php endif; ?>
	
	        </div>
			<script type="text/javascript">
			    function popupwindow(url, title, w, h)
			    {
	                {
	                    var left = (screen.width/2)-(w/2);
	                    var top = (screen.height/2)-(h/2);
	                    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	                }
		        }
		    </script>
	
		    <?php  } else if (!is_page()) { ?>
	
	        <h2>
	            <a trid="8b4c134fc70e4c8baf1f24" trc class="entry-title" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	        </h2>
	        <div class="meta-below-title">
	            <span class="updated">
	                <?php if ( is_fr() || (get_locale() == 'fr_FR' )) { ?>
	                    <?php the_time('j F, Y') ?>
	                    <?php } else { ?>
	                    <?php the_time('F jS, Y') ?>
	                    <?php } ?>
	                </span>
	                <span class="by-author"><?= __('by', 'commontheme'); ?></span>
	            <span class="vcard author">
	                <span class="fn">
	                    <?php the_author_posts_link() ?>
	                </span>
	            </span>
	        </div>
			<?php do_action('below_blog_date'); ?>
	
	        <?php } else if (is_page()) { ?>
	
					
			        <h1 class="entry-title">
			            <?php the_title(); ?>
			        </h1>
					
	
	        <?php } ?>
	
	        <?php if (is_single() || is_page()) { ?>
	        <div class="entry"><!-- open entry -->
	            <?php the_content(); ?>
	        </div><!-- end entry -->
	
	        <?php } else { ?>

	        <div class="entry"><!-- open entry -->
	            <?php the_excerpt(); ?>
	            <div class="meta-below-content"><!-- open meta -->
	                <?= __('Posted in', 'commontheme'); ?> <?php the_category(', '); ?>
	            </div><!-- close meta -->
	        </div><!-- end entry -->
	        <?php } ?>
	        <?php if (is_single()) { ?>
	        <div class="meta-below-content"><!-- open meta -->
	            <?= __('Posted in', 'commontheme'); ?> <?php the_category(', '); ?>
	        </div><!-- close meta -->
	        <?php }
	
	        do_action('di_content_bookends', get_the_ID(), 'bottom' );
	
	        ?>
	
		</div><!-- end post class -->
	</div> <!-- end .post -->
</main>

<?php endwhile; ?>
<?php else: ?>
	<?= __($msg, $wpml_file_location); ?>
<?php endif; ?>

<?php do_action('below_single_blog_post'); ?>
<div class="clearfix"></div>

<?php if (is_single() && get_post()->post_type == 'post' && apply_filters( 'enable_post_comments', true ) ) { ?>
	<div class="comments"><!-- open comments -->
		<?php comments_template(); ?>
	</div><!-- close comments -->
<?php } ?>
