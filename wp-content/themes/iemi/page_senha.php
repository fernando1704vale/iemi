<?php/* Template Name: Senha */ ?>
<?php pg_password_action() ?>
<?php get_header(); ?>

	<div id="content" class="no-sidebar">
			
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
					if(is_user_logged_in() || $_GET){
						$args['type'] = 'pass';
					}
					pg_password_form( $args );
					
				?>
			</div>
			
	</div><?php // #content .entry ? ?>

<?php get_footer(); ?>
