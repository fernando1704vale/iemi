<?php/* Template Name: Cadastro */ ?>
<?php get_header(); ?>

	<div id="content" class="no-sidebar">	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
					global $current_user;
					get_currentuserinfo();
					
				 	$args['id'] = $current_user->ID;
					$args['type'] = get_user_meta($current_user->ID, 'type', true);
					
					if(wpsc_cart_item_count() > 0 || isset($_GET['full'])) {
						$args['full'] = true;
					} else {
						$args['full'] = false;
					}
					if(isset($_GET['carrinho'])) { $args['redirect_to'] = '/biblioteca/carrinho/'; }
					
					pg_register_form( $args ); 
				?>
			</div>
			
		<?php endwhile; ?>
	</div><?php // #content .entry ? ?>

<?php get_footer(); ?>
