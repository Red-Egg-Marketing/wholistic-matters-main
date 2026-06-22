<?php

/**
 * Class Walker_Navigation
 */

class Walker_Navigation extends Walker_Nav_Menu {
    private $first_item = true;

    /**
     * Adds custom class to dropdown menu for foundation dropdown script
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"menu submenu lvl-$depth\">\n";
        if ($depth === 0 && $this->first_item) {
            $this->first_item = false;
        }
        if ($depth === 1 && !$this->first_item) {
            $this->first_item = true;
        }
    }
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        $indent = str_repeat("\t", $depth);
        $featured_image = get_the_post_thumbnail_url($item->object_id);
        $alt_text = get_post_meta(get_post_thumbnail_id($item->object_id), '_wp_attachment_image_alt', true);
        $image = get_field('category_image', $item->object . '_' . $item->object_id);
        $image_url = $image['url'];
        $image_alt = $image['alt'];
        $submenu_type = get_field('submenu_type', $item->menu_item_parent);
        if ($depth === 2) {
            if(!$image) {
                $output .= "\n$indent<a href='$item->url' class='fill-button'>$item->title ". return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ."</a>\n";
            }
        }
        if ($depth === 2) {

            if($image) {
                $args = array(
                    'post_type' => 'article',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    //'meta_query'     => array(
                    //   array(
                    //      'key'     => '_yoast_wpseo_primary_article-category',
                    //      'value'   => (string)$item->object_id,
                    //      'compare' => '='
                    //    ),
                    //),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'article-category',
                            'field' => 'id',
                            'terms' => (int)$item->object_id,

                        ),
                    ),
                );
                if ($item->menu_item_parent === "33") {
                    $args['tax_query'][] =  array(
                        'taxonomy' => 'audience',
                        'field' => 'slug',
                        'terms' => 'hcp',
                    );
                }
                if ($item->menu_item_parent === "34") {
                    $args['tax_query'][] =  array(
                        'taxonomy' => 'audience',
                        'field' => 'slug',
                        'terms' => 'ne',
                    );
                }
                $query = new WP_Query( $args );
                if (count($query->posts) > 2) {
                    $output .= "\n$indent<li class='menu-article-wrap'>\n";
                    $output .= "\n$indent<img alt='$image_alt' src='$image_url' class='menu-article-image'>\n";
                    if($item->menu_item_parent === "33") {
                        $output .= "\n$indent<a href='$item->url?id=hcp' class='menu-article-overlay'>\n";
                    } elseif ($item->menu_item_parent === "34") {
                        $output .= "\n$indent<a href='$item->url?id=ne' class='menu-article-overlay'>\n";
                    } else {
                        $output .= "\n$indent<a href='$item->url' class='menu-article-overlay'>\n";
                    }
                    $output .= "\n$indent<div class='overlay-content-wrap'>\n";
                    $output .= "\n$indent<p>$item->title </p>\n";
                    $output .= "\n$indent". return_svg(get_template_directory_uri().'/assets/images/circle-arrow.svg', 'arrow-button') ."\n";
                    $output .= "\n$indent</div>\n";
                    $output .= "\n$indent</a>\n";
                }
            }
        } elseif ($submenu_type) {
            $output .= "\n$indent<div class='menu-card-article-wrap'>\n";
            $output .= "\n$indent<img alt='$alt_text' src='$featured_image' class='menu-card-article-image'>\n";
            $output .= "\n$indent<a href='$item->url' class='menu-card-article-overlay'>\n";
            $output .= "\n$indent<div class='menu-card-article-overlay-content-wrap'>\n";
            $output .= "\n$indent<p>$item->title</p>\n";
            $output .= "\n$indent". return_svg(get_template_directory_uri().'/assets/images/circle-arrow.svg', 'arrow-button') ."\n";
            $output .= "\n$indent</div>\n";
            $output .= "\n$indent</a>\n";
            $output .= "\n$indent</div>\n";
        } else {
            $classes = implode(' ', $item->classes);
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<li class=\"$classes\">\n";
            $output .= "\n$indent<a href='$item->url' class='header-category-item'>$item->title</a>\n";
        }

    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $promo_title = get_field('promo_title', 'option');
        $promo_description = get_field('promo_description', 'option');
        $promo_link = get_field('promo_link', 'option');
        $promo_link_title = $promo_link ? $promo_link['title'] : '';
        $promo_link_url = $promo_link ? $promo_link['url'] : '';
		$cta_header_title = get_field('cta_header_title', 'option');
        $cta_image = get_field('header_cta_image', 'option');
        $cta_button = get_field('header_cta_button', 'option');
        $cta_link_title = $cta_button ? $cta_button['title'] : '';
        $cta_link_url = $cta_button ? $cta_button['url'] : '';
        $indent = str_repeat("\t", $depth);
        if ($depth === 0 && $this->first_item) {
            if ($promo_title || $promo_description) {
                $output .= "\n$indent</li>\n";
                $output .= "\n$indent<li class='$depth'>\n";
                $output .= "\n$indent<div class='menu-content-block'>\n";
                $output .= "\n$indent<span>$promo_title</span>\n";
                $output .= "\n$indent<p>$promo_description</p>\n";
                if ($promo_link) {
                    $output .= "\n$indent<a href='$promo_link_url' class='outline-button'>$promo_link_title". return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button') ."</a>\n";
                }
                $output .= "\n$indent</div>\n";
            }

if ($cta_image || $cta_button) {
						$output .= "\n$indent</li>\n";
						$output .= "\n$indent<li class='$depth'>\n";
						$output .= "\n$indent<div class='menu-cta-block'>\n";
						
						// --- НОВЫЙ БЛОК: ССЫЛКА НА ИЗОБРАЖЕНИЕ И ЗАГОЛОВОК ---
						// Открываем тег <a> для изображения и заголовка
						$output .= "\n$indent<a href='$cta_link_url' class='menu-cta-link-area'>\n";
						
						if ($cta_image) {
							$image_html = wp_get_attachment_image($cta_image['id'], 'large', false, [
								'class' => 'cta-image'
							]);
							$output .= "\n$indent$image_html\n";
						}

						if ($cta_header_title) {
							// Добавляем заголовок внутрь той же ссылки <a>
							$output .= "\n$indent<h3 class='cta-title'>{$cta_header_title}</h3>\n";
						}
						
						// Закрываем тег <a>, который оборачивает изображение и заголовок
						$output .= "\n$indent</a>\n";
						// --------------------------------------------------------

						if ($cta_button) {
							// Ссылка для кнопки остается отдельной
							$output .= "\n$indent<a href='$cta_link_url' class='outline-button'>$cta_link_title"
								. return_svg(get_template_directory_uri().'/assets/images/arrow-button.svg', 'arrow-button')
								. "</a>\n";
						}

						$output .= "\n$indent</div>\n";
					}

        }
        $output .= "\n$indent</ul>\n";
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
    public function get_item_count() {
        return $this->item_count;
    }
}
