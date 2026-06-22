<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

// Get the title for featured articles
$title_featured_articles = get_field('title_featured_articles');
?>

<?php if (have_rows('featured_blocks')): ?>
    <section <?php echo starter_block_attributes('acf-custom-featured-block', $block); ?>>
        <?php while (have_rows('featured_blocks')): the_row();
            $choose_audiences = get_sub_field('audience'); // Taxonomy term IDs
            $name_button = get_sub_field('name_button'); // Button text
            $selected_articles = get_sub_field('selected_articles'); // Array of selected article IDs

            // Query for a single page with the selected audience
            $pages = new WP_Query(array(
                'post_type' => 'page',
                'posts_per_page' => 1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'audience',
                        'field' => 'id',
                        'terms' => $choose_audiences,
                    ),
                ),
            ));
        ?>
        <div class="featured-block-wrap">
            <?php if ($pages->posts): ?>
                <div class="featured-left-block">
                    <?php foreach ($pages->posts as $featured_post):
                        $permalink = get_permalink($featured_post->ID);
                        $title = get_the_title($featured_post->ID);
                        $hero_title = get_field('hero_title', $featured_post->ID);
                        ?>
                        <img alt="<?php echo esc_attr(get_post_meta(get_post_thumbnail_id($featured_post->ID), '_wp_attachment_image_alt', true)); ?>" 
                             src="<?php echo esc_url(get_attached_img_url($featured_post->ID)); ?>">
                        <div class="overlay">
                            <h2><?php echo esc_html($title); ?></h2>
                            <a href="<?php echo esc_url($permalink); ?>" class="outline-button">
                                <?php echo esc_html($name_button); ?>
                                <?php echo return_svg(get_template_directory_uri() . '/assets/images/arrow-button.svg', 'arrow-button'); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($selected_articles)): ?>
                <div class="featured-right-block">
                    <p class="featured-right-block-title"><?php echo esc_html($title_featured_articles); ?></p>
                    <?php foreach ($selected_articles as $article_id):
                        $permalink = get_permalink($article_id);
                        $title = get_the_title($article_id);
                        ?>
                        <?php get_template_part('parts/loop', 'featured-articles', ['id' => $article_id, 'author' => get_post_field('post_author', $article_id)]); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </section>
<?php endif; ?>