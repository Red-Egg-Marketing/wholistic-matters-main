<?php
/**
 * @var array $block The block settings and attributes.
 * @var string $content The block inner HTML (empty).
 * @var bool $is_preview True during AJAX preview.
 * @var int|string $post_id The post ID this block is saved to.
 */
$accordion_main_cta_button = get_field('accordion_main_cta_button');
$accordion_name = get_field('accordion_name');
$accordion_description = get_field('accordion_description');
$accordion_conclusion = get_field('accordion_conclusion');
$accordion_list = get_field('accordion_list');
$count_courses = is_array($accordion_list) ? count($accordion_list) : 0;
$has_list = have_rows('accordion_list');
?>

<section class="<?php echo starter_section_class('acf-custom-accordion', $block); ?>">
    <ul class="accordions-list accordion" data-accordion data-allow-all-closed="true">
        <li class="accordion-item" data-accordion-item>
            <a class="accordion-title" href="#">
                <?php echo esc_html($accordion_name); ?>
                <?php if ($count_courses): ?>
                    <span> — <?php echo $count_courses; ?> CEs</span>
                <?php endif; ?>
            </a>

            <div class="accordion-content" data-tab-content>
                <?php if ($accordion_description): ?>
                    <div class="accordion-description-wrap">
                        <?php echo $accordion_description; ?>
                    </div>
                <?php endif; ?>

                <?php if ($has_list): ?>
                    <div class="accordion-content-wrap">
                        <?php while (have_rows('accordion_list')) : the_row();
                            $accordion_title = get_sub_field('accordion_title');
                            $accordion_content = get_sub_field('accordion_description');
                            $accordion_image = get_sub_field('accordion_image');
                            $accordion_link = get_sub_field('accordion_link');
                            $accordion_cta_button = get_sub_field('accordion_cta_button');
							
                            ?>
                            <div class="accordion-content-item">
                                <div class="accordion-text">
                                    <?php if (!empty($accordion_link['url'])): ?>
                                        <a style="color: #21201f; text-decoration: none;"
                                           target="<?php echo esc_attr($accordion_link['target'] ?? '_self'); ?>"
                                           href="<?php echo esc_url($accordion_link['url']); ?>">
                                            <span class="matchHeight"><?php echo esc_html($accordion_title); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($accordion_image['url'])): ?>
                                        <a target="<?php echo esc_attr($accordion_link['target'] ?? '_self'); ?>"
                                           href="<?php echo esc_url($accordion_link['url']); ?>">
                                            <img class="data-skip-lazy"
                                                 src="<?php echo esc_url($accordion_image['url']); ?>"
                                                 alt="<?php echo esc_attr($accordion_image['alt'] ?? ''); ?>">
                                        </a>
                                    <?php endif; ?>

                                    <?php if (empty($accordion_cta_button)) : ?>
                                        <p><?php echo $accordion_content; ?></p>
                                    <?php else: ?>
                                        <div class="accordion_cta_button">
                                            <a class="wp-block-button__link wp-element-button"
                                               href="<?php echo esc_url($accordion_cta_button['url']); ?>"
                                               target="<?php echo esc_attr($accordion_cta_button['target'] ?? '_self'); ?>">
                                                <?php echo esc_html($accordion_cta_button['title']); ?>
                                                <img decoding="async" class="wp-image-235 entered lazyloaded"
                                                     style="width: 15px;"
                                                     src="https://wholisticmatters.com/wp-content/themes/wholisticmatters/assets/images/Line%201.svg"
                                                     alt="">
                                                <noscript>
                                                    <img decoding="async" class="wp-image-235" style="width: 15px;"
                                                         src="https://wholisticmatters.com/wp-content/themes/wholisticmatters/assets/images/Line%201.svg"
                                                         alt="">
                                                </noscript>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
				
					<?php if ($accordion_main_cta_button): ?>
						<div class="accordion_cta_button2">
							<a class="wp-block-button__link wp-element-button" 
							   href="<?php echo esc_url($accordion_main_cta_button['url']); ?>" 
							   target="<?php echo esc_attr($accordion_main_cta_button['target'] ?? '_self'); ?>">
								<?php echo esc_html($accordion_main_cta_button['title']); ?>
								<img class="wp-image-235 entered lazyloaded" 
									 style="width: 15px;" 
									 src="https://wholisticmatters.com/wp-content/themes/wholisticmatters/assets/images/Line%201.svg" 
									 alt="" 
									 data-lazy-src="https://wholisticmatters.com/wp-content/themes/wholisticmatters/assets/images/Line%201.svg" 
									 data-ll-status="loaded" />
								<noscript>
									<img class="wp-image-235" style="width: 15px;" 
										 src="https://wholisticmatters.com/wp-content/themes/wholisticmatters/assets/images/Line%201.svg" 
										 alt="">
								</noscript>
							</a>
						</div>
					<?php endif; ?>

				

                <?php if ($accordion_conclusion): ?>
                    <div class="accordion-description-wrap">
                        <?php echo $accordion_conclusion; ?>
                    </div>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</section>
