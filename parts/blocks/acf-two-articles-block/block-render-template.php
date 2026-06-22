<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
?>

<?php if( have_rows('articles_list') ): ?>
    <section class="<?php echo starter_section_class( 'acf-two-articles-block', $block ); ?>">
        <?php while( have_rows('articles_list') ): the_row();
            $image = get_sub_field('image');
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            $link = get_sub_field('link');
            $taxonomy = get_sub_field('taxonomy');
            ?>
            <div class="acf-article-item-wrap">
                <?php if ($taxonomy->slug === 'hcp') : ?>
                    <div class="acf-article-item-image-wrap">
                        <img alt="<?php echo $image['alt'] ?>" src="<?php echo $image['url']?>">
                        <div class="overlay">
                            <span><?php echo return_svg(get_template_directory_uri().'/assets/images/categ-icon.svg', 'category-icon') ?>Practioner</span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="acf-article-item-image-wrap">
                        <img alt="<?php echo $image['alt'] ?>" src="<?php echo $image['url']?>">
                    </div>
                <?php endif; ?>
                <h2><?php echo $title?></h2>
                <?php echo $content?>
                <a target="<?php echo $link['target'] ?>" href="<?php echo $link['url'] ?>" class="outline-button"><?php echo $link['title'] . return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button')  ?></a>
            </div>
        <?php endwhile; ?>
    </section>
<?php endif; ?>