<?php
/**
 * Unwrap attribute-less anchors left in authored content (WCAG F15 / F54).
 *
 * Targets ONLY tags of the exact form <a>text</a> — an anchor with no
 * attributes whatsoever. Such a tag is inert: no href, no in-page target
 * (id/name), no role/tabindex, no class or data-* hook that JS could bind to.
 * It's editorial cruft (a URL deleted, the tag left behind) and shows up in
 * scans as F54 (no ARIA role) + F15 (keyboard), since an <a> without href
 * has no implicit link role and isn't focusable.
 *
 * The fix strips the tag and keeps the inner text/markup.
 *
 * Safety: the <a\s*> predicate matches only "<a>" or "<a >". The moment an
 * attribute is present there's a character between "a" and ">", so anything
 * carrying href / id / name / role / class / data-* / aria-* is left untouched.
 * Anchors can't legally nest, so the non-greedy body + first </a> is correct,
 * and <a></a> (empty) collapses to nothing.
 *
 * Scope: post body only (the_content). Stray anchors in template, block, or
 * widget output want a source fix, not this filter.
 */
function red_egg_unwrap_empty_anchors( $content ) {
    if ( ! is_string( $content ) || false === stripos( $content, '<a' ) ) {
        return $content;
    }

    return preg_replace( '#<a\s*>(.*?)</a>#is', '$1', $content );
}
// Priority 20: run after do_blocks / wpautop, on the assembled content.
add_filter( 'the_content', 'red_egg_unwrap_empty_anchors', 20 );