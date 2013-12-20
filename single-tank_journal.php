<?php
/**
 * The template for displaying a Tank Journal Page
 */

get_header(); ?>

<div id="main-content" class="main-content">
<!-- this is a single-tank_journal.php page -->
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<!-- Tank Journal Page Content -->
			<?php
			    $mypost = array( 'post_type' => 'tank_journal', );
			    $loop = new WP_Query( $mypost );
			    ?>
			<?php
				// Start the Loop.
				while ( $loop->have_posts() ) : $loop->the_post();?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							// Page thumbnail and title.
							twentyfourteen_post_thumbnail();
							the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
						?>

						<div class="entry-content">
						<!-- this is a single-tank_journal.php page -->
							<?php
								the_content();
								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								) );

								edit_post_link( __( 'Edit', 'twentyfourteen' ), '<span class="edit-link">', '</span>' );
							?>
						</div><!-- .entry-content -->
					</article><!-- #post-## -->

			<?php endwhile; ?>
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
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
