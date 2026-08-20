<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

$content = get_field('ce_sidebar_content', 'option');
$button = get_field('ce_sidebar_button', 'option');

?>

<div class="courses-content-right">
    <div class="ce-sidebar green-content">

        <?php if ($content) : ?>
            <?php echo wp_kses_post($content); ?>
        <?php endif; ?>

        <?php if ($button) : ?>
            <a
                href="<?php echo esc_url($button["url"]); ?>"
                class="primary-button"
                target="<?php echo esc_attr($button["target"]); ?>"
            >
                <?php echo esc_html($button["title"]); ?>
            </a>
        <?php endif; ?>

    </div>
</div>
