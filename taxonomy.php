<?php
/**
 * Category
 *
 * Standard loop for the category page
 */

function get_get()
{
    return $_GET['id'];
}

$term = get_queried_object();
$back_to_all_resources = get_field('back_to_all_resources', 'option');
$post_not_in = [];
get_header();
$url_term_audience = '';
if ( !empty( $_GET['id'] )) {
    $url_term_audience = $_GET['id'];
}
?>
<main class="main-content taxonomy-page">
    <section class="acf-hero-section-with-two-featured-articles">
        <div class="back-link">
            <a href="<?php if ($back_to_all_resources) : echo $back_to_all_resources['url']; elseif ($url_term_audience === 'hcp'): echo '/practitioner-education/'; elseif ($url_term_audience === 'ne') : echo '/health-and-wellnesseducation/'; else: echo '/practitioner-education/' ; endif; ?>" class="back-to-all"><?php display_svg(get_template_directory_uri().'/assets/images/arrow-down.svg', 'arrow-down-icon'); if ($back_to_all_resources) : echo $back_to_all_resources['title']; else: echo 'Back to All Resources'; endif;?></a>
        </div>
        <div class="content-section">
            <h1><?php echo $term->name; ?></h1>
            <?php echo  $term->description; ?>
        </div>
        <?php
        $featured_articles = get_field('featured_articles', $term->taxonomy . '_' . $term->term_id);
        if( $featured_articles ): ?>
            <div class="list-two-articles">
                <?php foreach( $featured_articles as $featured_article ):
                    $permalink = get_permalink( $featured_article->ID );
                    $custom_field = get_field( 'field_name', $featured_article->ID );
                    $time = get_field('minutes_to', $featured_article->ID);
                    $term_format = get_the_terms($featured_article->ID, 'format');
                    $post_not_in[] = $featured_article->ID;
                    $article_excerpt = get_field('article_excerpt', $featured_article->ID);
                    ?>
                    <div class="list-two-articles-item" style="background-image: url('<?php echo get_attached_img_url($featured_article->ID) ?>')">
                        <a class="overlay" href="<?php echo esc_url( $permalink ); ?>">
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
        <?php elseif ($term->term_id):
            $arg = array(
                'post_type' => 'article',
                'order' => 'DESC',
                'posts_per_page' => 3,
                'meta_query'     => array(
                    array(
                        'key'     => '_yoast_wpseo_primary_article-category',
                        'value'   => (string)$term->term_id,
                        'compare' => '='
                    ),
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => $term->taxonomy,
                        'field' => 'id',
                        'terms' => $term->term_id,
                    ),
                ),
            );
            if ( !empty( $_GET['id'] )) {
                $arr = array(
                    'taxonomy' => 'audience',
                    'field' => 'slug',
                    'terms' => $url_term_audience,
                );
                array_push($arg['tax_query'], $arr);
            }
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
                            <div class="outline-button"><?php if ($term_format[0]->slug === 'video') : echo 'Watch video'; elseif ( $term_format[0]->slug === 'podcast'): echo 'Listen to Podcast'; else: echo 'Read Article'; endif; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></div>
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

    <?php if ( empty($_GET['id']) && $_GET['id'] > 0 ) {
	
	?>
	<section class="get_item" audience-attr = "<?php echo $_GET['id'];?> ">
<?php
//        echo do_blocks('<!-- wp:wordpress-popular-posts/widget {"title":"MOST POPULAR","range":"all","limit":10,"post_type":"article","custom_html":true,"header_start":"\u003cspan class=\u0022articles-slider-title\u0022\u003e","header_end":"\u003c/span\u003e","wpp_start":"\u003cul class=\u0022wpp-list most-popular-slider articles-slider\u0022\u003e"} /-->');
        echo do_blocks(
            '<!-- wp:wordpress-popular-posts/widget ' . json_encode([
                "title" => "MOST POPULAR",
                "range" => "all",
                "limit" => 10,
                "post_type" => "article",
                "tax" => $term->taxonomy,
                "term_id" => (string)$term->term_id,
                "taxonomy" => $term->taxonomy,
                "custom_html" => true,
                "header_start" => '<span class="articles-slider-title">',
                "header_end" => '</span>',
                "wpp_start" => '<ul class="wpp-list most-popular-slider articles-slider">'
            ]) . ' /-->'
        );
    }
    else{
        if ( $_GET['id'] === 'hcp'){
                //        echo do_blocks('<!-- wp:wordpress-popular-posts/widget {"title":"MOST POPULAR","range":"all","limit":10,"post_type":"article","tax":"audience","term_id":"18","taxonomy":"audience","custom_html":true,"header_start":"\u003cspan class=\u0022articles-slider-title\u0022\u003e","header_end":"\u003c/span\u003e","wpp_start":"\u003cul class=\u0022wpp-list most-popular-slider articles-slider\u0022\u003e"} /-->');
            echo do_blocks(
                '<!-- wp:wordpress-popular-posts/widget {"title":"MOST POPULAR","range":"all","limit":20,"post_type":"article","tax":"' . esc_attr($term->taxonomy) . '","term_id":"' . esc_attr($term->term_id) . '","audience_term_id":"19","audience_taxonomy":"audience","taxonomy":"' . esc_attr($term->taxonomy) . '","custom_html":true,"header_start":"<span class=\"articles-slider-title\">","header_end":"</span>","wpp_start":"<ul class=\"wpp-list most-popular-slider articles-slider\">"} /-->'
            );

        }
        elseif ( $_GET['id'] === 'ne') {
                //        echo do_blocks('<!-- wp:wordpress-popular-posts/widget {"title":"MOST POPULAR","range":"all","limit":10,"post_type":"article","tax":"audience","term_id":"19","taxonomy":"audience","custom_html":true,"header_start":"\u003cspan class=\u0022articles-slider-title\u0022\u003e","header_end":"\u003c/span\u003e","wpp_start":"\u003cul class=\u0022wpp-list most-popular-slider articles-slider\u0022\u003e"} /-->');
            echo do_blocks(
                '<!-- wp:wordpress-popular-posts/widget {"title":"MOST POPULAR","range":"all","limit":20,"post_type":"article","tax":"' . esc_attr($term->taxonomy) . '","term_id":"' . esc_attr($term->term_id) . '","audience_term_id":"19","audience_taxonomy":"audience","taxonomy":"' . esc_attr($term->taxonomy) . '","custom_html":true,"header_start":"<span class=\"articles-slider-title\">","header_end":"</span>","wpp_start":"<ul class=\"wpp-list most-popular-slider articles-slider\">"} /-->'
            );
        }
		?>
		</section>
		<?php
    }
    ?>

    <?php
        $arg_recent = array(
            'post_type' => 'article',
            'order' => 'DESC',
//            'post__not_in' => $post_not_in,
            'posts_per_page' => 10,
            'meta_query'     => array(
                array(
                    'key'     => '_yoast_wpseo_primary_article-category',
                    'value'   => (string)$term->term_id,
                    'compare' => '='
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => $term->taxonomy,
                    'field' => 'id',
                    'terms' => $term->term_id,
                ),
            ),
        );

        if ( !empty( $_GET['id'] )) {
            $arr = array(
                'taxonomy' => 'audience',
                'field' => 'slug',
                'terms' => $url_term_audience,
            );
            array_push($arg_recent['tax_query'], $arr);
        }

        $query_recent = new WP_Query($arg_recent);
        $posts_to_display = count($query_recent->posts) > 7 ? array_slice($query_recent->posts, 3) : $query_recent->posts;
        if( $posts_to_display ): ?>
            <section class="acf-most-recent-block">
                <span class="articles-slider-title">MOST RECENT</span>
                <div class="most-recent-slider articles-slider">
                    <?php foreach ($posts_to_display as $post ) :
                        $time = get_field('minutes_to', $post->ID);
                        $term_format = get_the_terms($post->ID, 'format');
                        $term_audience = get_the_terms($post->ID, 'audience');
                        $labels = get_the_terms($post->ID, 'article-category');
                        $article_excerpt = get_field('article_excerpt', $post->ID);
                        ?>
                        <div class="article-item" href="<?php echo get_permalink($post->ID)?>">
                            <div class="post-practitioner-category">
                                <?php if($term_audience[0]->slug === 'hcp') : ?><span><?php echo return_svg(get_template_directory_uri().'/assets/images/categ-icon.svg', 'category-icon') ?></span><?php endif; ?>
                                <?php
                                $args_query = array(
                                    'post_type' => 'article',
                                    'order' => 'DESC',
                                    'posts_per_page' => 10,
                                    'meta_query'     => array(
                                        array(
                                            'key'     => '_yoast_wpseo_primary_article-category',
                                            'value'   => (string)$term->term_id,
                                            'compare' => '='
                                        ),
                                    ),
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'article-category',
                                            'field' => 'id',
                                            'terms' => $term->term_id,
                                        ),
                                    ),
                                );
                                $query_posts = new WP_Query( $args_query );
                                ?>
                                <?php if (count($query_posts->posts) > 3): ?>
                                    <a href="<?php echo get_category_link($term->term_id).'?id='. $term_audience[0]->slug?>"><span class="post-category"><?php echo $term->name; ?></span></a>
                                <?php else: ?>
                                    <span class="post-category not-allow"><?php echo $term->name; ?></span>
                                <?php endif; ?>
                            </div>
                            <a class="article-title" href="<?php echo get_permalink($post->ID)?>"><?php echo wp_strip_all_tags($post->post_title)?></a>
                            <div class="post-info-block">
                                <b><?php if(strlen(get_the_author_meta('display_name', $post->post_author)) > 24) : echo substr(wp_strip_all_tags(get_the_author_meta('display_name', $post->post_author)), 0, 20) . '...'; else : echo get_the_author_meta('display_name', $post->post_author); endif;?></b>
                                <span><?php echo return_svg(get_template_directory_uri().'/assets/images/format-icons/'. $term_format[0]->slug .'.svg', 'format-icon') ?></span>
                                <span><i>(<?php echo $time; ?> min <?php if($term_format[0]->slug === 'video'): echo 'watch'; elseif ($term_format[0]->slug === 'podcast'): echo 'listen'; else: echo 'read'; endif; ?>)</i></span>
                            </div>
                            <div class="post-content">
                                <?php if (empty($article_excerpt )) : echo wp_strip_all_tags(get_the_content(null, true, $post->ID)); else: echo $article_excerpt; endif; ?>
                            </div>
                            <div class="article-item-image-wrap">
                                <a class="overlay" href="<?php echo get_permalink($post->ID)?>"></a>
                                <img alt="<?php echo get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)?>"  class="<?php if(!get_attached_img_url($post->ID)) : echo 'placeholder-img'; endif; ?>" src="<?php if(get_attached_img_url($post->ID)): echo get_attached_img_url($post->ID); else: echo get_template_directory_uri().'/assets/images/placeholder.svg'; endif;?>">
                            </div>
                            <a class="article-button" href="<?php echo get_permalink($post->ID)?>"><?php if ($term_format[0]->slug === 'video') : echo 'Watch video'; elseif ( $term_format[0]->slug === 'podcast'): echo 'Listen to Podcast'; else: echo 'Read Article'; endif; display_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif;
    $posts_per_page = 10;
    $arg_ll = array(
        'post_type' => 'article',
        'order' => 'DESC',
        'posts_per_page' => $posts_per_page,
        'meta_query'     => array(
            array(
                'key'     => '_yoast_wpseo_primary_article-category',
                'value'   => (string)$term->term_id,
                'compare' => '='
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => $term->taxonomy,
                'field' => 'id',
                'terms' => $term->term_id,
            ),
        ),
    );
    $arg_ll_mob = array(
        'post_type' => 'article',
        'order' => 'DESC',
        'posts_per_page' => 6,
        'meta_query'     => array(
            array(
                'key'     => '_yoast_wpseo_primary_article-category',
                'value'   => (string)$term->term_id,
                'compare' => '='
            ),
        ),
        'tax_query' => array(
            array(
                'taxonomy' => $term->taxonomy,
                'field' => 'id',
                'terms' => $term->term_id,
             ),
        ),
    );
    if ( !empty( $_GET['id'] )) {
        $arr_all = array(
            array(
                'taxonomy' => 'audience',
                'field' => 'slug',
                'terms' => $url_term_audience,
            )
        );
        $arr_all_mob = array(
            array(
                'taxonomy' => 'audience',
                'field' => 'slug',
                'terms' => $url_term_audience,
            )
        );
        array_push($arg_ll['tax_query'], $arr_all);
        array_push($arg_ll_mob['tax_query'], $arr_all_mob);
    }

    $query = new WP_Query($arg_ll);
    $query_mob = new WP_Query($arg_ll_mob);
    $terms_format = get_terms( array(
        'taxonomy'   => 'format',
        'hide_empty' => false,
    ) );

    $term_custom = new stdClass();
    $term_custom->taxonomy = '';
    $term_custom->term_id = '';
    $term_custom->slug = '';
    $term_custom->name = 'All Media';

    array_unshift($terms_format, $term_custom);
    ?>


    <?php if( $query->posts ): ?>
        <section class="acf-custom-media-list-articles">
            <div class="media-filter-section">
                <a id="filter-media-button" class="filter-button"><span>All Media</span><?php display_svg(get_template_directory_uri().'/assets/images/arrow-down.svg', 'arrow-down-icon') ?></a>
            </div>
            <div class="sub-media-list">
                <?php foreach ($terms_format as $term_format ) : ?>
                    <a class="sub-media-item chose-item" data-term-tax="<?php echo $term->taxonomy ?>" data-url_term_audience="<?php echo $url_term_audience; ?>" data-term-id="<?php echo $term->term_id ?>" data-term="<?php echo $term_format->slug?>"><?php echo $term_format->name?></a>
                <?php endforeach; ?>
            </div>
            <div id="filter-media-list-articles" class="media-list-articles">
                <?php foreach ($query->posts as $post ) :
                    get_template_part( 'parts/loop', 'media-article', ['post' => $post ]  ); ?>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <?php if ($query->found_posts > $posts_per_page): ?><a id="load-more-media-all" data-term-tax="<?php echo $term->taxonomy ?>" data-term-id="<?php echo $term->term_id ?>"  data-url_term_audience="<?php echo $url_term_audience; ?>"  data-posts_per_page="<?php echo $posts_per_page; ?>" class="outline-button">Load More</a><?php endif; ?>
        </section>
    <?php endif; ?>

    <?php if( $query_mob->posts ): ?>
        <section class="acf-custom-media-list-articles mobile-block">
            <div class="media-filter-section">
                <a id="filter-media-button-mob" class="filter-button"><span>All Media</span><?php display_svg(get_template_directory_uri().'/assets/images/arrow-down.svg', 'arrow-down-icon') ?></a>
            </div>
            <div class="sub-media-list">
                <?php foreach ($terms_format as $term_format ) : ?>
                    <a class="sub-media-item chose-item-mob" data-term-tax="<?php echo $term->taxonomy ?>" data-url_term_audience="<?php echo $url_term_audience; ?>" data-term-id="<?php echo $term->term_id ?>" data-term="<?php echo $term_format->slug?>"><?php echo $term_format->name?></a>
                <?php endforeach; ?>
            </div>
            <div id="filter-media-list-articles-mob" class="media-list-articles">
                <?php foreach ($query_mob->posts as $post ) :
                    get_template_part( 'parts/loop', 'media-article', ['post' => $post ]  ); ?>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>

            <?php if ($query_mob->found_posts > $posts_per_page): ?><a id="load-more-media-all-mob" data-term-tax="<?php echo $term->taxonomy ?>" data-term-id="<?php echo $term->term_id ?>" data-url_term_audience="<?php echo $url_term_audience; ?>"  data-posts_per_page="<?php echo $posts_per_page; ?>" class="outline-button">Load More</a><?php endif; ?>
        </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>