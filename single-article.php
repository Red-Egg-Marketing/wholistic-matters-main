<?php
/**
 * Single
 *
 * Loop container for single post content
 */

$post = get_queried_object();
$term_format = get_the_terms($post->ID, 'format');
$term_audience = get_the_terms($post->ID, 'audience');
$labels = get_the_terms($post->ID, 'article-category');
$video_file = get_field('video_file', $post->ID);
$podcast = get_field('podcast', $post->ID);
$pdf_file = get_field('pdf_file', $post->ID);

$time = get_field('minutes_to', $post->ID);
$custom_author_info = get_field('custom_author_info', $post->ID);
$date = get_the_date('F j, Y', $post->ID);
$subscribe_block_image = get_field('subscribe_block_image', $post->ID);
$subscribe_block_title = get_field('subscribe_block_title', $post->ID);
$subscribe_block_subtitle = get_field('subscribe_block_subtitle', $post->ID);
$subscribe_block_image_option = get_field('subscribe_block_image', 'option');
$subscribe_block_title_option = get_field('subscribe_block_title', 'option');
$subscribe_block_subtitle_option = get_field('subscribe_block_subtitle', 'option');
$term_cat = [];
$term_cat_name = [];

foreach ($labels as $label) {
    if (intval(get_post_meta($post->ID, '_yoast_wpseo_primary_article-category', true)) === $label->term_id) {
        array_unshift($term_cat, $label);
    } else {
        $term_cat[] = $label;
    }
}

foreach ($labels as $label) {
    $term_cat_name[] = $label->slug;
}

$args_related = array(
        'post_type' => 'article',
        'order' => 'DESC',
        'posts_per_page' => 3,
        'post__not_in' => array($post->ID),
        'tax_query' => array(
                'relation' => 'and',
                array(
                        'taxonomy' => 'article-category',
                        'field' => 'slug',
                        'terms' => $term_cat_name,
                ),
                array(
                        'taxonomy' => 'audience',
                        'field' => 'slug',
                        'terms' => $term_audience[0]->slug,
                ),
        ),
);

$args_author = array(
        'post_type' => 'article',
        'order' => 'DESC',
        'posts_per_page' => 3,
        'post__not_in' => array($post->ID),
        'author' => $post->post_author

);

$query_related = new WP_Query($args_related);
$query_author = new WP_Query($args_author);
get_header(); ?>
    <main class="main-content single">
        <section class="acf-hero-section-block ">
            <?php if ($video_file): echo getYouTubeEmbedCode($video_file);
            elseif (wp_get_attachment_image(get_post_thumbnail_id(), 'full_hd', false, array('class' => '_wp_attachment_image_alt'))): echo wp_get_attachment_image(get_post_thumbnail_id(), 'full_hd', false, array('class' => '_wp_attachment_image_alt'));
            else: ?>
                <img class="post-image placeholder-img" alt="placeholder"
                     src="<?php echo get_template_directory_uri() . '/assets/images/placeholder.svg' ?>">
            <?php endif; ?>

            <?php if (has_term(12, 'format', get_the_ID())) : ?>
                <div class="overlay">
                    <!--<h1>WholisticMatters Podcast</h1>-->
                    <div class="img-logo">
                        <img src="https://wholisticmatters.com/wp-content/uploads/2025/11/podcast_logo_white_yellow-1.png" alt="Wholistic Matters Podcast">
                    </div>
                </div>
            <?php endif; ?>

        </section>
        <div class="single-content-wrap">
            <!-- BEGIN of post content -->
            <div class="single-article-content-left">
                <?php if (have_rows('navigation')): ?>
                    <div class="navigation-wrap">
                        <h3 id="navigation-title" class="sidebar-navigation-title">ARTICLE
                            OUTLINE <?php display_svg(get_template_directory_uri() . '/assets/images/arrow-top.svg', 'arrow-top-icon') ?></h3>
                        <ul class="navigation-list toggle">
                            <?php while (have_rows('navigation')): the_row();
                                $navigation_title = get_sub_field('navigation_title');
                                $navigation_href = get_sub_field('navigation_href');
                                ?>
                                <li>
                                    <a href="#<?php echo $navigation_href; ?>"><?php display_svg(get_template_directory_uri() . '/assets/images/arrow-button.svg', 'arrow-button') ?>
                                        <span><?php echo $navigation_title; ?></span></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if ($podcast): ?>
                    <div class="podcast-block">
                        <audio class="audio-player" controls>
                            <source src="<?php echo $podcast ?>" type="audio/mpeg">
                        </audio>
                        <a target="_blank" class="outline-button" href="<?php echo $podcast ?>">Download</a>
                    </div>
                <?php endif; ?>
                <div class="tags-block">
                    <div class="post-practitioner-category">
                        <?php if ($term_audience[0]->slug === 'hcp') : ?><span
                                class="category-hcp"><?php echo return_svg(get_template_directory_uri() . '/assets/images/categ-icon.svg', 'category-icon') ?></span><?php endif; ?>
                        <?php if ($term_cat[0]) :

                            $args_query = array(
                                    'post_type' => 'article',
                                    'order' => 'DESC',
                                    'posts_per_page' => 10,
                                    'meta_query' => array(
                                            array(
                                                    'key' => '_yoast_wpseo_primary_article-category',
                                                    'value' => (string)$term_cat[0]->term_id,
                                                    'compare' => '='
                                            ),
                                    ),
                                    'tax_query' => array(
                                            array(
                                                    'taxonomy' => 'article-category',
                                                    'field' => 'id',
                                                    'terms' => $term_cat[0]->term_id,
                                            ),
                                    ),
                            );
                            $query_posts_first = new WP_Query($args_query);
                            ?>
                            <?php if (count($query_posts_first->posts) > 3): ?>
                            <a href="<?php echo get_category_link($term_cat[0]->term_id) . "?id=" . $term_audience[0]->slug ?>"><span
                                        class="post-category-first"><?php echo $term_cat[0]->name; ?></span></a>
                        <?php else: ?>
                            <a><span class="post-category-first not-allow"><?php echo $term_cat[0]->name; ?></span></a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($term_cat[1]) :

                            $args_query = array(
                                    'post_type' => 'article',
                                    'order' => 'DESC',
                                    'posts_per_page' => 10,
                                    'meta_query' => array(
                                            array(
                                                    'key' => '_yoast_wpseo_primary_article-category',
                                                    'value' => (string)$term_cat[1]->term_id,
                                                    'compare' => '='
                                            ),
                                    ),
                                    'tax_query' => array(
                                            array(
                                                    'taxonomy' => 'article-category',
                                                    'field' => 'id',
                                                    'terms' => $term_cat[1]->term_id,
                                            ),
                                    ),
                            );
                            $query_posts_second = new WP_Query($args_query);

                            ?>
                            <?php if (count($query_posts_second->posts) > 3): ?>
                            <a href="<?php echo get_category_link($term_cat[1]->term_id) . "?id=" . $term_audience[0]->slug ?>"><span
                                        class="post-category-second"><?php echo $term_cat[1]->name; ?></span></a>
                        <?php else: ?>
                            <a><span class="post-category-second not-allow"><?php echo $term_cat[1]->name; ?></span></a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="post-info-block">
                        <span><?php echo $date ?></span>
                        <span><?php echo return_svg(get_template_directory_uri() . '/assets/images/format-icons/' . $term_format[0]->slug . '.svg', 'format-icon') ?></span>
                        <span><i>(<?php echo $time; ?> min <?php if ($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                    </div>
                </div>
                <div class="single-article-header">
                    <h1><?php echo $post->post_title; ?></h1>
                    <div class="author-block-wrap mobile-author">
                        <div class="author-block">
                            <!-- <?php //echo get_avatar( $post->post_author, 96, get_template_directory_uri().'/assets/images/placeholder_1.jpg', '' ); ?> -->

                            <div class="author-info">
                                <?php if (!empty($custom_author_info)) : ?>
                                    <div class="author-info-title">
                                        <?php echo $custom_author_info; ?>
                                    </div>
                                <?php elseif (has_term(12, 'format', get_the_ID())) : ?>
                                    <div class="author-info-title">
                                        <p>Hosted by: <b>WholisticMatters</b></p>
                                    </div>
                                <?php else: ?>
                                    <div class="author-info-title">
                                        <p style="margin: 0 10px 0 0; font-size: .875rem;">Written by:</p>
                                        <b><?php echo get_the_author_meta('display_name', $post->post_author); ?></b>
                                    </div>
                                    <p><?php echo get_the_author_meta('description', $post->post_author); ?></p>
                                <?php endif; ?>
                            </div>

                        </div>
                        <?php if ($pdf_file): ?>
                            <a target="_blank" class="outline-button" href="<?php echo $pdf_file ?>"
                               download>Download</a>
                        <?php endif; ?>
                        <a class="share-button" href="#">
                            <?php echo return_svg(get_template_directory_uri() . '/assets/images/share.svg', 'share-icon') ?>
                        </a>
                        <?php get_template_part('parts/share-links'); ?>
                    </div>
                    <div class="single-article-content-left-description">
                        <?php the_content(); ?>
                    </div>
                    <?php if ($term_audience[0]->slug === 'hcp') : ?><?php echo return_svg(get_template_directory_uri() . '/assets/images/practioner.svg', 'category-icon') ?><?php endif; ?>
                    <div class="author-block-wrap">
                        <div class="author-block">
                            <!-- <?php //echo get_avatar( $post->post_author, 96, get_template_directory_uri().'/assets/images/placeholder_1.jpg', '' ); ?> -->

                            <div class="author-info">
                                <div class="author-info-title">
                                    <b><?php echo get_the_author_meta('display_name', $post->post_author); ?></b>
                                </div>
                                <p><?php echo get_the_author_meta('description', $post->post_author); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if (have_rows('references')): ?>
                        <div class="references-list" data-accordion data-allow-all-closed="true">
                            <?php while (have_rows('references')): the_row();
                                $reference_title = get_sub_field('reference_title');
                                $references_content = get_sub_field('references_content');
                                ?>
                                <div class="accordion-item" data-accordion-item>
                                    <a href="#" class="accordion-title"><?php echo $reference_title; ?></a>
                                    <div class="accordion-content" data-tab-content>
                                        <?php echo $references_content; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- END of post content -->

            <!-- BEGIN of sidebar -->
            <div class="single-article-right single-article sidebar">

                <?php
                // Standard subscription block conditional display
                if (is_single([2232, 2442, 1704, 1938, 1704])) :
                    ?>
                    <div class="subscribe-content sidebarform" style="padding-bottom: 30px;">
                        <h2><?php echo $subscribe_block_title_option; ?></h2>
                        <p><?php echo $subscribe_block_subtitle_option; ?></p>
                        <div id="hs-home-newsletter-form" class="newsletter-form"></div>
                    </div>
                <?php endif; ?>

                <?php
                // Display Article Outline (TOC) based on ACF Repeater 'navigation'
                if (have_rows('navigation')):
                    ?>
                    <h3 class="sidebar-navigation-title">ARTICLE OUTLINE</h3>
                    <ul class="navigation-list">
                        <?php while (have_rows('navigation')): the_row();
                            $navigation_title = get_sub_field('navigation_title');
                            $navigation_href = get_sub_field('navigation_href');
                            ?>
                            <li>
                                <a href="#<?php echo $navigation_href; ?>"><?php display_svg(get_template_directory_uri() . '/assets/images/arrow-button.svg', 'arrow-button') ?>
                                    <span><?php echo $navigation_title; ?></span></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>

                <?php
                // ACF CUSTOM SIDEBAR LOGIC

                // 1. Get the status of the custom block switch (True/False)
                $use_custom_block = get_field('use_custom_sidebar_block');

                // 2. Get the content from the WYSIWYG/Gutenberg field
                $custom_content = get_field('custom_sidebar_content');
                $use_global_sidebar = get_field('use_global_sidebar');
                $global_sidebar_name = get_field('global_sidebar_name');

                // 3. Check if the switch is ON AND if there is content to display
                if ($use_custom_block && $custom_content && !$use_global_sidebar) :

                    // --- OPTION 1: DISPLAY CUSTOM ACF CONTENT ---
                    ?>
                    <div class="articles-list custom-sidebar-content preview--page">
                        <?php
                        // Apply the_content filter to parse shortcodes, paragraphs, and Gutenberg blocks
                        echo apply_filters('the_content', $custom_content); ?>

                    </div>
                <?php elseif ($use_custom_block && $use_global_sidebar): ?>
                    <div class="articles-list custom-sidebar-content preview--page">
                        <?php echo do_shortcode('[starter_sidebar id="' . esc_attr($global_sidebar_name) . '"]'); ?>
                    </div>
                <?php
                else :

                    // --- OPTION 2: DISPLAY STANDARD RELATED AND AUTHOR BLOCKS ---

                    // Display Related Content
                    if ($query_related->posts) : ?>
                        <div class="articles-list preview--page related-block">
                            <p class="articles-list-title">RELATED CONTENT</p>
                            <?php foreach ($query_related->posts as $featured_post):
                                $permalink = get_permalink($featured_post->ID);
                                $title = get_the_title($featured_post->ID);
                                ?>
                                <?php get_template_part('parts/loop', 'featured-articles', ['id' => $featured_post->ID, 'author' => $featured_post->post_author]); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!--Display More Articles By This Author-->
                    <?php if ($query_author->posts) : ?>
                    <div class="articles-list preview--page">
                        <p class="articles-list-title">MORE ARTICLES BY THIS AUTHOR</p>
                        <?php foreach ($query_author->posts as $featured_post):
                            $permalink = get_permalink($featured_post->ID);
                            $title = get_the_title($featured_post->ID);
                            ?>
                            <?php get_template_part('parts/loop', 'featured-articles', ['id' => $featured_post->ID, 'author' => $post->post_author]); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php endif; // End check for custom block ?>

            </div>

            <!-- END of sidebar -->
        </div>


        <section class="acf-custom-subscribe-form-process">
            <img alt="<?php echo $subscribe_block_image_option['alt']; ?>"
                 src="<?php echo $subscribe_block_image_option['url']; ?>">
            <div class="subscribe-content">
                <h2><?php echo $subscribe_block_title_option; ?></h2>
                <p><?php echo $subscribe_block_subtitle_option; ?></p>
                <div id="hs-home-newsletter-form" class="newsletter-form"></div>
            </div>
        </section>
    </main>

<?php get_footer(); ?>