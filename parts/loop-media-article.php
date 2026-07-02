<?php

/**
 * @var array $args arguments.
 *
 */
$term_link = get_term_link( $args['id'], 'article-category' );
$post = $args['post'];
$time = get_field('minutes_to', $post->ID);
$term_format = get_the_terms($post->ID, 'format');
$term_audience = get_the_terms($post->ID, 'audience');
$labels = get_the_terms($post->ID, 'article-category');
$primary_category_id = get_post_meta($post->ID, '_yoast_wpseo_primary_article-category', true);
$term_cat = [];

foreach ($labels as $label) {
    if (intval($primary_category_id) === $label->term_id) {
        array_unshift($term_cat, $label);
    } else {
        $term_cat[] = $label;
    }
}
?>
<!-- BEGIN of Post -->
<div class="media-article-item">
    <div class="media-article-item-content-wrap">
        <div class="media-article-item-content">
            <div class="post-info-block">
                <b><?php echo get_the_author_meta('display_name', $post->post_author); ?></b>
                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
            </div>
            <a class="media-link" href="<?php echo get_permalink($args['id'])?>"><span><?php echo $post->post_title?></span></a>
        </div>
        <div class="image-wrap">
            <a class="overlay" href="<?php echo get_permalink($args['id'])?>" tabindex="-1" aria-hidden="true"></a>
            <img alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)?>" class="<?php if(!get_attached_img_url($post->ID)) : echo 'placeholder-img'; endif; ?>" src="<?php if(get_attached_img_url($post->ID)): echo get_attached_img_url($post->ID); else: echo get_template_directory_uri().'/assets/images/placeholder.svg'; endif;?>">
        </div>
    </div>
    <div class="media-article-item-categories">
        <?php if($term_audience[0]->slug === 'hcp') : ?><div class="media-link"><span class="post-category-audience"><?php echo return_svg(get_template_directory_uri().'/assets/images/categ-icon.svg', 'category-icon') ?></span></div><?php endif; ?>
        <?php if (get_category_link($term_cat[0]->term_id)) : ?><?php
            $args_query = array(
                'post_type' => 'article',
                'order' => 'DESC',
                'posts_per_page' => 10,
                'meta_query'     => array(
                    array(
                        'key'     => '_yoast_wpseo_primary_article-category',
                        'value'   => (string)$term_cat[0]->term_id,
                        'compare' => '='
                    ),
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'article-category',
                        'field' => 'id',
                        'terms' => $term_cat[0]->term_id,
                    ),
                ),
            );
            $query_posts = new WP_Query( $args_query );
            ?>
            <?php if (count($query_posts->posts) > 3): ?>
                <a class="media-link" href="<?php echo get_category_link($term_cat[0]->term_id).'?id='.$term_audience[0]->slug?>"><span class="post-category-first"><?php echo $term_cat[0]->name; ?></span></a>
            <?php else: ?>
                <span class="media-link not-allow"><span class="post-category-first not-allow"><?php echo $term_cat[0]->name; ?></span></span>
            <?php endif; ?>
         <?php endif; ?>

        <?php if (get_category_link($term_cat[1]->term_id)) :
            $args_query = array(
                'post_type' => 'article',
                'order' => 'DESC',
                'posts_per_page' => 10,
                'meta_query'     => array(
                    array(
                        'key'     => '_yoast_wpseo_primary_article-category',
                        'value'   => (string)$term_cat[1]->term_id,
                        'compare' => '='
                    ),
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'article-category',
                        'field' => 'id',
                        'terms' => $term_cat[1]->term_id,
                    ),
                ),
            );
            $query_posts = new WP_Query( $args_query );
            ?>
            <?php if (count($query_posts->posts) > 3): ?>
            <a class="media-link" href="<?php echo get_category_link($term_cat[1]->term_id).'?id='.$term_audience[0]->slug ?>"><span class="post-category-second"><?php echo $term_cat[1]->name; ?></span></a>
        <?php else: ?>
            <span class="media-link not-allow"><span class="post-category-second not-allow"><?php echo $term_cat[1]->name; ?></span></span>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<!-- END of Post -->