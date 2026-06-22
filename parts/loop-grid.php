<?php

/**
 * @var array $args arguments.
 *
 */
$term_link = get_term_link( $args['id'], 'article-category' );
?>
<!-- BEGIN of Post -->
<div class="grid-item">
    <img class="<?php if(!$args['url']) : echo 'placeholder-img'; endif; ?>" alt="<?php echo $args['alt']?>" src="<?php if(!$args['url']) : echo get_template_directory_uri().'/assets/images/placeholder.svg'; else: echo $args['url']; endif; ?>">
    <a href="<?php if(!is_object($term_link)) : echo $term_link; else: echo get_permalink( $args['id'] ); endif;?>" class="overlay">
        <p><?php echo $args['title']?></p>
        <?php display_svg(get_template_directory_uri().'/assets/images/circle-arrow.svg', 'arrow-button arrow-mobile-hide') ?>
    </a>
</div>
<!-- END of Post -->
