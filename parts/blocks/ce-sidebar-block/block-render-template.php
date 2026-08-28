<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

$content = get_field('ce_sidebar_content', 'option');
?>

<div class="courses-content-right">
    <div class="ce-sidebar green-content">

        <?php if ($content) : ?>
            <?php echo wp_kses_post($content); ?>
        <?php endif; ?>

        <?php if( have_rows('ce_sidebar_repeater', 'option') ): ?>
            <?php while( have_rows('ce_sidebar_repeater', 'option') ): the_row(); ?>

                <?php
                $sidebar_button = get_sub_field('ce_sidebar_button','option');
                $sidebar_button_style = get_sub_field('ce_sidebar_button_style','option');
                $sidebar_button_class = ( $sidebar_button_style === 'primary_button' ) ? 'primary-button' : 'text-button';
                ?>

                <?php if ($sidebar_button) : ?>
                <a
                    href="<?php echo esc_url($sidebar_button["url"]); ?>"
                    class="<?php echo $sidebar_button_class ?>"
                    target="<?php echo esc_attr($sidebar_button["target"]); ?>"
                >
                    <?php echo esc_html($sidebar_button["title"]); ?>
                </a>
                <?php endif; ?>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</div>
