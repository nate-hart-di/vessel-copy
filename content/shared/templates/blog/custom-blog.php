<?php
/*
	content block for index template
*/
?>
<?php
if (!function_exists('get_header')) {
  die();
} //Block direct access
/*
	default index template
*/ get_header(); // Check to see if action bar is turned on or off in Site Settings of DI plugin
$actionBarSettings = get_option('di_actionbars');
if (isset($actionBarSettings['show_actionbar'])) {
  get_template_part('partials/actionbars/four-cta-icon-breadcrumbs');
}
?>

<div class="container-wide contentcontainer">
	<div class="row">
		<div class="col-sm-12 content">
			<div class="row">
				<?php
    $blog = get_option('page_for_posts');
    echo get_field('custom_page_css', $blog);
    ?>
				<h1><?php echo get_field('main_title', $blog); ?></h1>
				<h5><?php echo get_field('subtitle', $blog); ?></h5>
				<?php if (!is_single()) {
      do_action('blog_archive_before_main_loop');
    } ?>
				<div class="col-sm-8">
					<div class="posts-wrap clearfix">

					<?php get_frontend_component('blog/mainloop'); ?>
					</div>
					<?php if (is_fr()) { ?>
					<div id="navigation-posts">
						<span class="previous-posts"><?php previous_posts_link('Page précédente'); ?></span>
						<span class="next-posts"><?php next_posts_link('Page suivante'); ?></span>
					</div>
					<?php } else { ?>
					<div id="navigation-posts">
						<span class="previous-posts"><?php previous_posts_link('Previous Page'); ?></span>
						<span class="next-posts"><?php next_posts_link('Next Page'); ?></span>
					</div>
					<?php } ?>
				</div>
				
				<div class="col-sm-4">
					<ul class="sidebar vertical"><?php dynamic_sidebar('Blog Sidebar'); ?></ul>
				</div>
			</div>
		</div>
	</div>
</div>


<?php get_footer(); ?>
