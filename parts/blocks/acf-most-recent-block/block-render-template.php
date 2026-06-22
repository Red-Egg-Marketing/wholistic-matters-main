<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

$post_not_in = $GLOBALS['post_not_in'];
$choose_audiences = get_field('audience');
$format = get_field('format');

$arg = array(
    'post_type' => 'article',
    'posts_per_page' => 10,
    'order' => 'DESC',
 );

if ($post_not_in) {
    $arg[] = array(
        'post__not_in' => $post_not_in,
    );
}

if ($format) {
    $arg['tax_query'][] = array(
        'taxonomy' => 'format',
        'field' => 'id',
        'terms' => $format,
    );
}

if ($choose_audiences) {
    $arg['tax_query'][] = array(
        'taxonomy' => 'audience',
        'field' => 'id',
        'terms' => $choose_audiences,
    );
}

$query = new WP_Query($arg);
$title = get_field('title');
?>

<?php if( $query->posts ): ?>
    <section class="<?php echo starter_section_class( 'acf-most-recent-block', $block ); ?>">
        <span class="articles-slider-title"><?php echo $title; ?></span>
        <div class="most-recent-slider articles-slider">
            <?php foreach ($query->posts as $post ) :
                $time = get_field('minutes_to', $post->ID);
                $term_format = get_the_terms($post->ID, 'format');
                $term_audience = get_the_terms($post->ID, 'audience');
                $labels = get_the_terms($post->ID, 'article-category');
                $article_excerpt = get_field('article_excerpt', $post->ID);
                $term_cat = '';
                $term_cat_id = '';
                foreach ($labels as $label) {
                    if (intval(get_post_meta($post->ID, '_yoast_wpseo_primary_article-category',true)) === $label->term_id) {
                        $term_cat = $label->name;
                        $term_cat_id = $label->term_id;
                    }
                }
            ?>

            <div class="article-item">
                <div class="post-practitioner-category">
                    <?php if($term_audience[0]->slug === 'hcp') : ?><span><?php echo return_svg(get_template_directory_uri().'/assets/images/categ-icon.svg', 'category-icon') ?></span><?php endif; ?>
                    <?php if ($term_cat) :
                        $args_query = array(
                            'post_type' => 'article',
                            'order' => 'DESC',
                            'posts_per_page' => 10,
                            'meta_query'     => array(
                                array(
                                    'key'     => '_yoast_wpseo_primary_article-category',
                                    'value'   => (string)$term_cat_id,
                                    'compare' => '='
                                ),
                            ),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'article-category',
                                    'field' => 'id',
                                    'terms' => $term_cat_id,
                                ),
                            ),
                        );
                        $query_posts = new WP_Query( $args_query );
                        ?>
                        <?php if (count($query_posts->posts) > 3): ?>
                            <a href="<?php echo get_category_link($term_cat_id).'?id='. $term_audience[0]->slug ?>"><span class="post-category"><?php echo $term_cat; ?></span></a>
                        <?php else: ?>
                            <span class="post-category not-allow"> <?php echo $term_cat; ?></span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <a class="article-title" href="<?php echo get_permalink($post->ID)?>"><?php echo wp_strip_all_tags($post->post_title) ?></a>
                <div class="post-info-block">
                    <b><?php echo get_the_author_meta('display_name', $post->post_author); ?></b>
                    <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                    <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                </div>
                <div class="post-content">
                    <?php if (empty($article_excerpt)) : echo wp_strip_all_tags(get_the_content(null, true, $post->ID)); else: echo $article_excerpt; endif;?>
                </div>
                <div class="article-item-image-wrap">
                    <a class="overlay" href="<?php echo get_permalink($post->ID)?>"></a>
                    <img alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)?>" class="<?php if(!get_attached_img_url($post->ID)) : echo 'placeholder-img'; endif; ?>" src="<?php if(get_attached_img_url($post->ID)): echo get_attached_img_url($post->ID); else: echo get_template_directory_uri().'/assets/images/placeholder.svg';endif; ?>">
                </div>
<!--                --><?php //if (!$choose_audiences) : ?>
                    <a class="article-button" href="<?php echo get_permalink($post->ID)?>"><?php if ($term_format[0]->slug === 'video') : echo 'Watch video'; elseif ( $term_format[0]->slug === 'podcast'): echo 'Listen to Podcast'; else: echo 'Read Article'; endif; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></a>
<!--                --><?php //endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>