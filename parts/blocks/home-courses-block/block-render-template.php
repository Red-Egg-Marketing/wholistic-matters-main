<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

// TODO Change block CSS class `acf-custom-block` to yours for further styling
//

$courses_query = get_field('courses_list');
?>
<?php if( $courses_query ): ?>
    <section <?php echo starter_block_attributes( 'acf-custom-courses-slider', $block ); ?>>
        <?php foreach ($courses_query as $course ) :
            $image = $course['course_image'];
            $title = $course['course_title'];
            $description = $course['course_description'];
            $link = $course['course_link'];
            ?>
        <<?php if ($link): echo 'a href="' .$link.'"' ; else: echo 'div '; endif; ?>class="courses-slider-wrap">
            <img alt="<?php echo $image['alt']?>" src="<?php echo $image['url'] ?>">
            <div class="overlay">
                <h3><?php echo $title?></h3>
                <p><?php echo $description?></p>
            </div>
            <?php if ($link): echo '</a>' ; else: echo '</div>'; endif; ?>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php

