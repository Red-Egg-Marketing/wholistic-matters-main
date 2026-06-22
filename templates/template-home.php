<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>
    <main>
	<!--HOME PAGE SLIDER-->
        <?php home_slider_template(); ?>
	<!--END of HOME PAGE SLIDER-->
	
	<!-- BEGIN of main content -->
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        <?php endif; ?>

	<!-- END of main content -->

    </main>
<?php get_footer(); ?>