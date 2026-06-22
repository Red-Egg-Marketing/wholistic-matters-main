<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

// TODO Change block CSS class `acf-custom-block` to yours for further styling
//
$block_title = get_field('block_title');
$logo_title = get_field('logo_title');
$left_logo = get_field('left_logo');
$right_logo = get_field('right_logo');
$standard_process_content = get_field('standard_process_content');
$learn_more_about = get_field('learn_more_about');
$standard_gallery = get_field('standard_gallery');
?>
<section <?php echo starter_block_attributes( 'acf-custom-standard-process', $block ); ?>>
    <div class="top-section">
        <div class="standard-process-content-block">
            <?php if ($block_title): ?><h2><?php echo $block_title;?></h2><?php endif; ?>
            <?php if ($left_logo || $right_logo) : ?>
                <div class="standard-process-logos">
                    <img alt="<?php echo $left_logo['alt']?>" src="<?php echo $left_logo['url'] ?>">
                    <?php if ($right_logo): display_svg(get_template_directory_uri().'/assets/images/symbol-&.svg', 'arrow-button'); endif; ?>
<!--                    --><?php //if ($right_logo): display_svg($right_logo['url'], 'right-logo', 'hd_full'); endif; ?>
                    <img class="right-logo" alt="<?php echo $right_logo['alt']?>" src="<?php echo $right_logo['url'] ?>">
                </div>
            <?php endif; ?>
            <?php echo $standard_process_content; ?>
            <?php if ($learn_more_about): ?>
            <div class="load-more-wrap">
                <a target="<?php echo $learn_more_about['target']; ?>" href="<?php echo $learn_more_about['url']; ?>"><?php echo $learn_more_about['title']; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button')?></a>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($standard_gallery): ?>
            <?php if (count($standard_gallery) === 1): ?>
                <div class="standard-process-gallery">
                    <img class="gallery-single-image" alt="<?php echo $standard_gallery[0]['alt']?>" src="<?php echo $standard_gallery[0]['url']?>">
                </div>
            <?php else: ?>
                <div class="standard-process-gallery">
                    <img class="gallery-main" alt="<?php echo $standard_gallery[0]['alt']?>" src="<?php echo $standard_gallery[0]['url']?>">
                    <div class="gallery-group">
                        <img alt="<?php echo $standard_gallery[1]['alt']?>" src="<?php echo $standard_gallery[1]['url']?>">
                        <img alt="<?php echo $standard_gallery[2]['alt']?>" src="<?php echo $standard_gallery[2]['url']?>">
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
        <?php if ($logo_title): ?><h2 class="logos-section-title"><?php echo $logo_title;?></h2> <?php endif; ?>
        <?php if( have_rows('logos_list') ): ?>
            <div class="logos-section desktop-logo">
                <?php while( have_rows('logos_list') ): the_row();
                    $image = get_sub_field('logo_image');
                    $title = get_sub_field('logo_title');
                    ?>
                    <div class="logo-item">
                        <?php display_svg($image, 'logo-image'); ?>
                        <span><?php echo $title ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    <?php if( have_rows('logos_mobile_list') ): ?>
            <div class="logos-section mobile-logo">
                <?php while( have_rows('logos_mobile_list') ): the_row();
                    $image = get_sub_field('logo_image');
                    $title = get_sub_field('logo_title');
                    ?>
                    <div class="logo-item">
                        <?php display_svg($image, 'logo-image'); ?>
                        <span><?php echo $title ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
</section>