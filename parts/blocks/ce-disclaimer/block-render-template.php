<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

$content_left_column = get_field('ce_sidebar_content_left_column', 'option');
$content_right_column = get_field('ce_sidebar_content_right_column', 'option');

?>

<div class="ce-disclaimer wp-block-columns courses-text-block has-background is-layout-flex wp-container-core-columns-is-layout-e0d10880 wp-block-columns-is-layout-flex">

    <?php if ($content_left_column) : ?>
    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
        <?php echo wp_kses_post($content_left_column); ?>
    </div>
    <?php endif; ?>

    <?php if ($content_right_column) : ?>
    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
        <?php echo wp_kses_post($content_right_column); ?>
    </div>
    <?php endif; ?>

</div>