<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

// TODO Change block CSS class `acf-custom-block` to yours for further styling
//
$subscribe_block_image = get_field('subscribe_block_image', 'option');
$subscribe_block_title = get_field('subscribe_block_title', 'option');
$subscribe_block_subtitle = get_field('subscribe_block_subtitle', 'option');

?>
<section <?php echo starter_block_attributes( 'acf-custom-subscribe-form-process', $block ); ?>>
    <img alt="<?php echo $subscribe_block_image['alt']?>" src="<?php echo $subscribe_block_image['url']?>">
    <div class="subscribe-content">
        <h2><?php echo $subscribe_block_title; ?></h2>
        <p><?php echo $subscribe_block_subtitle; ?></p>
        <div id="<?php if(is_page('contact-us')): echo 'hs-contact-newsletter-form'; elseif (is_page('about')) : echo 'hs-about-newsletter-form'; else: echo 'hs-home-newsletter-form'; endif;?>" class="newsletter-form"></div>
    </div>
</section>