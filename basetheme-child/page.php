<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

get_header();

?>

<?php while ( have_posts() ): ?>
	<?php
		the_post();
	?>

	<div class="container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
					
			<h2><?php echo get_the_title(); ?></h2>
			<div class="s-flow-content">
				<?php the_content(); ?>
			</div>

		</article><!-- #post -->
	</div>
	
<?php endwhile; ?>

<?php get_footer(); ?>
