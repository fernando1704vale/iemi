<?php get_header(); ?>
	<div id="content" class="entry">

		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( 'Anterior', 'twentyten' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Posterior', 'twentyten' ) ); ?></div>
			</div><!-- #nav-above -->
		<?php endif; ?>
		
		<?php while ( have_posts() ) : the_post(); ?>
			<p class="entry-date"><?php echo get_the_date(); ?></p>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry-content">
				<?php the_excerpt(); ?>
				<p class="argt"><a href="<?php the_permalink(); ?>" class="btn">Veja Mais</a></p>
			</div>
			<hr />
			
		<?php endwhile; ?>
		
		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( '', 'twentyten' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Posterior', 'twentyten' ) ); ?></div>
			</div><!-- #nav-above -->
		<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
