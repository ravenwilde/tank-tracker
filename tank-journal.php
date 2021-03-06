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
			
			<?php
				$terms = get_the_terms( $post->ID, 'tank-journal' );					
				if ( $terms && ! is_wp_error( $terms ) ) : 
					$termArr = array();
					foreach ( $terms as $term ) {
						$termArr[] = $term->slug;
					}				
					$taxSlug = $termArr[0];
				endif; ?>

			<?php $loop = new WP_Query( array( 'tank-journal' => $taxSlug, 'post_type' => 'journal_entry', 'posts_per_page' => 100 ) ); ?>
			<?php 
				// Start the Loop again
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php
						the_date('m-d-Y', '<header class="entry-header"><h3>', '</h3></header><!-- .entry-header -->');
					?>

					<div class="entry-content">
						<?php the_content(); ?>

						<?php 
							
							global $water_params_mb;
							$water_params_mb->the_meta(); ?>
							<ul class="water-parameters" >

						    <?php
							if ( null !== $water_params_mb->get_the_value('temp') ) {
							?>
								<li><span>Temp:</span> <?php echo $water_params_mb->the_value('temp'); ?></li>

							<?php } else { } ?>

							<?php
							if ( null !== $water_params_mb->get_the_value('ph') ) {
							?>
								<li><span>PH:</span> <?php echo $water_params_mb->the_value('ph'); ?></li>

							<?php } else { } ?>

							<?php
							if ( null !== $water_params_mb->get_the_value('ammo') ) {
							?>
								<li><span>Ammonia:</span> <?php echo $water_params_mb->the_value('ammo'); ?></li>

							<?php } else { } ?>

							<?php
							if ( null !== $water_params_mb->get_the_value('kh') ) {
							?>
								<li><span>KH:</span> <?php echo $water_params_mb->the_value('kh'); ?></li>

							<?php } else { } ?>

							<?php
							if ( null !== $water_params_mb->get_the_value('gh') ) {
							?>
								<li><span>GH:</span> <?php echo $water_params_mb->the_value('gh'); ?></li>

							<?php } else { } ?>

							</ul>
							
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
