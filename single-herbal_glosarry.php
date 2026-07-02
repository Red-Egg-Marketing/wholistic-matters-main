<?php
/**
 * Single
 *
 * Loop container for single post content
 */

$post = get_queried_object();
$term_audience = get_the_terms($post->ID, 'audience');
$labels = get_the_terms($post->ID, 'article-category');
$time = get_field('minutes_to', $post->ID);
$date = get_the_date('F j Y', $post->ID);
$left_logo = get_field('left_logo', 'option');
$right_logo = get_field('right_logo', 'option');
$standard_process_content = get_field('standard_process_content', 'option');
$learn_more_about = get_field('learn_more_about', 'option');
$standard_gallery = get_field('standard_gallery', 'option');
$scientific_name = get_field('scientific_name', $post->ID);
$common_name = get_field('common_name', $post->ID);
$term_cat = [];

foreach ($labels as $label) {
    $term_cat[] = $label->slug;
}

$args_related = array(
    'post_type' => 'article',
    'order' => 'DESC',
    'posts_per_page' => 3,
    'post__not_in' => array($post->ID),
    'tax_query' => array(
        'relation' => 'and',
        array(
            'taxonomy' => 'audience',
            'field' => 'slug',
            'terms' => $term_audience[0]->slug ,
        ),
        array(
            'taxonomy' => 'article-category',
            'field' => 'slug',
            'terms' => $term_cat,
        ),
    ),
);

$query_related = new WP_Query($args_related);
get_header(); ?>
	<main class="main-content single">
        <section class="acf-hero-section-block herbal--glossary ">
            <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'full_hd', false, array( 'class' => '_wp_attachment_image_alt' ) ); ?>
            <div class="overlay">
                <h1><?php echo $post->post_title; ?></h1>
            </div>
        </section>
		<div class="single-content-wrap">
				<!-- BEGIN of post content -->
				<div class="single-article-content-left">
                    <?php if( have_rows('navigation') ): ?>
                    <div class="navigation-wrap">
                        <h3 id="navigation-title" class="sidebar-navigation-title">OUTLINE <?php display_svg(get_template_directory_uri().'/assets/images/arrow-top.svg', 'arrow-top-icon') ?></h3>
                        <ul class="navigation-list toggle">
                            <?php while( have_rows('navigation') ): the_row();
                                $navigation_title = get_sub_field('navigation_title');
                                $navigation_href = get_sub_field('navigation_href');

                                if ( '' === trim( (string) $navigation_title ) ) {
                                        continue;
                                }
                                ?>
                                <li>
                                    <a href="#<?php echo $navigation_href; ?>"><?php display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?><span><?php echo $navigation_title; ?></span></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if($scientific_name || $common_name): ?><div id="module-0" class="herbal-glossary-tags-block">
                        <?php if($scientific_name): ?><span><b>Scientific name:</b><?php echo $scientific_name; ?></span><?php endif; ?>
                        <?php if($common_name): ?><span><b>Common name:</b><?php echo $common_name; ?></span><?php endif; ?>
                    </div><?php endif; ?>
                    <div class="single-herbal-glossary-header">
                        <div class="single-article-content-left-description">
                            <?php the_content(); ?>
                        </div>
                        <?php if( have_rows('references') ): ?>
                            <div class="references-list" data-accordion data-allow-all-closed="true">
                                <?php while( have_rows('references') ): the_row();
                                    $reference_title = get_sub_field('reference_title');
                                    $references_content = get_sub_field('references_content');

                                    if ( '' === trim( (string) $reference_title ) ) {
                                        continue;
                                    }
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
				<div class="single-article-right sidebar">
                    <?php if( have_rows('navigation') ): ?>
                        <h3 class="sidebar-navigation-title">OUTLINE</h3>
                        <ul class="navigation-list">
                            <?php while( have_rows('navigation') ): the_row();
                                $navigation_title = get_sub_field('navigation_title');
                                $navigation_href = get_sub_field('navigation_href');
                                ?>
                                <li>
                                    <a href="#<?php echo $navigation_href; ?>"><?php display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?><span><?php echo $navigation_title; ?></span></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if ($query_related->posts) : ?>
                        <div class="articles-list preview--page related-block">
                            <p class="articles-list-title">RELATED CONTENT</p>
                            <?php foreach( $query_related->posts as $featured_post ):
                                $permalink = get_permalink( $featured_post->ID );
                                $title = get_the_title( $featured_post->ID );
                                ?>
                                <?php get_template_part( 'parts/loop', 'featured-articles', ['id' => $featured_post->ID, 'author' => $featured_post->post_author ] );?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
				</div>
				<!-- END of sidebar -->
        </div>


        <section class="acf-custom-standard-process">
            <div class="top-section">
                <div class="standard-process-content-block">
                    <?php if ($left_logo || $right_logo) : ?>
                        <div class="standard-process-logos">
                            <img alt="<?php echo $left_logo['alt']?>" src="<?php echo $left_logo['url'] ?>">
                            <?php if ($right_logo): display_svg(get_template_directory_uri().'/assets/images/symbol-&.svg', 'arrow-button'); endif; ?>
                            <img class="right-logo" alt="<?php echo $right_logo['alt']?>" src="<?php echo $right_logo['url'] ?>">
                        </div>
                    <?php endif; ?>
                    <?php echo $standard_process_content; ?>
                    <?php if ($learn_more_about): ?>
                        <div class="load-more-wrap">
                            <a href="<?php echo $learn_more_about['url']; ?>"><?php echo $learn_more_about['title']; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button')?></a>
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
        </section>
	</main>

<?php get_footer(); ?>