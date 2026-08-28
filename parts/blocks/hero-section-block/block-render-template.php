<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
$description = get_field('hero_description');
$hero_title = get_field('hero_title');
$hero_button = get_field('hero_button');
?>
<section class="<?php echo starter_section_class( 'acf-hero-section-block', $block ); ?>">
    <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'full_hd', false, array( 'class' => '_wp_attachment_image_alt' ) ); ?>
    <div class="overlay">
        <h1><?php echo $hero_title; ?></h1>
        <p><?php echo $description; ?></p>

        <div class="is-layout-flex">
            <?php if($hero_button): ?>
                <a target="<?php echo $hero_button['target']?>" tabindex="0" href="<?php echo $hero_button['url']?>" class="outline-button"><?php echo $hero_button['title']; echo return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button');?></a>
            <?php endif; ?>

            <?php if( have_rows('additional_hero_buttons_repeater') ): ?>
                <?php while( have_rows('additional_hero_buttons_repeater') ): the_row(); ?>

                    <?php
                    $additional_button = get_sub_field('additional_hero_button');
                    ?>

                    <?php if ($additional_button) : ?>
                    <a
                        href="<?php echo esc_url($additional_button["url"]); ?>"
                        class="outline-button"
                        target="<?php echo esc_attr($additional_button["target"]); ?>"
                    >
                        <?php echo esc_html($additional_button["title"]); echo return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button');?>
                    </a>
                    <?php endif; ?>

                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>