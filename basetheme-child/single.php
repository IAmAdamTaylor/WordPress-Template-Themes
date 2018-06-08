<?php

/**
 * The Template for displaying all single posts
 *
 */

get_header(); 

?>

<?php while ( have_posts() ): ?>
	<?php
		the_post();
	?>

	<div class="container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
							
			<h2 class="title"><?php echo get_the_title(); ?></h2>
			<div class="s-flow-content">
				<?php the_content(); ?>
			</div>

		</article><!-- #post -->
	</div>
	
<?php endwhile; ?>

<?php get_footer(); ?>
