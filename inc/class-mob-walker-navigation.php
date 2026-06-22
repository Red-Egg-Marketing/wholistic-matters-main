<?php

/**
 * Class Mob_Walker_Navigation
 */

class Mob_Walker_Navigation extends Walker_Nav_Menu {

	/**
	 * Adds custom class to dropdown menu for foundation dropdown script
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"menu submenu lvl-$depth\">\n";
	}
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $indent = str_repeat("\t", $depth);
        $image = get_the_post_thumbnail_url($item->object_id);
        $title = get_the_title($item->object_id);
        $submenu_type = get_field('submenu_type', $item->menu_item_parent);
        $cta_header_title = get_field('cta_header_title', 'option');
        $cta_image = get_field('header_cta_image', 'option');
        $cta_button = get_field('header_cta_button', 'option');
        $cta_link_title = $cta_button ? $cta_button['title'] : '';
        $cta_link_url = $cta_button ? $cta_button['url'] : '';
        if ($submenu_type) {
            $output .= "\n$indent<div class='menu-card-article-wrap'>\n";
            $output .= "\n$indent<img alt='' src='$image' class='menu-card-article-image'>\n";
            $output .= "\n$indent<a href='$item->url' class='menu-card-article-overlay overlay'>\n";
            $output .= "\n$indent<p>$title</p>\n";
            $output .= "\n$indent</a>\n";
            $output .= "\n$indent</div>\n";
        } else {
            if ($item->description) {
                $output .= "\n$indent<li>\n";
                $output .= "\n$indent<div class='menu-content-block'>\n";
                $output .= "\n$indent<span>$item->title</span>\n";
                $output .= "\n$indent<p>$item->description</p>\n";
                $output .= "\n$indent<a href='$item->url' class='outline-button'>Learn More About Us". return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ."</a>\n";
                $output .= "\n$indent</div>\n";
                if ($cta_image || $cta_button) {
                    $output .= "\n$indent</li>\n";
                    $output .= "\n$indent<li class='$depth'>\n";
                    $output .= "\n$indent<div class='menu-cta-block'>\n";

                    if ($cta_image) {
                        // Open <a> tag surrounding image
                        $output .= "\n$indent<a href='$cta_link_url' class='menu-cta-link-area'>\n";

                        $image_html = wp_get_attachment_image($cta_image['id'], 'large', false, [
                            'class' => 'cta-image'
                        ]);
                        $output .= "\n$indent$image_html\n";

                        if ($cta_header_title) {
							// Add the heading inside the <a> link
							$output .= "\n$indent<h3 class='cta-title'>{$cta_header_title}</h3>\n";
						}

                        // Close the <a> tag surrounding image
                        $output .= "\n$indent</a>\n";
                    }

                    if ($cta_button) {
                        $output .= "\n$indent<a href='$cta_link_url' class='outline-button'>$cta_link_title"
                            . return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button')
                            . "</a>\n";
                    }

                    $output .= "\n$indent</div>\n";
                }
            } else {
                $output .= "\n$indent<li>\n";
                $output .= "\n$indent<a href='$item->url' class='header-category-item'>$item->title</a>\n";
            }


        }
    }

    /**
     * Adds custom class to parent item with dropdown menu
     */
    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $id_field = $this->db_fields['id'];
        $submenu_type = get_field('submenu_type', $element->ID);
        if (!empty($children_elements[$element->$id_field])) {
            $element->classes[] = 'has-dropdown';
        }
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}
