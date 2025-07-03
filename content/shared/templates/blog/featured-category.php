<?php
//  sets up arguments for the get_categories. featured_category is an ACF true/false in each category
$args = [
  'meta_key' => 'featured_category',
  'meta_value' => true,
];

$categories = get_categories($args);
?>
<div class="featuredBlogRow">
    <div class="container-wide">

        <h2><?php echo get_field('blog_row_title'); ?></h2>
        <div class="featuredCats hidden-xs">
            <div class="featuredCats__wrapper">
                <div class="hidden-xs">
                    <a trid="89751b0d409249c9b5c6a6" trc class="featuredCategory <?php
//echo $this->is_active('blog');
?> " href="/blog/" alt="View all posts">Home</a>
                    <?php foreach ($categories as $category) {
                      $category_link = sprintf(
                        '<a trid="d11ecc2273e841ecbfabad" trc class="featuredCategory" href="%1$s">%2$s</a>',
                        esc_url(get_category_link($category->term_id)),
                        esc_html($category->name),
                      );

                      echo $category_link;
                    } ?>
                </div>
                <div class="visible-xs">
                    <select class="featuredCats__select" name="categories" onChange="document.location.href = this.value">
                        <option>--Select--</option>
                        <option class="featuredCategory" value="/blog/">Home</option>
                        <?php foreach ($categories as $category) {
                          $category_option = sprintf(
                            '<option class="featuredCategory" value="%1$s" >%2$s</option>',
                            esc_url(get_category_link($category->term_id)),
                            esc_html($category->name),
                          );
                          echo $category_option;
                        } ?>

                    </select>
                </div>
            </div>
        </div>

        <?php
// featured categories as a dropdown, used on mobile only
?>
        <div class="featuredCats visible-xs">
            <div class="featuredCats__wrapper">

            </div>
        </div>
        <div class="featured-carousel owl-carousel owl-theme">

            <?php
            // greates an own carousel of featured blog posts
            // pulls the all blog posts with the featured blog post acf set to true, 10 per page
            $cc_args = [
              'posts_per_page' => 10,
              'post_type' => 'post',
              'meta_key' => 'featured_blog_post',
              'meta_value' => true,
            ];
            $posts = get_posts($cc_args);
            foreach ($posts as $post):

              $image = get_field('carousel_image', $post->ID);
              //var_dump($image);
              $title_link = get_permalink($post->ID);
              $title = $post->post_title;
              $CTA_link = get_permalink($post->ID);
              ?>
                    <div class="item featuredImage" style="background-image:url(' <?php echo $image['url']; ?> ');" > 
                        <div class="featuredContent" >
                            <h3 class='title'>
                                <a trid="e690c4ab1c7c46b69dbfcc" trc class="" href="<?php echo $CTA_link; ?>"><?php echo $title; ?></a>
                            </h3>
                            <span class='cta'>
                                <a trid="32611431cad9480b97e5a4" trc class="button cta-button" href="<?php echo $CTA_link; ?>" >Read More</a>
                            </span>
                        </div>
                    </div>
                <?php
            endforeach;
            ?>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function($) {
    $('.featured-carousel').owlCarousel({
      loop:true,
      margin:10,
      navigation:true,
      navigationText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
      items: 4,
      itemsDesktop: [1200,3],
      itemsDesktopSmall: [1024,2],
      itemsTablet: [767,1],
    });
});
</script>

