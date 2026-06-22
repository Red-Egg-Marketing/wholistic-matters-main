<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
?>
<?php

if (!function_exists('get_field')) return;

$featured_articles = get_field('featured');

if ($featured_articles): ?>
<div class="acf-featured-links-block">
    <ul class="featured-links-list">
        <?php foreach ($featured_articles as $featured_article): ?>
            <li class="featured-link-item">
                <a href="<?php echo get_permalink($featured_article->ID); ?>" class="featured-link">
                    <?php echo esc_html(get_the_title($featured_article->ID)); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php else: ?>
<p>No featured articles selected.</p>
<?php endif; ?>