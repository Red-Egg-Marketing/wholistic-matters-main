<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
$post = get_queried_object();
$post_audience = get_the_terms($post->ID, 'audience');
$grid_categories = get_field('grid_categories');

$mob_category = array_slice($grid_categories, 0, 6);
?>

<?php if( have_rows('grid_categories') ): ?>
        <section class="<?php echo starter_section_class( 'acf-grid-categories-block', $block ); ?>">
            <div class="grid-item-wrap">
            <?php while( have_rows('grid_categories') ): the_row();
                $term = get_sub_field('category');
                $image = get_field('category_image', 'article-category_' . $term->term_id);
                $args = array(
                    'post_type' => 'article',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
//                    'meta_query'     => array(
//                       array(
//                           'key'     => '_yoast_wpseo_primary_article-category',
//                           'value'   => (string)$term->term_id,
//                           'compare' => '='
//                       ),
//                    ),
                    'tax_query'              => array(
                        array(
                            'taxonomy' => 'article-category',
                            'field' => 'id',
                            'terms' => $term->term_id,

                        ),
                        array(
                            'taxonomy' => 'audience',
                            'field' => 'slug',
                            'terms' => $post_audience[0]->slug,
                        ),
                    ),
                );
                $query = new WP_Query( $args );
            ?>
            <?php if (count($query->posts) > 2): ?>
                <div class="grid-item">
                    <img alt="<?php echo $image['alt']?>" src="<?php if(!$image['url']) : echo get_template_directory_uri().'/assets/images/placeholder.svg'; else: echo $image['url']; endif; ?>">
                    <a href="<?php echo get_term_link( $term->term_id, 'article-category' ).'?id='. $post_audience[0]->slug?>" class="overlay">
                        <p><?php echo $term->name ?></p>
                        <?php display_svg(get_template_directory_uri().'/assets/images/circle-arrow.svg', 'arrow-button') ?>
                    </a>
                </div>
                <?php endif;?>
            <?php endwhile; ?>
            </div>
        </section>
<?php endif; ?>

<?php if( $mob_category ): ?>
        <section class="<?php echo starter_section_class( 'acf-grid-categories-block mobile-block ', $block ); ?>">
            <div class="grid-item-wrap">
            <?php foreach( $mob_category as $category ):
                $image = get_field('category_image', 'article-category_' . $category['category']->term_id);
                $args = array(
                    'post_type' => 'article',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'tax_query'              => array(
                        array(
                            'taxonomy' => 'article-category',
                            'field' => 'id',
                            'terms' => $category['category']->term_id,

                        ),
                        array(
                            'taxonomy' => 'audience',
                            'field' => 'slug',
                            'terms' => $post_audience[0]->slug,
                        ),
                    ),
                );
                $query = new WP_Query( $args );
            ?>
                <?php if (count($query->posts) > 2): ?>
                <div class="grid-item">
                    <img alt="<?php echo $image['alt']?>" src="<?php if(!$image['url']) : echo get_template_directory_uri().'/assets/images/placeholder.jpg'; else: echo $image['url']; endif; ?>">
                    <a href="<?php echo get_term_link( $category['category']->term_id, 'article-category' ).'?id='. $post_audience[0]->slug?>" class="overlay">
                        <p><?php echo $category['category']->name ?></p>
                        <?php display_svg(get_template_directory_uri().'/assets/images/circle-arrow.svg', 'arrow-button') ?>
                    </a>
                </div>
                <?php endif;?>
            <?php endforeach;?>
            </div>
            <button type="button" id="load-more-grid" class="load-more-button outline-button">Load More</button>
        </section>
<?php endif; ?>