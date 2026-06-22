<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */

// TODO Change block CSS class `acf-custom-block` to yours for further styling
//
$title_featured_articles = get_field('title_featured_articles');
?>
<?php if( have_rows('featured_blocks') ): ?>
    <section <?php echo starter_block_attributes( 'acf-custom-featured-block', $block ); ?>>
        <?php while( have_rows('featured_blocks') ): the_row();
            $choose_audiences = get_sub_field('audience');

 
            $all_articles = new WP_Query(array(
                'post_type'  => 'article',
                'posts_per_page' => -1, 
                'orderby' => 'date', 
                'order' => 'DESC', 
                'tax_query' => array(
                    array(
                        'taxonomy' => 'audience',
                        'field' => 'id',
                        'terms' => $choose_audiences,
                    ),
                ),
            ));

           
            $selected_articles = [];
            $unique_categories = [];

            if ( $all_articles->have_posts() ) {
                while ( $all_articles->have_posts() ) {
				
                    $all_articles->the_post();

                    $primary_category_id = intval(get_post_meta(get_the_ID(), '_yoast_wpseo_primary_article-category', true));

                    if ( $primary_category_id && !in_array($primary_category_id, $unique_categories) ) {
                        $unique_categories[] = $primary_category_id;
                        $selected_articles[] = get_the_ID();
                    }

                    if ( count($selected_articles) >= 3 ) {
                        break;
                    }
                }
                wp_reset_postdata();
            }

            $pages = new WP_Query(array(
                'post_type'  => 'page',
				'posts_per_page' => 1, 
                'tax_query' => array(
                    array(
                        'taxonomy' => 'audience',
                        'field' => 'id',
                        'terms' => $choose_audiences,
                    ),
                ),
            ));
            ?>
        <div class="featured-block-wrap">
                <?php if( $pages->posts ): ?>
                    <div class="featured-left-block">
                        <?php foreach( $pages->posts as $featured_post ):
                            $permalink = get_permalink( $featured_post->ID );
                            $title = get_the_title( $featured_post->ID );
                            $hero_title = get_field('hero_title', $featured_post->ID);
                            $name_button = get_sub_field('name_button');
                            ?>
                        <img alt="<?php echo get_post_meta( get_post_thumbnail_id($featured_post->ID), '_wp_attachment_image_alt', true)?>" src="<?php echo get_attached_img_url($featured_post->ID) ?>">
                            <div class="overlay">
                                <h2><?php echo $title; ?></h2>
                                <a href="<?php echo esc_url( $permalink ); ?>" class="outline-button"><?php echo $name_button; echo return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if( !empty($selected_articles) ): ?>
                    <div class="featured-right-block">
                        <p class="featured-right-block-title"><?php echo $title_featured_articles; ?></p>
                        <?php foreach( $selected_articles as $article_id ):
                            $permalink = get_permalink( $article_id );
                            $title = get_the_title( $article_id );
                            ?>
                            <?php get_template_part( 'parts/loop', 'featured-articles', ['id' => $article_id, 'author' => get_post_field('post_author', $article_id)] ); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </section>
<?php endif; ?>
