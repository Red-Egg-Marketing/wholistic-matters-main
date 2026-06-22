<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
$title_block = get_field('title_block');
$description_block = get_field('description_block');
$article_format = get_field('article_format');
global $post_not_in;
?>
<section class="<?php echo starter_section_class( 'acf-hero-section-with-two-featured-articles', $block ); ?>">
    <div class="content-section">
        <h1><?php echo $title_block; ?></h1>
        <?php echo $description_block; ?>
    </div>
    <?php
    $featured_articles = get_field('featured_articles');
    if( $featured_articles ): ?>
		<div class="right-column">
        <div class="list-two-articles">
            <?php foreach( $featured_articles as $featured_article ):
                $permalink = get_permalink( $featured_article->ID );
                $custom_field = get_field( 'field_name', $featured_article->ID );
                $time = get_field('minutes_to', $featured_article->ID);
                $term_format = get_the_terms($featured_article->ID, 'format');
                $post_not_in[] = $featured_article->ID;
                $article_excerpt = get_field('article_excerpt', $featured_article->ID);
                ?>

                <div class="list-two-articles-item" style="background-image: url('<?php echo get_attached_img_url($featured_article->ID) ?>'); background-position: center center; ">
                    <a href="<?php echo esc_url( $permalink ); ?>" class="overlay">
                        <div class="overlay-content-wrap">
                            <h2><?php echo esc_html( $featured_article->post_title); ?></h2>
                            <div class="post-info-block">
                                <b><?php echo get_the_author_meta('display_name', $featured_article->post_author); ?></b>
                                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                                <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                            </div>
                            <div class="post-content">
                                <?php if (empty($article_excerpt )) : echo wp_strip_all_tags($featured_article->post_content); else: echo wp_strip_all_tags($article_excerpt) ; endif; ?>
                            </div>
                        </div>
                        <div class="outline-button" ><?php if ($term_format[0]->slug === 'video') : echo 'Watch video'; elseif ( $term_format[0]->slug === 'podcast'): echo 'Listen to Podcast'; else: echo 'Read Article'; endif; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></div>
                    </a>
                    <div class="overlay mobile-wrap">
                        <div class="overlay-content-wrap">
                            <h2><?php echo esc_html( $featured_article->post_title); ?></h2>
                            <div class="post-info-block">
                                <b><?php echo get_the_author_meta('display_name', $featured_article->post_author); ?></b>
                                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                                <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                            </div>
                            <div class="post-content">
                                <?php if (empty($article_excerpt )) : echo wp_strip_all_tags($featured_article->post_content); else: echo wp_strip_all_tags($article_excerpt) ; endif; ?>
                            </div>
                        </div>
                        <a href="<?php echo esc_url( $permalink ); ?>" class="outline-button" ><?php if ($term_format[0]->slug === 'video') : echo 'Watch video'; elseif ( $term_format[0]->slug === 'podcast'): echo 'Listen to Podcast'; else: echo 'Read Article'; endif; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></a>
                    </div>
                </div>
				
            <?php endforeach; ?>
        </div>

						<?php
						if (get_field('show_podcast_form')) {
							?>
							<!-- <div class="podcast-form" id="hs-content-newsletter-form">
							</div> -->
			<div class="libsyn-player">
			<iframe title="Embed Player" style="border:none" src="https://play.libsyn.com/embed/destination/id/529761/height/276/theme/modern/size/large/thumbnail/yes/custom-color/576949/category/general/playlist-height/64/direction/backward/download/yes/font-color/FFFFFF" height="276" width="100%" scrolling="no" allowfullscreen="" webkitallowfullscreen="true" mozallowfullscreen="true" oallowfullscreen="true" msallowfullscreen="true"></iframe>
			</div>
							<?php
						}
						?>
			</div>

    <?php elseif ($article_format):
        $arg = array(
            'post_type' => 'article',
            'order' => 'DESC',
            'posts_per_page' => 2,
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'id',
                    'terms' => $article_format,
                ),
            ),
        );
        $query = new WP_Query($arg);
        ?>
        <div class="list-two-articles">
            <?php foreach( $query->posts as $query_article ):
                $permalink = get_permalink( $query_article->ID );
                $custom_field = get_field( 'field_name', $query_article->ID );
                $time = get_field('minutes_to', $query_article->ID);
                $term_format = get_the_terms($query_article->ID, 'format');
                $post_not_in[] = $query_article->ID;
                $article_excerpt = get_field('article_excerpt', $query_article->ID);
                ?>
                <div class="list-two-articles-item" style="background-image: url('<?php echo get_attached_img_url($query_article->ID) ?>')">
                    <a class="overlay" href="<?php echo esc_url( $permalink ); ?>">
                        <div class="overlay-content-wrap">
                            <h2><?php echo esc_html( $query_article->post_title); ?></h2>
                            <div class="post-info-block">
                                <b><?php echo get_the_author_meta('display_name', $query_article->post_author); ?></b>
                                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                                <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                            </div>
                            <div class="post-content">
                                <?php if (empty($article_excerpt )) : echo wp_strip_all_tags($query_article->post_content); else: echo wp_strip_all_tags($article_excerpt) ; endif; ?>
                            </div>
                        </div>
                        <div class="outline-button" >Watch Video <?php display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button')  ?></div>
                    </a>
                    <div class="overlay mobile-wrap">
                        <div class="overlay-content-wrap">
                            <h2><?php echo esc_html( $query_article->post_title); ?></h2>
                            <div class="post-info-block">
                                <b><?php echo get_the_author_meta('display_name', $query_article->post_author); ?></b>
                                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                                <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                            </div>
                            <div class="post-content">
                                <?php if (empty($article_excerpt )) : echo wp_strip_all_tags($query_article->post_content); else: echo wp_strip_all_tags($article_excerpt) ; endif; ?>
                            </div>
                        </div>
                        <a href="<?php echo esc_url( $permalink ); ?>" class="outline-button"><?php if ($term_format[0]->slug === 'video') : echo 'Watch video'; elseif ( $term_format[0]->slug === 'podcast'): echo 'Listen to Podcast'; else: echo 'Read Article'; endif; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
	

	
</section>