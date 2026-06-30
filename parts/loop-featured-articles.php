<!-- BEGIN of Post -->
<?php
/**
 * @var array $args arguments.
 */
$term_format = get_the_terms($args['id'], 'format');
$term_audience = get_the_terms($args['id'], 'audience');
$labels = get_the_terms($args['id'], 'article-category');
$time = get_field('minutes_to', $args['id']);
$term_cat = [];
foreach ($labels as $label) {
    if (intval(get_post_meta($args['id'], '_yoast_wpseo_primary_article-category',true)) === $label->term_id) {
        array_unshift($term_cat, $label);
    } else {
        $term_cat[] = $label;
    }
}

?>
<article id="post-<?php echo $args['id']; ?>" <?php post_class( 'preview preview--' . get_post_type() ); ?>>
	<div class="grid-x align-justify">
		<div class="cell auto">
            <div class="post-info-block">
                <b><?php echo get_the_author_meta('display_name', $args['author']); ?></b>
                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                <?php if (is_front_page()) : ?>
                    <span class="name-format"><?php echo $term_format[0]->name?></span>
                    <span class="home-format"><i><?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?></i></span>
                    <span class="home-mobile-format"><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                <?php else:?>
                    <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                <?php endif; ?>
            </div>

            <h3 class="preview__title">
				<a href="<?php echo get_permalink($args['id'])?>"><?php echo get_the_title($args['id']) ?: __( 'No title', 'default' ); ?></a>
			</h3>
            <div class="post-practitioner-category">
                <?php if (is_front_page()) : ?>
                    <?php if($term_audience[0]->slug === 'hcp') : ?><span><?php echo return_svg(get_template_directory_uri().'/assets/images/categ-icon.svg', 'category-icon') ?><?php echo $term_audience[0]->name?></span><?php endif; ?>
                <?php else:?>
                    <?php if($term_audience[0]->slug === 'hcp') : ?><span class="without-text"><?php echo return_svg(get_template_directory_uri().'/assets/images/categ-icon.svg', 'category-icon') ?></span><?php endif; ?>
                <?php endif; ?>
                <?php foreach( $term_cat as $index => $label ):
                    $args_query = array(
                        'post_type' => 'article',
                        'order' => 'DESC',
                        'posts_per_page' => 10,
                        'meta_query'     => array(
                            array(
                                'key'     => '_yoast_wpseo_primary_article-category',
                                'value'   => (string)$label->term_id,
                                'compare' => '='
                            ),
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => $label->taxonomy,
                                'field' => 'id',
                                'terms' => $label->term_id,
                            ),
                        ),
                    );
                    $query_posts = new WP_Query( $args_query );
                    ?>
                    <?php if (count($query_posts->posts) > 3): ?>
                    <a href="<?php echo get_category_link($label->term_id).'?id='.$term_audience[0]->slug?>"><span class="<?php if ($index === 0): echo 'post-category'; else: echo 'post-category-second'; endif; ?>"> <?php echo $label->name; ?></span></a>
                <?php else: ?>
                    <span class="post-category not-allow"> <?php echo $label->name; ?></span>
                <?php endif;?>
                <?php endforeach; ?>
            </div>
		</div>
        <div class="medium-3 small-4 cell text-right medium-text-right image-wrap">
            <a class="overlay" href="<?php echo get_permalink($args['id'])?>" tabindex="-1" aria-hidden="true"></a>
            <img class="post-image <?php if(!get_attached_img_url($args['id'])) : echo 'placeholder-img'; endif; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id($args['id']), '_wp_attachment_image_alt', true)?>" src="<?php if(get_attached_img_url($args['id'])) :  echo get_attached_img_url($args['id']); else: echo get_template_directory_uri().'/assets/images/placeholder.jpg'; endif;?>">
        </div>
	</div>
</article>
<!-- END of Post -->