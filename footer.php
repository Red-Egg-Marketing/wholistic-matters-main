<?php
/**
 * Footer
 */

$footer_contact_title = get_field('footer_contact_title', 'options');
$footer_contact_email = get_field('footer_contact_email', 'options');
$socials_title = get_field('socials_title', 'options');
?>

<!-- BEGIN of footer -->
<footer class="footer">
    <div class="grid-x footer-top-section grid-padding-x">
        <div class="logo-menu-wrap">
            <div class="footer__logo">
                <?php if ( $footer_logo = get_field( 'footer_logo', 'options' ) ):
                    $logo_image = wp_get_attachment_image( $footer_logo['id'], 'medium', false, [
                        'class'    => 'custom-logo',
                        'itemprop' => 'siteLogo',
                        'alt'      => get_bloginfo( 'name' ),
                    ] );
                    echo sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ), $logo_image );
                else:
                    show_custom_logo();
                endif; ?>

                <?php if ( $footer_logo_mobile = get_field( 'footer_logo_mobile', 'options' ) ):
                    $logo_image_mobile = wp_get_attachment_image( $footer_logo_mobile['id'], 'medium', false, [
                        'class'    => 'custom-logo',
                        'itemprop' => 'siteLogo',
                        'alt'      => get_bloginfo( 'name' ),
                    ] );
                    echo sprintf( '<a href="%1$s" class="cell custom-logo-link mobile" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ), $logo_image_mobile );
                else:
                    show_custom_logo();
                endif; ?>
                <div class="cell medium-3 footer__sp">
                    <p><?php echo $socials_title; ?></p>
                    <?php get_template_part( 'parts/socials' ); // Social profiles ?>
                </div>
            </div>
            <?php
            if ( has_nav_menu( 'footer-menu' ) ) {
                wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'footer-menu menu', 'depth' => 1 ) );
            }
            ?>
        </div>
        <div class="contact-block">
            <h2 class="contact-block-title"><?php echo $footer_contact_title; ?></h2>
<!--            <a class="contact-block-email" href="mailto:--><?php //echo $footer_contact_email?><!--">--><?php //echo $footer_contact_email; ?><!--</a>-->
            <button type="button" class="contact-block-email show-email">Click to show email</button>
        </div>
        <div class="newsletter-form-wrap <?php if(is_page('legal') || is_page('about-us') || is_page('contact-us')): echo 'desktop-form'; endif;?>">
            <h2 class="form_title">Sign up for emails</h2>
            <div id="hs-footer-newsletter-form">
            </div>
        </div>

    </div>

	<?php if ( $copyright = get_field( 'copyright', 'options' ) ): ?>
		<div class="footer__copy">
            <?php echo $copyright; ?>
        </div>
	<?php endif; ?>
</footer>
<!-- END of footer -->

<?php wp_footer(); ?>
</body>
</html>