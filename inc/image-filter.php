<?php
/**
 * Accessible names for linked images (WCAG F89 "Links must have an accessible name").
 *
 * Scope: core/image blocks only. Inside a core/image the anchor wraps ONLY the
 * <img>, so an empty/missing alt means the LINK has no accessible name. That makes
 * it safe to derive one automatically here (unlike site-wide, where an empty alt
 * next to visible link text is legitimately decorative).
 *
 * Behaviour:
 *   - Acts only on images that are (a) inside a link and (b) have no name of their own.
 *   - Editor-authored alt always wins — the filter bails the moment real alt exists.
 *   - Resolves the destination to its post title; falls back to a humanized slug.
 *   - Never emits a garbage label — if nothing meaningful resolves, it leaves the
 *     markup untouched rather than shipping "Image" / "Link" / a numeric id.
 */

/**
 * Derive a human label from a link destination.
 *
 * NOTE: if the generic-button pass already exposes a shared URL->label resolver,
 * call that here instead and delete the fallback below to keep the logic DRY.
 */
function red_egg_label_from_url( $url ) {
    if ( ! is_string( $url ) || '' === trim( $url ) ) {
        return '';
    }

    // Prefer the real destination title (best quality, matches what the editor named it).
    $post_id = url_to_postid( $url );
    if ( $post_id ) {
        $title = get_the_title( $post_id );
        if ( '' !== trim( $title ) ) {
            return trim( $title );
        }
    }

    // Fallback: humanize the last path segment.
    $path = wp_parse_url( $url, PHP_URL_PATH );
    if ( ! is_string( $path ) ) {
        return '';
    }
    $path = trim( $path, '/' );
    if ( '' === $path ) {
        return '';
    }

    $segments = explode( '/', $path );
    $slug     = end( $segments );

    // Drop a leading CPT base (e.g. "article/collard-greens..." -> "collard-greens...").
    if ( in_array( $slug, [ 'article', 'articles', 'post', 'posts' ], true ) && count( $segments ) > 1 ) {
        $slug = $segments[ count( $segments ) - 2 ];
    }

    $label = trim( ucwords( str_replace( [ '-', '_' ], ' ', $slug ) ) );

    // Guard against garbage: too short, or a bare numeric id.
    if ( strlen( $label ) < 3 || ctype_digit( str_replace( ' ', '', $label ) ) ) {
        return '';
    }

    return $label;
}

/**
 * Give linked images with no accessible name an alt derived from the destination.
 */
function red_egg_name_linked_images( $block_content, $block ) {
    // Only a linked image can trigger F89; cheap bail-outs first.
    if ( '' === $block_content
        || false === stripos( $block_content, '<a' )
        || false === stripos( $block_content, '<img' )
        || ! class_exists( 'WP_HTML_Tag_Processor' )
    ) {
        return $block_content;
    }

    $tags = new WP_HTML_Tag_Processor( $block_content );

    $href           = '';
    $link_is_named  = false;
    $modified       = false;

    while ( $tags->next_tag() ) {
        $tag = $tags->get_tag();

        if ( 'A' === $tag ) {
            $h    = $tags->get_attribute( 'href' );
            $href = is_string( $h ) ? $h : '';

            // Anchor already carries its own name — nothing to fix.
            $aria = $tags->get_attribute( 'aria-label' );
            $link_is_named = ( is_string( $aria ) && '' !== trim( $aria ) );
            continue;
        }

        if ( 'IMG' === $tag ) {
            // Only images sitting inside an unnamed link are candidates.
            if ( '' === $href || $link_is_named ) {
                continue;
            }

            $alt = $tags->get_attribute( 'alt' );
            if ( is_string( $alt ) && '' !== trim( $alt ) ) {
                continue; // real alt already supplies the link name — defer to the editor
            }

            $label = red_egg_label_from_url( $href );
            if ( '' === $label ) {
                continue; // no meaningful label available; leave markup untouched
            }

            $tags->set_attribute( 'alt', $label );
            $modified = true;
        }
    }

    return $modified ? $tags->get_updated_html() : $block_content;
}
add_filter( 'render_block_core/image', 'red_egg_name_linked_images', 10, 2 );

/**
 * Accessible names for linked media in core/media-text blocks (WCAG F89).
 *
 * Why this is separate from the core/image filter: in a media-text block the
 * image is part of the block's own rendered markup, not a nested core/image
 * block, so render_block_core/image never fires on it. And the media link
 * usually points at a raw file in /uploads/ (link-to-media-file), so there is
 * no post title to resolve — the adjacent content paragraph is the only
 * meaningful naming source.
 *
 * Behaviour:
 *   - Acts only when the media column has a link wrapping an image with no name.
 *   - Names the LINK via aria-label and leaves the image alt="" — the image is
 *     decorative (it's described by the adjacent paragraph); only the link needs
 *     a name. aria-label on the <a> supplies it directly.
 *   - Uses the FIRST SENTENCE of the content column, capped — a full paragraph
 *     as a link name is valid but miserable in a screen reader.
 *   - Defers to any editor-supplied alt or existing aria-label; never overwrites.
 */

/**
 * Pull a concise label (first sentence, capped) from the media-text content column.
 */
function red_egg_first_sentence_from_media_text( $html ) {
    $marker = 'wp-block-media-text__content';
    $pos    = strpos( $html, $marker );
    if ( false === $pos ) {
        return '';
    }

    $text = wp_strip_all_tags( substr( $html, $pos ) );
    $text = html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
    $text = trim( preg_replace( '/\s+/', ' ', $text ) );
    if ( '' === $text ) {
        return '';
    }

    // First sentence if we can find a terminator, else the whole run.
    $label = preg_match( '/^(.+?[.!?])(\s|$)/u', $text, $m ) ? $m[1] : $text;

    // Hard cap so a run-on first "sentence" doesn't become the link name.
    $len = function_exists( 'mb_strlen' ) ? mb_strlen( $label ) : strlen( $label );
    if ( $len > 140 ) {
        $label = function_exists( 'mb_substr' )
            ? rtrim( mb_substr( $label, 0, 137 ) ) . '…'
            : rtrim( substr( $label, 0, 137 ) ) . '…';
    }

    return trim( $label );
}

/**
 * Name an unnamed linked image in a media-text block from its content paragraph.
 */
function red_egg_name_media_text_link( $block_content, $block ) {
    if ( '' === $block_content
        || false === stripos( $block_content, '<a' )
        || false === stripos( $block_content, '<img' )
        || ! class_exists( 'WP_HTML_Tag_Processor' )
    ) {
        return $block_content;
    }

    $tags       = new WP_HTML_Tag_Processor( $block_content );
    $has_link   = false;
    $link_named = false;

    while ( $tags->next_tag() ) {
        $tag = $tags->get_tag();

        if ( 'A' === $tag ) {
            $href       = $tags->get_attribute( 'href' );
            $has_link   = is_string( $href ) && '' !== $href;
            $aria       = $tags->get_attribute( 'aria-label' );
            $link_named = is_string( $aria ) && '' !== trim( $aria );
            $tags->set_bookmark( 'media_link' );
            continue;
        }

        if ( 'IMG' === $tag ) {
            // The media column's image comes first; that's the link we name.
            if ( ! $has_link || $link_named ) {
                continue;
            }
            $alt = $tags->get_attribute( 'alt' );
            if ( is_string( $alt ) && '' !== trim( $alt ) ) {
                continue; // editor gave the image a name; nothing to do
            }

            $label = red_egg_first_sentence_from_media_text( $block_content );
            if ( '' === $label ) {
                return $block_content; // no meaningful text; leave untouched
            }

            $tags->seek( 'media_link' );
            $tags->set_attribute( 'aria-label', $label );
            return $tags->get_updated_html();
        }
    }

    return $block_content;
}
add_filter( 'render_block_core/media-text', 'red_egg_name_media_text_link', 10, 2 );