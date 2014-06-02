<?php get_header(); ?>
	<div id="content" class="entry">
		
		<h1>Resultado de busca para &quot;<?php echo $_GET['s']; ?>&quot;.</h1>

		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div id="nav-above" class="navigation">
				<div class="nav-next"><?php next_posts_link( __( 'Avançar', 'twentyten' ) ); ?></div>
				<div class="nav-previous"><?php previous_posts_link( __( 'Voltar', 'twentyten' ) ); ?></div>
			</div><!-- #nav-above -->
		<?php endif; ?>

		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="entry-content">
				<?php the_excerpt(); ?>
				<p class="argt"><a href="<?php the_permalink(); ?>" class="btn">Veja Mais</a></p>
			</div>
			<hr />
			
		<?php endwhile; ?>
		<?php else: ?>
		
		<div class="entry-content">
			<p>Nenhum resultado encontrado.</p>
		</div>
		
		<?php endif; ?>
		
		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div id="nav-below" class="navigation">
				<div class="nav-next"><?php next_posts_link( __( 'Avançar', 'twentyten' ) ); ?></div>
				<div class="nav-previous"><?php previous_posts_link( __( 'Voltar', 'twentyten' ) ); ?></div>
			</div><!-- #nav-above -->
		<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
