<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
?>

<?php if( have_rows('cards_list') ): ?>
    <section class="<?php echo starter_section_class( 'acf-cards-block', $block ); ?>">
        <?php while( have_rows('cards_list') ): the_row();
            $image = get_sub_field('image');
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            ?>
            <div class="acf-card-item-wrap" style="background-image: url(<?php echo $image['url']?>) ">
                <div class="acf-card-item">
                    <span><?php echo $title?></span>
                    <?php echo $content?>
                </div>
            </div>
        <?php endwhile; ?>
    </section>
<?php endif; ?>