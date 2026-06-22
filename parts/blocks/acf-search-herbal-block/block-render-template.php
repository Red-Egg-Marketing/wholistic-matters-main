<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

$args = array(
    'post_type' => 'herbal_glosarry',
    'posts_per_page' => 12,
);
$query = new WP_Query($args);

?>
<section class="<?php echo starter_section_class( 'acf-search-herbal-block', $block ); ?>">
    <?php if( $query->posts ): ?>
        <div class="header-search">
            <a id="header-search-icon"><?php echo return_svg(get_template_directory_uri().'/assets/images/search-icon.svg', 'search-icon') ?></a>
            <input id="herbal-search" placeholder="Search by herb, name, family, or use">
        </div>
        <a id="not-found" class="search-not-found">Nothing found, try with another word or phrase</a>
        <div class="herbal-list-wrap">
            <div class="herbal-list">
                <?php foreach ($query->posts as $post ) :
                    $alt = get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
                    $url = get_attached_img_url($post->ID);
                    get_template_part( 'parts/loop', 'grid', ['id' => $post->ID, 'title' => $post->post_title, 'alt' => $alt, 'url' => $url ]);
                ?>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <a id="load-more-search" class="load-more-button outline-button">Load More</a>
        </div>
    <?php endif; ?>
</section>
