<?php
/**
 * Template Name: Tank Journal Page
 */

get_header(); ?>

<div id="main-content" class="main-content">


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

				endwhile;
			?>
			<!-- Play Journal Entries -->
		<section>
		<header class="entry-header">
		<h2>Status Log:</h2>
		</header>
			<?php $loop = new WP_Query( array( 'post_type' => 'journal_entry', 'posts_per_page' => 10 ) ); ?>
			<?php 
				// Start the Loop again
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
						the_date('m-d-Y', '<header class="entry-header"><h3>', '</h3></header><!-- .entry-header -->');
					?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>

			<?php endwhile; ?>
		</section>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
