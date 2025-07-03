<?php

if (!function_exists('get_header')) {
  die();
} //Block direct access
/*
	default index template
*/

get_header();

// Check to see if action bar is turned on or off in Site Settings of DI plugin
$actionBarSettings = get_option('di_actionbars');
if (isset($actionBarSettings['show_actionbar'])) {
  get_template_part('partials/actionbars/four-cta-icon-breadcrumbs');
}
?>

<div class="container-wide contentcontainer">
	<div class="row">
		<div class="col-sm-12 content">
			<div class="row">
				<div class="col-sm-8">
					<div class="posts-wrap clearfix">
						<?php /**
       * main content loop with headings
       *
       */

      if (have_posts()):
        while (have_posts()):
          the_post(); ?>

						<div <?php post_class(); ?>>

							<div class="post-content">
                                <?php if (get_option('di_id') == 654): ?>
                                    <a trid="cb2dffe6c8f647a7852234" trc style="display: inline;" href="/blog" class="back-button button primary-button small" id="me">Home</a>
                                <?php endif; ?>
						    <?php
          do_action('di_content_bookends', get_the_ID(), 'top');

          if (is_single()) { ?>

								<h1 class="entry-title"><?php the_title(); ?></h1>

								<div class="meta-below-title">
									<span class="updated">
									    <?php the_time('F jS, Y'); ?>
						            </span> by <span class="vcard author">
						                <span class="fn">
						                    <?php the_author_posts_link(); ?>
						                </span>
						            </span>
						        </div>

						        <div class="sharing">
						            Share this Post:
						            <?php do_action('blog_before_share'); ?>

						            <a trid="b7160bac901941f59d7de8" trc href="javascript:void(0);" onclick="popupwindow('https://www.facebook.com/sharer/sharer.php?s=100&p[url]=<?php echo get_permalink(); ?>&p[title]=<?php echo urlencode(
  get_the_title(),
); ?>','Share on Facebook',940,500); clicky.log(this.href);" class="fa fa-facebook button primary-button facebook"></a>

						            <a trid="994df8c4f6974e71b8061e" trc href="javascript:void(0);" onclick="popupwindow('https://twitter.com/share?text=Check%20out%20this%20post%20<?php echo urlencode(
                    get_the_title(),
                  ); ?>&url=<?php echo get_permalink(); ?>','Share on Twitter',600,250);clicky.log(this.href);" class="fa fa-twitter button primary-button twitter" ></a>

						            <a trid="0ba5a5ccb8604145bdff5e" trc href="javascript:void(0);" onclick="popupwindow('https://plus.google.com/share?url=<?php echo get_permalink(); ?>','Share on Google Plus',600,350); clicky.log(this.href);" class="fa fa-google-plus button primary-button googleplus"></a>

						            <?php if (apply_filters('blog_share_enable_linkedin', false)): ?>
						            <a trid="e802a30c3f914d7d993a75" trc href="javascript:void(0);" onclick="popupwindow('https://www.linkedin.com/shareArticle?mini=true&url=<?= get_permalink() ?>&title=<?= get_the_title() ?>', '<?php do_action(
  'blog_after_share',
); ?>','Share on LinkedIn',600,350); clicky.log(this.href);" class="fa fa-linkedin button primary-button linkedin"></a>
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

							    <?php } elseif (!is_page()) { ?>

						        <h2>
						            <a trid="237d8d5c747d46c29b897a" trc class="entry-title" href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						        </h2>
						        <div class="meta-below-title">
						            <span class="updated">
						                <?php the_time('F jS, Y'); ?>
						            </span> by
						            <span class="vcard author">
						                <span class="fn">
						                    <?php the_author_posts_link(); ?>
						                </span>
						            </span>
						        </div>

						        <?php } elseif (is_page()) { ?>

						        <h1 class="entry-title">
						            <?php the_title(); ?>
						        </h1>

						        <?php }
          ?>

						        <?php if (is_single() || is_page()) { ?>
						        <div class="entry"><!-- open entry -->
						            <?php the_content(); ?>


									<?php if (have_rows('upsells')): ?>
										<div class="swiper-container upsell-container">
											<div class="swiper-wrapper upsells">
	    									 	<?php // loop through the rows of data
           // loop through the rows of data
           while (have_rows('upsells')):
                  the_row(); ?>

	    									        <a trid="8f5ce9607ba146829f8289" trc class="swiper-slide upsell-item" href="<?php the_sub_field(
                        'link',
                      ); ?>" target="_<?php the_sub_field('target'); ?>">
	                                                    <?php
                                                     $image = get_sub_field('image');
                                                     $size = 'medium';
                                                     $imgsrc = $image['sizes'][$size];
                                                     ?>
	                                                    <span>
	                                                        <img src="<?php echo $imgsrc; ?>" alt="<?php echo $image[
  'alt'
]; ?>">
	                                                    </span>
	                                                    <p><?php the_sub_field('title'); ?></p>
	                                                    <span class="back-button button primary-button small">View More</a>
	                                                </a>

	    									    <?php
                endwhile; ?>

	                                        </div>
											<!-- If we need pagination -->
										    <div class="swiper-pagination"></div>

										    <!-- If we need navigation buttons -->
										    <div trid="3b0c668259b2411ab30ff8" trc class="swiper-button-prev"><i class="fa fa-chevron-left"></i></div>
										    <div trid="d159f8be623f4360a24285" trc class="swiper-button-next"><i class="fa fa-chevron-right"></i></div>
										</div>

									<?php else:endif; ?>

           // no rows found


						        </div><!-- end entry -->

						        <?php } else { ?>
						        <?php if (has_post_thumbnail()) { ?>

						        <div class="post-thumbnail">
						            <?php the_post_thumbnail('thumbnail'); ?>
						        </div>

						        <?php } ?>
						        <div class="entry"><!-- open entry -->
						            <?php the_excerpt(); ?>
						            <div class="meta-below-content"><!-- open meta -->
						                Posted in <?php the_category(', '); ?>
						            </div><!-- close meta -->
						        </div><!-- end entry -->
						        <?php } ?>
						        <?php
              if (is_single()) { ?>
						        <div class="meta-below-content"><!-- open meta -->
						            Posted in <?php the_category(', '); ?>
						        </div><!-- close meta -->
						        <?php }

              do_action('di_content_bookends', get_the_ID(), 'bottom');
              ?>

							</div><!-- end post class -->
						</div> <!-- end .post -->

						<?php
        endwhile; ?>

						<?php
      else:
         ?>
							 <p>Sorry, no posts matched your criteria.</p>
						<?php
      endif; ?>

						<?php do_action('below_single_blog_post'); ?>
						<div class="clearfix"></div>

						<?php if (is_single() && get_post()->post_type == 'post' && apply_filters('enable_post_comments', true)) { ?>
							<div class="comments"><!-- open comments -->
								<?php comments_template(); ?>
							</div><!-- close comments -->
						<?php } ?>
					</div>
					<div id="navigation-posts">
						<span class="previous-posts"><?php previous_posts_link('Previous Page'); ?></span>
						<span class="next-posts"><?php next_posts_link('Next Page'); ?></span>
					</div>
				</div>

				<div class="col-sm-4">
					<ul class="sidebar vertical"><?php dynamic_sidebar('Blog Sidebar'); ?></ul>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
