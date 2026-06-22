<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

// TODO Change block CSS class `acf-custom-block` to yours for further styling
//

$courses_query = get_field('pod_list');
?>
<?php if( $courses_query ): ?>
    <section <?php echo starter_block_attributes( 'acf-custom-pod-slider', $block ); ?>>
        <?php foreach ($courses_query as $course ) :
            $image = $course['pod_image'];
            $title = $course['pod_title'];
            $description = $course['pod_description'];
            $link = $course['pod_link'];
            ?>
            <div class="pod-slider-wrap">
                <img alt="<?php echo $image['alt']?>" src="<?php echo $image['url'] ?>">
                <div class="overlay">
                    <h3><?php echo $title?></h3>
                    <p><?php echo $description?></p>

                    <?php
                    $svg = return_svg( get_template_directory_uri() . '/assets/images/arrow-button.svg', 'arrow-button' );
                    if( $link ):
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
                        <a class="outline-button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?><?php echo $svg; ?></a>
                    <?php endif; ?>

                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php
