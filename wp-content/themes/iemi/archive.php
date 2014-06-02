<?php get_header(); 
if (in_category('35')){ 		//Se for post da categoria press release ?>
<div id="imagem_ads">
	<a href="http://www.adsbrasil.com.br/"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/ads.png" /></a>
	<span id="assessoria_imprensa">Assessoria de Imprensa</span>
	
	<span id="assessoria_nome">Vera Santiago</span><span id="assessoria_telefone">+55 11 5090-3016 </span>
	<span id="email_assessoria">e-mail: veras@adsbrasil.com.br | <a href="http://www.adsbrasil.com.br/">www.adsbrasil.com.br</a></span>
</div>
<?php } ?>
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
			</div>
			<hr />
			
		<?php endwhile; ?>
		
		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link( __( 'Anterior', 'twentyten' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Posterior', 'twentyten' ) ); ?></div>
			</div><!-- #nav-above -->
		<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
