<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
?>
<div class="<?php echo starter_section_class( 'sbs-box', $block ); ?>">
	<?php show_template( 'side-by-side' ); ?>
</div>
	