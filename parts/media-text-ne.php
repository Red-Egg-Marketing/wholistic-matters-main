
<?php
$image_id   = get_field( 'mt_ne_image', 'option' );
$heading    = get_field( 'mt_ne_heading', 'option' );
$text       = get_field( 'mt_ne_text', 'option' );
$link 		= get_field( 'mt_ne_link', 'option' );

if ( ! $image_id || ! $heading ) {
	return;
}

$image = wp_get_attachment_image(
	$image_id,
	'large',
	false,
	array(
		'class' => 'wp-image-' . $image_id . ' size-large',
		'style' => 'object-fit: cover; height: 100%;',
	)
);

$link_html = '';
if ( $link ) {
	$target    = $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : '';
	$link_html = sprintf(
		'<!-- wp:heading {"level":5,"style":{"elements":{"link":{"color":{"text":"var:preset|color|white-main"}}}},"textColor":"white-main"} -->
<h5 class="wp-block-heading has-white-main-color has-text-color has-link-color"><strong><a href="%s"%s>%s</a></strong></h5>
<!-- /wp:heading -->',
		esc_url( $link['url'] ),
		$target,
		esc_html( $link['title'] ?: 'Learn more' )
	);
}

$markup = sprintf(
	'<!-- wp:media-text {"mediaId":%1$d,"linkDestination":"none","mediaType":"image","mediaWidth":53,"style":{"color":{"background":"#9aa592"},"spacing":{"margin":{"top":"30px"},"padding":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-media-text is-stacked-on-mobile has-background" style="background-color:#9aa592;margin-top:30px;padding-top:0;padding-bottom:0;grid-template-columns:53%% auto"><figure class="wp-block-media-text__media" style="height:100%%;object-fit:cover;">%2$s</figure><div class="wp-block-media-text__content" style="padding-top:8%%;padding-bottom:8%%"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">%3$s</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px"}}} -->
<div class="wp-block-group mt-hcp-ne" style="font-size:15px">%4$s</div>
<!-- /wp:paragraph -->
%5$s</div></div>
<!-- /wp:media-text -->',
	$image_id,
	$image,
	esc_html( $heading ),
	wp_kses_post( $text ),
	$link_html
);

echo do_blocks( $markup );