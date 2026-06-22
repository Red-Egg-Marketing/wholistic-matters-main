<!-- BEGIN of Post -->
<?php

$post_type = get_post_type();
$id = get_the_ID();
$permalink = get_permalink();
$thumbnail_id = get_post_thumbnail_id();

if($post_type == 'taxonomy_term'){
    global $post;
    $taxonomy_slug = $post->post_name;
    $term_link = get_term_link( $id, $taxonomy_slug);
    $permalink = $term_link;

    $image = get_field('category_image', $taxonomy_slug .'_' . $id );
    $thumbnail_id = $image;
}
?>

<article id="post-<?php echo $id; ?>" <?php post_class( 'preview preview--' . get_post_type() ); ?>>
    <div class="grid-x grid-padding-x">
        <div class="article-image medium-4 small-12 cell text-center medium-text-left">
            <a href="<?php  echo $permalink; ?>" title="<?php the_title_attribute(); ?>">
                <?php echo get_attachment_fallback( $thumbnail_id, 'small', [ 'class' => 'preview__thumb' ] ) ?>
            </a>
        </div>
        <div class="cell auto">
            <h3 class="preview__title">
                <a href="<?php  echo $permalink; ?>"
                   title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'default' ), the_title_attribute( 'echo=0' ) ) ); ?>"
                   rel="bookmark"><?php echo get_the_title() ?: __( 'No title', 'default' ); ?>
                </a>
            </h3>
            <?php if ( is_sticky() ) : ?>
                <span class="secondary label preview__sticky"><?php _e( 'Sticky', 'default' ); ?></span>
            <?php endif; ?>
            <div class="preview__excerpt">
                <?php the_excerpt(); ?>
            </div>
        </div>
    </div>
</article>



<!-- END of Post -->



