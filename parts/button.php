<?php
/**
 * @var string $class additional button class
 * @var bool $sub_field
 */
$field_src = isset( $field_src ) ? $field_src : false;
$prefix    = isset( $prefix ) ? $prefix . '_' : '';

$class     = isset( $class ) ? $class : 'outline-button';
$sub_field = isset( $sub_field ) ? $sub_field : false;

$caller    = $sub_field ? 'get_sub_field' : 'get_field';
$field_src = $sub_field ? true : $field_src;

$link_type   = $caller( $prefix . 'link_type', $field_src );
$link_source = $caller( $prefix . 'link_source', $field_src );
$link_id     = $caller( $prefix . 'link_' . $link_source, $field_src );
$link_text   = $caller( $prefix . 'link_text', $field_src );
$ext_link    = $caller( $prefix . 'ext_link', $field_src );
$link        = false;
if ( $link_type == 'int' && $link_id ) {
	$link = $link_source == 'cat' ? get_term_link( $link_id, 'category' ) : get_the_permalink( $link_id );
} elseif ( $link_type == 'ext' ) {
	$link = $ext_link;
}

if ( $link_type == 'int' && $link && ! is_wp_error( $link ) ): ?>
	<a href="<?php echo $link; ?>" aria-label="<?php echo $link_text; ?> on our <?php echo get_the_title($link_id); ?> page"  class="<?php echo $class; ?>"><?php echo $link_text; ?></a>
<?php elseif ( $link_type == 'ext' && $link && ! is_wp_error( $link ) ): ?>
	<a href="<?php echo $link['url']; ?>" aria-label="<?php echo $link_text; ?> at"
	   class="<?php echo $class; ?>" <?php echo $link['target'] ? 'target="_blank"' : ''; ?>><?php echo $link['title']; ?></a>
<?php endif; ?>