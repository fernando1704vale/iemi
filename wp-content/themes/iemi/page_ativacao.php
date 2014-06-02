<?php/* Template Name: Ativação */ ?>
<?php global $activated; if(is_user_logged_in() && !$activated) { header('location: /'); }?>
<?php get_header(); ?>

	<div id="content" class="no-sidebar">	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
					$args = array( 
						'activation' => true, 
						'action' => get_permalink().'?'.$_SERVER['QUERY_STRING'],
						'redirect_to' => get_permalink()
					); 
					pg_login_form( $args );
				?>
				
			</div>
			
		<?php endwhile; ?>
	</div><?php // #content .entry ? ?>

<?php get_footer(); ?>
