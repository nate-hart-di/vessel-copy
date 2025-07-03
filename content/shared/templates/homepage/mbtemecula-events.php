<main class="container-wide contentcontainer events-archive">
	<div class="row">
		<section class="col-sm-12">
			<?php
   $args = [
     'post_type' => 'events',
     'posts_per_page' => '-1',
     'orderby' => 'menu_order',
     'order' => 'ASC',
   ];
   $post_query = new WP_Query($args);
   if ($post_query->have_posts()):

     while ($post_query->have_posts()):

       $post_query->the_post();
       $id = get_the_id();
       $date = get_post_meta($id, '_event_date', true);
       $end_date = get_post_meta($id, '_event_end_date', true);
       $time = get_post_meta($id, '_event_time', true);
       $address = get_post_meta($id, '_event_address', true);
       $location = get_post_meta($id, '_event_location', true);
       $location_link = get_post_meta($id, '_event_location_link', true);
       $new_date = date('D, M j, Y', strtotime($date));
       $new_end_date = date('D, M j, Y', strtotime($end_date));
       $terms = get_the_term_list($id, 'event_categories', 'Posted in: ', ', ');
       ?>

			<?php if (has_post_thumbnail()): ?>
			<article <?php post_class('events-entry with-thumbnail clearfix'); ?>>
			<?php else: ?>
			<article <?php post_class('events-entry clearfix'); ?>>
			<?php endif; ?>
				<?php if (has_post_thumbnail()): ?>
				<div class="post-thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
				<?php endif; ?>

				<div class="entry-details">
					<h2 class="entry-title">
						<a trid="d09cb7077d7249dab28394" trc href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h2>

					<div class="event-meta">
						<?php if (!empty($date) && $date == $end_date): ?>
						<span class="meta-item eventdate"><i class="fa fa-calendar"></i> <?php echo $new_date; ?></span>
						<?php elseif (!empty($date) && $date != $end_date): ?>
						<span class="meta-item eventdate"><i class="fa fa-calendar"></i> <?php echo $new_date . ' - ' . $new_end_date; ?></span>
						<?php endif; ?>

						<?php if (!empty($time)): ?>
						<span class="meta-item eventtime"><i class="fa fa-clock-o"></i> <?php echo $time; ?></span>
						<?php endif; ?>

						<?php if (!empty($location) && !empty($location_link)): ?>
						<a trid="b8fe5ba7a11b403585753e" trc href="<?php echo $location_link; ?>" target="_blank" class="meta-item">
							<span class="location"><i class="fa fa-map-marker"></i> <?php echo $location; ?></span>
						</a>
						<?php endif; ?>
					</div>

					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>

					<?php if (!empty($terms)): ?>
					<footer class="entry-categories">
						<span><?php echo $terms; ?></span>
					</footer>
					<?php endif; ?>
				</div>
			</article> <!-- end .post -->

			<?php
     endwhile;
     wp_reset_postdata();
     ?>
			
				<?php echo paginate_links(); ?>
			<?php
   else:
      ?>
				<p>Sorry, no events were found.</p>
			<?php
   endif;
   ?>
		</section>
	</div>
</main>