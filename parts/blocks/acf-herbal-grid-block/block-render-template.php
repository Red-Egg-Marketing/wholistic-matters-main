<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
$arg = array(
    'post_type' => 'herbal_glosarry',
    'posts_per_page' => 10,

);

$arg_mob = array(
    'post_type' => 'herbal_glosarry',
    'posts_per_page' => 4,

);
$query = new WP_Query($arg);
$query_mob = new WP_Query($arg_mob);
?>

<?php if( $query ): ?>
    <section class="<?php echo starter_section_class( 'acf-herbal-grid-block', $block ); ?>">
        <?php foreach ($query->posts as $post ) : ?>
            <div class="grid-item-wrap">
                <img alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)?>" src="<?php echo get_attached_img_url($post->ID) ?>">
                <a href="<?php echo get_permalink( $post->ID ); ?>" class="overlay">
                    <p><?php echo $post->post_title?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<?php if( $query_mob ): ?>
    <section class="<?php echo starter_section_class( 'acf-herbal-grid-block mobile-block', $block ); ?>">
        <?php foreach ($query_mob->posts as $post ) : ?>
            <div class="grid-item-wrap">
                <img alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)?>" src="<?php echo get_attached_img_url($post->ID) ?>">
                <a href="<?php echo get_permalink( $post->ID ); ?>" class="overlay">
                    <p><?php echo $post->post_title?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>