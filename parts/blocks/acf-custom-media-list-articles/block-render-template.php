<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */


$format = get_field('type_of_media');
$posts_per_page = 10;
$arg = array(
    'post_type' => 'article',
    'order' => 'DESC',
    'posts_per_page' => $posts_per_page
 );
$arg_ll_mob = array(
    'post_type' => 'article',
    'order' => 'DESC',
    'posts_per_page' => 6,
);

if ($format) {
    $arg['tax_query'][] = array(
        'taxonomy' => 'format',
        'field' => 'id',
        'terms' => $format->term_id,
    );
    $arg_ll_mob['tax_query'][] = array(
        'taxonomy' => 'format',
        'field' => 'id',
        'terms' => $format->term_id,
    );
}

$query = new WP_Query($arg);
$query_mob = new WP_Query($arg_ll_mob);
$title = get_field('title');
$terms = get_terms( array(
    'taxonomy'   => 'format',
    'hide_empty' => false,
) );

$term_custom = new stdClass();
$term_custom->taxonomy = '';
$term_custom->term_id = '';
$term_custom->slug = '';
$term_custom->name = 'All Media';

array_unshift($terms, $term_custom);
?>


<?php if( $query->posts ): ?>
    <section class="<?php echo starter_section_class( 'acf-custom-media-list-articles', $block ); ?>">
        <?php if (!$format) : ?>
            <div class="media-filter-section">
                <button type="button" id="filter-media-button" class="filter-button" aria-haspopup="true" aria-expanded="false"><span>All Media</span><?php display_svg(get_template_directory_uri().'/assets/images/arrow-down.svg', 'arrow-down-icon') ?></button>
                <div class="sub-media-list">
                    <?php foreach ($terms as $term ) : ?>
                        <button type="button" class="sub-media-item chose-item"><?php echo $term->name?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="media-list-articles">
            <?php foreach ($query->posts as $post ) :
                get_template_part( 'parts/loop', 'media-article', ['post' => $post ]  ); ?>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <?php if ($query->found_posts > $posts_per_page): ?><button type="button" id="load-more-media" data-post-type="<?php if ($format->slug): echo $format->slug; else: echo ''; endif;?>" data-tax="format" data-posts_per_page="<?php echo $posts_per_page; ?>" class="outline-button">Load More</button><?php endif; ?>
    </section>
<?php endif; ?>

<?php if( $query_mob->posts ): ?>
    <section class="<?php echo starter_section_class( 'acf-custom-media-list-articles mobile-block', $block ); ?>">
        <?php if (!$format) : ?>
            <div class="media-filter-section">
                <button type="button" id="filter-media-button" class="filter-button" aria-haspopup="true" aria-expanded="false"><span>All Media</span><?php display_svg(get_template_directory_uri().'/assets/images/arrow-down.svg', 'arrow-down-icon') ?></button>
                <div class="sub-media-list">
                    <?php foreach ($terms as $term ) : ?>
                        <button type="button" class="sub-media-item chose-item"><?php echo $term->name?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="media-list-articles">
            <?php foreach ($query_mob->posts as $post ) :
                get_template_part( 'parts/loop', 'media-article', ['post' => $post ]  ); ?>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <?php if ($query->found_posts > $posts_per_page): ?><button type="button" id="load-more-media-mob" data-post-type="<?php if ($format->slug): echo $format->slug; else: echo ''; endif;?>" data-tax="format" data-posts_per_page="<?php echo $posts_per_page; ?>" class="outline-button">Load More</button><?php endif; ?>
    </section>
<?php endif; ?>