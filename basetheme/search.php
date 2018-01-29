<?php

/**
 * The template for displaying Search Results pages.
 */

global $wp_query;

get_header(); 

?>

<div class="container">

	<article>
		
		<header class="">
			<h2 class=""><?php printf( __( 'Search Results for: %s', 'basetheme' ), '<span class="search-term">' . get_search_query() . '</span>' ); ?></h2>
		</header>

		<?php if ( have_posts() ): ?>
			
			<?php while ( have_posts() ): ?>
				<?php
					the_post();
				?>

				<?php get_template_part( 'content', get_post_format() ) ?>
				
			<?php endwhile; ?>

			<?php if ( $wp_query->max_num_pages > 1 ): ?>
				<?php 
					$big = 999999999; // need an unlikely integer

					echo paginate_links( array(
						'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'  => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total'   => $wp_query->max_num_pages
					) );
				?>
			<?php endif; ?>

		<?php else: ?>

			<article id="post-empty" class="post no-results not-found">
					
			<h2 class="title"><?php _e( 'Nothing Found', 'edge-template' ); ?></h2>
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'edge-template' ); ?></p>

		</article><!-- #post-empty -->
			<?php get_search_form(); ?>

		<?php endif; ?>
	
	</article>

</div>

<?php get_footer(); ?>
